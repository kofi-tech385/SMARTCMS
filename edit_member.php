<?php
include 'header.php';
include 'db.php';

// 1️⃣ Check if member ID is provided
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    echo "<div class='alert alert-danger'>Invalid member ID.</div>";
    include 'footer.php';
    exit;
}

$member_id = (int)$_GET['id'];

// 2️⃣ Fetch existing member details
$stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "<div class='alert alert-danger'>Member not found.</div>";
    include 'footer.php';
    exit;
}

$member = $result->fetch_assoc();

// 3️⃣ Handle form submission
if(isset($_POST['submit'])){
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $address = $_POST['address'];
    $date_joined = $_POST['date_joined'];

    $update = $conn->prepare("UPDATE members SET full_name=?, phone=?, email=?, department=?, address=?, date_joined=? WHERE id=?");
    $update->bind_param("ssssssi", $full_name, $phone, $email, $department, $address, $date_joined, $member_id);

    if($update->execute()){
        // 4️⃣ Redirect to members page with success message
        header("Location: add_member.php?msg=updated");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error updating member: ".$conn->error."</div>";
    }
}
?>

<h2 class="mb-4">Edit Member</h2>

<form method="POST" class="mb-5">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($member['full_name']); ?>" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($member['phone']); ?>">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($member['email']); ?>">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Department</label>
            <input type="text" name="department" class="form-control" value="<?php echo htmlspecialchars($member['department']); ?>">
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control"><?php echo htmlspecialchars($member['address']); ?></textarea>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Date Joined</label>
            <input type="date" name="date_joined" class="form-control" value="<?php echo $member['date_joined']; ?>">
        </div>
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Update Member</button>
</form>

<?php include 'footer.php'; ?>