<?php
include 'db.php';
include 'header.php'; // includes DOCTYPE, <head>, Bootstrap, and opening <body> tag

// Fetch all fundraising contributions with member names
$sql = "SELECT f.project_name, f.amount, f.contribution_date, m.full_name
        FROM fundraising_contributions f
        LEFT JOIN members m ON f.member_id = m.id
        ORDER BY f.contribution_date DESC";
$result = $conn->query($sql);
?>

<div class="container py-4">
    <h2>Fundraising Contributions Report</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Member Name</th>
                <th>Project Name</th>
                <th>Amount (GHS)</th>
                <th>Contribution Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $row['full_name'] ?: 'Anonymous'; ?></td>
                        <td><?php echo $row['project_name']; ?></td>
                        <td><?php echo number_format($row['amount'], 2); ?></td>
                        <td><?php echo $row['contribution_date']; ?></td>
                    </tr>
                <?php }
            } else { ?>
                <tr><td colspan="4">No fundraising contributions found.</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; // includes closing </body> and </html> ?>