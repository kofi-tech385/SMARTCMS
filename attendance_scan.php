<?php
include 'header.php';
include 'db.php';

$message = "";

if(isset($_POST['qr_code'])) {

    $qr_data = trim($_POST['qr_code']);

    // Case 1: QR contains ATTENDANCE:ID
    if(strpos($qr_data, 'ATTENDANCE:') === 0) {
        $member_id = intval(str_replace('ATTENDANCE:', '', $qr_data));
    }

    // Case 2: QR contains URL with member_id
    elseif(strpos($qr_data, 'member_id=') !== false) {
        parse_str(parse_url($qr_data, PHP_URL_QUERY), $params);
        $member_id = intval($params['member_id']);
    }

    else {
        $member_id = 0;
    }

    if($member_id > 0){

        // Check if member exists
        $member_check = $conn->prepare("SELECT full_name FROM members WHERE id = ?");
        $member_check->bind_param("i", $member_id);
        $member_check->execute();
        $result = $member_check->get_result();

        if($result->num_rows > 0){

            $member = $result->fetch_assoc();
            $name = $member['full_name'];

            // Record attendance
            $stmt = $conn->prepare("INSERT INTO attendance (member_id, date) VALUES (?, CURDATE())");
            $stmt->bind_param("i", $member_id);

            if($stmt->execute()){
                $message = "✅ Attendance marked for <strong>$name</strong>";
            } else {
                $message = "❌ Error marking attendance.";
            }

            $stmt->close();

        } else {

            $message = "❌ Member not found!";

        }

        $member_check->close();

    } else {

        $message = "❌ Invalid QR code!";

    }
}
?>

<h2>Scan Attendance</h2>

<?php if($message): ?>
<div class="alert alert-info"><?php echo $message; ?></div>
<?php endif; ?>

<form method="POST" class="mb-3">
<div class="input-group">

<input 
type="text" 
name="qr_code" 
class="form-control" 
placeholder="Scan or enter QR code text here"
autofocus 
required>

<button type="submit" class="btn btn-primary">
Submit
</button>

</div>
</form>

<?php include 'footer.php'; ?>