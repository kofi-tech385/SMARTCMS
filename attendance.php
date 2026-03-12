<?php
include 'db.php';
include 'header.php'; // include header with DOCTYPE, <head>, Bootstrap, etc.

// Fetch all services for dropdown
$services = $conn->query("SELECT * FROM services ORDER BY service_date DESC");

// Fetch all members
$members = $conn->query("SELECT * FROM members ORDER BY full_name ASC");

// Handle attendance submission
if(isset($_POST['submit']) && isset($_POST['status'])){
    $service_id = $_POST['service_id'];
    foreach($_POST['status'] as $member_id => $status){
        $sql = "INSERT INTO attendance (member_id, service_id, status) 
                VALUES ('$member_id', '$service_id', '$status')";
        $conn->query($sql);
    }
    echo "<p class='alert alert-success mt-3'>Attendance recorded successfully!</p>";
}
?>

<div class="container py-4">
    <h2>Mark Attendance</h2>

    <form method="POST" class="mb-4">
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

        <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <th>Member Name</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if($members->num_rows > 0){
          while($member = $members->fetch_assoc()){ ?>
              <tr>
                  <td><?php echo $member['full_name']; ?></td>
                  <td>
                      <select name="status[<?php echo $member['id']; ?>]" class="form-select">
                          <option value="present">Present</option>
                          <option value="absent">Absent</option>
                      </select>
                  </td>
              </tr>
          <?php }
      } else { ?>
          <tr>
              <td colspan="2">No members found. Please add members first.</td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
            <thead class="table-dark">
                <tr>
                    <th>Member Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($members->num_rows > 0){
                while($member = $members->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $member['full_name']; ?></td>
                        <td>
                            <select name="status[<?php echo $member['id']; ?>]" class="form-select">
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                            </select>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="2">No members found. Please add members first.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <button type="submit" name="submit" class="btn btn-primary">Save Attendance</button>
    </form>
</div>

<?php include 'footer.php'; // include footer with </body> and </html> ?>