<?php
include 'db.php';
include 'header.php'; // includes DOCTYPE, <head>, Bootstrap, and opening <body> tag

// Handle service submission
if(isset($_POST['submit'])){
    $service_name = $_POST['service_name'];
    $service_date = $_POST['service_date'];

    $sql = "INSERT INTO services (service_name, service_date) VALUES ('$service_name', '$service_date')";
    if($conn->query($sql) === TRUE){
        echo "<p class='alert alert-success mt-3'>Service added successfully!</p>";
    } else {
        echo "<p class='alert alert-danger mt-3'>Error: " . $conn->error . "</p>";
    }
}

// Fetch all services
$services = $conn->query("SELECT * FROM services ORDER BY service_date DESC");
?>

<div class="container py-4">
    <h2>Services</h2>

    <!-- Add Service Form -->
    <form method="POST" class="mb-5">
        <div class="mb-3">
            <label class="form-label">Service Name:</label>
            <input type="text" name="service_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Service Date:</label>
            <input type="date" name="service_date" class="form-control" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Add Service</button>
    </form>

    <!-- Services Table -->
    <h3>Existing Services</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Service Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if($services->num_rows > 0){
                while($service = $services->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $service['service_name']; ?></td>
                        <td><?php echo $service['service_date']; ?></td>
                    </tr>
                <?php }
            } else { ?>
                <tr><td colspan="2">No services found.</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; // includes closing </body> and </html> ?>