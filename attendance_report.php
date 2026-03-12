<?php
include 'header.php';
include 'db.php';

// Fetch services
$services = $conn->query("SELECT * FROM services ORDER BY service_date DESC");

// Fetch attendance for selected service
$attendance_records = [];
if(isset($_POST['service_id'])){
    $service_id = $_POST['service_id'];

    $sql = "SELECT m.full_name, a.status 
            FROM attendance a
            JOIN members m ON a.member_id = m.id
            WHERE a.service_id = '$service_id'
            ORDER BY m.full_name ASC";

    $result = $conn->query($sql);

    if($result){
        $attendance_records = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<h2>Attendance Report</h2>

<form method="POST" class="mb-4">
    <div class="mb-3">
        <label class="form-label">Select Service:</label>

        <select class="form-select" name="service_id" required>
            <option value="">-- Select Service --</option>

            <?php while($service = $services->fetch_assoc()){ ?>

                <option value="<?php echo $service['id']; ?>"
                <?php if(isset($service_id) && $service_id == $service['id']) echo 'selected'; ?>>

                <?php echo $service['service_name'] . " - " . $service['service_date']; ?>

                </option>

            <?php } ?>
        </select>

    </div>

    <button type="submit" class="btn btn-primary">
        View Report
    </button>

</form>


<?php if(!empty($attendance_records)){ ?>

<table class="table table-bordered table-striped">

    <thead>
        <tr>
            <th>Member Name</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach($attendance_records as $record){ ?>

        <tr>
            <td><?php echo $record['full_name']; ?></td>
            <td><?php echo ucfirst($record['status']); ?></td>
        </tr>

    <?php } ?>

    </tbody>

</table>

<?php } elseif(isset($_POST['service_id'])){ ?>

<p class="alert alert-warning">
No attendance records found for this service.
</p>

<?php } ?>

<?php include 'footer.php'; ?>