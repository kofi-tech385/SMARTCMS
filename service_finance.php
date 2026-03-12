<?php
include 'db.php';
include 'header.php'; // includes DOCTYPE, <head>, Bootstrap, and opening <body> tag

// Fetch all services for dropdown
$services = $conn->query("SELECT * FROM services ORDER BY service_date DESC");

// Handle submission
if(isset($_POST['submit'])){
    $service_id = $_POST['service_id'];
    $total_tithe = $_POST['total_tithe'] ?: 0;
    $total_offering = $_POST['total_offering'] ?: 0;
    $total_special = $_POST['total_special'] ?: 0;

    // Check if record for this service already exists
    $check = $conn->query("SELECT * FROM service_finance WHERE service_id = '$service_id'");
    if($check->num_rows > 0){
        // Update existing record
        $sql = "UPDATE service_finance SET 
                total_tithe = '$total_tithe',
                total_offering = '$total_offering',
                total_special = '$total_special'
                WHERE service_id = '$service_id'";
    } else {
        // Insert new record
        $sql = "INSERT INTO service_finance (service_id, total_tithe, total_offering, total_special)
                VALUES ('$service_id', '$total_tithe', '$total_offering', '$total_special')";
    }

    if($conn->query($sql) === TRUE){
        echo "<p class='alert alert-success mt-3'>Service finance saved successfully!</p>";
    } else {
        echo "<p class='alert alert-danger mt-3'>Error: " . $conn->error . "</p>";
    }
}
?>

<div class="container py-4">
    <h2>Record Service Finance</h2>

    <form method="POST" class="mb-5">
        <div class="mb-3">
            <label class="form-label">Select Service:</label>
            <select class="form-select" name="service_id" required>
                <option value="">-- Select Service --</option>
                <?php while($service = $services->fetch_assoc()){ ?>
                    <option value="<?php echo $service['id']; ?>">
                        <?php echo $service['service_name'] . " - " . $service['service_date']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Total Tithe (GHS):</label>
            <input type="number" step="0.01" name="total_tithe" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Total Offering (GHS):</label>
            <input type="number" step="0.01" name="total_offering" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Total Special Seed (GHS):</label>
            <input type="number" step="0.01" name="total_special" class="form-control">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Save Finance</button>
    </form>
</div>

<?php include 'footer.php'; // includes closing </body> and </html> ?>