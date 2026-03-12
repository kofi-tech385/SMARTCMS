<?php
include 'header.php';
include 'db.php';

$members = $conn->query("SELECT id, full_name FROM members ORDER BY full_name ASC");
?>

<h2>View Member QR Codes</h2>

<div class="row">
    <?php while($member = $members->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $member['full_name']; ?></h5>
                    <?php $qr_path = "qr_codes/member_{$member['id']}.png"; ?>
                    <?php if(file_exists($qr_path)): ?>
                        <img src="<?php echo $qr_path; ?>" alt="QR Code for <?php echo $member['full_name']; ?>" class="img-fluid" />
                    <?php else: ?>
                        <p class="text-muted">QR code not generated yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>