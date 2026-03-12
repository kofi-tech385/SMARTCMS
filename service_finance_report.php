<?php
include 'db.php';
include 'header.php'; // includes DOCTYPE, <head>, Bootstrap, and opening <body> tag

// Fetch services with finance
$sql = "SELECT s.service_name, s.service_date, f.total_tithe, f.total_offering, f.total_special
        FROM services s
        LEFT JOIN service_finance f ON s.id = f.service_id
        ORDER BY s.service_date DESC";
$result = $conn->query($sql);
?>

<div class="container py-4">
    <h2>Service Finance Report</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Service Date</th>
                <th>Total Tithe (GHS)</th>
                <th>Total Offering (GHS)</th>
                <th>Total Special Seed (GHS)</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $row['service_name']; ?></td>
                        <td><?php echo $row['service_date']; ?></td>
                        <td><?php echo $row['total_tithe'] ?: 0; ?></td>
                        <td><?php echo $row['total_offering'] ?: 0; ?></td>
                        <td><?php echo $row['total_special'] ?: 0; ?></td>
                    </tr>
                <?php }
            } else { ?>
                <tr><td colspan="5">No records found.</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; // includes closing </body> and </html> ?>