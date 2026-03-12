<?php
// Include header (header.php should already include db.php)
include 'header.php';
require_once __DIR__ . '/phpqrcode/qrlib.php';

// Handle member submission safely
if(isset($_POST['submit'])){
    $full_name   = $_POST['full_name'];
    $phone       = $_POST['phone'];
    $email       = $_POST['email'];
    $department  = $_POST['department'];
    $address     = $_POST['address'];
    $date_joined = $_POST['date_joined'];

    // Prepared statement to prevent SQL errors
    $stmt = $conn->prepare("INSERT INTO members (full_name, phone, email, department, address, date_joined) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $full_name, $phone, $email, $department, $address, $date_joined);

    if($stmt->execute()){
        $member_id = $conn->insert_id;
        
        // Generate QR code for the new member
        $filePath = "qr_codes/member_{$member_id}.png";
        if(!file_exists('qr_codes')){
            mkdir('qr_codes', 0777, true);
        }
        $content = "ATTENDANCE:$member_id";
        \QRcode::png($content, $filePath, 'M', 10, 4);
        
        // Redirect with a GET parameter for message
        header("Location: add_member.php?msg=added");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Fetch existing members
$members = $conn->query("SELECT * FROM members ORDER BY full_name ASC");
?>

<h2>Add Members</h2>

<!-- Display success messages -->
<?php
if(isset($_GET['msg'])){
    $msgText = '';
    if($_GET['msg'] == 'added'){
        $msgText = 'Member added successfully!';
    } elseif($_GET['msg'] == 'updated'){
        $msgText = 'Member updated successfully!';
    } elseif($_GET['msg'] == 'deleted'){
        $msgText = 'Member deleted successfully!';
    }

    if($msgText !== '') {
        echo "<div id='alertMessage' class='alert alert-success'>{$msgText}</div>";
    }
}
?>

<!-- Add Member Form -->
<form method="POST" class="mb-5">
  <div class="row">

    <div class="col-md-6 mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="full_name" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label">Department</label>
      <input type="text" name="department" class="form-control">
    </div>

    <div class="col-md-12 mb-3">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control"></textarea>
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label">Date Joined</label>
      <input type="date" name="date_joined" class="form-control">
    </div>

  </div>

  <button type="submit" name="submit" class="btn btn-primary">Add Member</button>
</form>

<hr>

<h3 class="mb-3">Existing Members</h3>

<!-- Search Bar -->
<div class="mb-3">
  <input type="text" id="memberSearch" class="form-control" placeholder="🔎 Search members by name, department, phone...">
</div>

<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" id="membersTable">
    <thead class="table-dark">
      <tr>
        <th>Full Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Department</th>
        <th>Address</th>
        <th>Date Joined</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if($members->num_rows > 0): ?>
        <?php while($member = $members->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($member['full_name']); ?></td>
            <td><?php echo htmlspecialchars($member['phone']); ?></td>
            <td><?php echo htmlspecialchars($member['email']); ?></td>
            <td><?php echo htmlspecialchars($member['department']); ?></td>
            <td><?php echo htmlspecialchars($member['address']); ?></td>
            <td><?php echo htmlspecialchars($member['date_joined']); ?></td>
            <td>
              <a href="edit_member.php?id=<?php echo $member['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="delete_member.php?id=<?php echo $member['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center">No members found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Search Script -->
<script>
document.getElementById("memberSearch").addEventListener("keyup", function() {
  let filter = this.value.toLowerCase();
  let rows = document.querySelectorAll("#membersTable tbody tr");

  rows.forEach(row => {
    let text = row.textContent.toLowerCase();
    row.style.display = text.includes(filter) ? "" : "none";
  });
});

// Auto-hide alert after 3 seconds
window.addEventListener('DOMContentLoaded', () => {
    const alert = document.getElementById('alertMessage');
    if(alert){
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000); // 3 seconds
    }
});
</script>
<!-- Message card above your existing search box -->
<div id="searchMessage" class="card text-white bg-danger mb-2" style="display:none; max-width: 250px; font-size:0.9rem;">
    <div class="card-body p-2">
        Member not found
    </div>
</div>

<script>
document.getElementById("memberSearch").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#membersTable tbody tr");
    let anyVisible = false;

    rows.forEach(row => {
        if(row.id === "noMemberRow") return; // skip special row if exists
        let text = row.textContent.toLowerCase();
        if(text.includes(filter)){
            row.style.display = "";
            anyVisible = true;
        } else {
            row.style.display = "none";
        }
    });

    // Show or hide the message card
    let messageDiv = document.getElementById("searchMessage");
    if(!anyVisible && filter.length > 0){
        messageDiv.style.display = "block";
    } else {
        messageDiv.style.display = "none";
    }
});
</script>
<?php include 'footer.php'; ?>