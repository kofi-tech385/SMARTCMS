<?php
include 'db.php';
include 'header.php'; // includes DOCTYPE, <head>, Bootstrap, and opening <body> tag

// Fetch members
$members = $conn->query("SELECT * FROM members ORDER BY full_name ASC");

// Handle submission
if(isset($_POST['submit'])){
    $member_id = $_POST['member_id'];
    $project_name = $_POST['project_name'];
    $amount = $_POST['amount'];
    $contribution_date = $_POST['contribution_date'];

    $sql = "INSERT INTO fundraising_contributions (member_id, project_name, amount, contribution_date)
            VALUES ('$member_id', '$project_name', '$amount', '$contribution_date')";
    if($conn->query($sql) === TRUE){
        echo "<p class='alert alert-success mt-3'>Contribution recorded successfully!</p>";
    } else {
        echo "<p class='alert alert-danger mt-3'>Error: " . $conn->error . "</p>";
    }
}
?>

<div class="container py-4">
    <h2>Add Fundraising Contribution</h2>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Member:</label>
            <select class="form-select" name="member_id" required>
                <option value="">-- Select Member --</option>
                <?php while($member = $members->fetch_assoc()){ ?>
                    <option value="<?php echo $member['id']; ?>">
                        <?php echo $member['full_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Project Name:</label>
            <input type="text" name="project_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount (GHS):</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contribution Date:</label>
            <input type="date" name="contribution_date" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Save Contribution</button>
    </form>
</div>

<?php include 'footer.php'; // includes closing </body> and </html> ?>