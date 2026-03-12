<?php
include 'header.php';
include 'db.php';
require_once __DIR__ . '/phpqrcode/qrlib.php';

$message = "";

if(isset($_POST['member_id'])){
    $member_id = $_POST['member_id'];
    
    // Fetch member name
    $stmt = $conn->prepare("SELECT full_name FROM members WHERE id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $member = $result->fetch_assoc();
    $member_name = $member ? $member['full_name'] : 'Unknown';
    $stmt->close();

    // Create QR folder if it doesn't exist
    if(!file_exists('qr_codes')){
        mkdir('qr_codes', 0777, true);
    }

    // QR file path
    $filePath = "qr_codes/member_{$member_id}.png";

    // IMPORTANT: This is the content that goes into the QR
    $content = "http://localhost/church_system/scan_attendance.php?member_id=".$member_id;

    // Generate QR code
    QRcode::png($content, $filePath, 'H', 10, 4);

    $message = "QR code generated for $member_name!";
    $show_qr = $filePath;
}

$members = $conn->query("SELECT * FROM members ORDER BY full_name ASC");
?>

<h2>Generate Member QR Code</h2>

<?php if($message): ?>
<div class="alert alert-success"><?php echo $message; ?></div>

<div class="mt-3">
<h5>Generated QR Code:</h5>
<img src="<?php echo $show_qr; ?>" alt="QR Code" class="img-fluid"/>
</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">
<label class="form-label">Select Member:</label>

<select name="member_id" class="form-select" required>
<option value="">-- Select Member --</option>

<?php while($member = $members->fetch_assoc()): ?>

<option value="<?php echo $member['id']; ?>">
<?php echo $member['full_name']; ?>
</option>

<?php endwhile; ?>

</select>
</div>

<button type="submit" class="btn btn-primary">Generate QR</button>

</form>

<?php include 'footer.php'; ?>