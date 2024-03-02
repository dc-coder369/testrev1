<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
  <?php include 'layouts/alert.php'; ?>

  <?php

  $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  $locked = (isset($_GET['i'])) ? $_GET['i'] : '';
  if ($date) {
    $condition = ['record_date' => $date, 'log_type' => 'upload'];
  } else {
    $condition = [];
  }
  $type = (isset($_GET['type'])) ? $_GET['type'] : '';


  $listArr = $database->select('tab_logs_fileupload', "*", $condition, "AND", 'multiple', '`upload_time` desc');

  // $listArr = $database->select('tab_status_lockupload', "*", [], "AND", 'multiple');
  $userList = $database->select('tab_user_details', "*", ['account_type' => 'station'], "AND", 'multiple');
  ?>

<div class="pagetitle">

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">

        <div class="card-body">

          <div class="selctdatas col-6 mt-4 mb-2">

          <div class="d-flex justify-content-around col-sm-4"> 
              <input type="date" class="form-control ml-2" style="margin-bottom:10px;" id="recordDate" value="<?= $date ?? date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>">
          </div> 
          <div class="d-flex justify-content-around col-sm-4">
            <select name="file_type" class="form-control" id="file_type"> 
              <option value="periodic"  <?php if ($type == 'periodic') : ?> selected <?php endif; ?>>Periodic</option>
              <option value="daily"   <?php if ($type == 'daily') : ?> selected <?php endif; ?>>Daily</option>
            </select>
          </div>  
          </div>
          <div class="periodic" <?php if ($type == 'periodic') : ?> style="display: show;" <?php else : ?> style="display: none;" <?php endif; ?>>
            <?php foreach ($userList as $user) :
              $fileUpload = $database->select('tab_status_lockunlock_periodicals', "*", [$user['user_code'] => 1,'date' => $date], "AND", 'single');
              if ($fileUpload) :?>
                <button id="periodic_unlock" onclick="lockAjax('<?= $date ?>', 0, '<?= $user['user_code'] ?>')" class="badge bg-success"><i class="bi bi-check-circle me-1"></i> <?= ($user['user_code']) ? strtoupper($user['user_code']) : strtoupper($user['stationname']); ?></button>
              <?php else :?>
                <button id="periodic_lock" onclick="lockAjax('<?= $date ?>', 1, '<?= $user['user_code'] ?>')" class="badge bg-secondary"><i class="bi bi-star me-1"></i>  <?= ($user['user_code']) ? strtoupper($user['user_code']) : strtoupper($user['stationname']); ?></span>
            <?php endif;
            endforeach; ?>
          </div>

          <div class="daily" <?php if ($type == 'daily') : ?> style="display: show;" <?php else : ?> style="display: none;" <?php endif; ?>>
            <?php foreach ($userList as $user) :
              $fileUpload = $database->select('tab_status_lockupload', "*", [$user['user_code'] => 1,'date' => $date], "AND", 'single');
              if ($fileUpload) :?>
                <button id="unlock" onclick="lockAjax('<?= $date ?>', 0, '<?= $user['user_code'] ?>')" class="badge bg-success"><i class="bi bi-check-circle me-1"></i> <?= ($user['user_code']) ? strtoupper($user['user_code']) : strtoupper($user['stationname']); ?></button>
              <?php else :?>
                <button id="lock" onclick="lockAjax('<?= $date ?>', 1, '<?= $user['user_code'] ?>')" class="badge bg-secondary"><i class="bi bi-star me-1"></i>  <?= ($user['user_code']) ? strtoupper($user['user_code']) : strtoupper($user['stationname']); ?></span>
            <?php endif;
            endforeach; ?>
          </div>

        </div>
      </div>

      <div class="card">
         
      </div>

    </div>
  </div>
</section>

</main>
<?php include 'layouts/footer.php'; ?>
<script>
  console.log("Asd")
  var today = "<?= date('Y-m-d'); ?>";
  var getDate = "<?= $date; ?>";
  if (getDate == '') {
    getAjax(today);
  }
  //
  $("#recordDate").on("change", function() {
    var val = $(this).val();
    getAjax(val);
  });
  $("#file_type").on("change", function() {
    var file_type = $(this).val(); // You can directly use $(this).val() to get the selected value
    
    var current = location.origin + location.pathname;
    var getDate = "<?= $date; ?>";
    current += '?date=' + getDate + '&type=' + file_type ;
    location.href = current;
  });

  function getAjax(val) {

    $.ajax({
      url: "actions/ActionController.php", // Replace with the actual API endpoint
      method: "GET", // Use GET or POST depending on your API requirements
      data: {
        "type": "local_unlock_status",
        date: val
      }, // Pass any data you need to send to the server
      dataType: "json", // Specify the expected data type
      success: function(response) {
        var current = location.origin + location.pathname;
        var file_type = document.getElementById("file_type").value;
        if (response == "1" || response == 1) {
          current += '?date=' + val + '&type=' + file_type ;
          // alert("You can't upload file Locked from Backend"); 
        } else {
          current += '?date=' + val + '&type=' + file_type ;
        }
        location.href = current;

      },
      error: function(error) {
        // Handle the error here
        console.error("Error fetching data:", error);
      }
    });

  }
  function lockAjax(date,lock_upload, user_code='') {
    var current = location.origin + location.pathname;
    var file_type = document.getElementById("file_type").value;
    console.log(lock_upload);
    $.ajax({
      url: "actions/ActionController.php", // Replace with the actual API endpoint
      method: "post", // Use GET or POST depending on your API requirements
      data: {
        type: "update_lock_status_station",
        date: date,
        user_code :user_code,
        'status': lock_upload,
        'file_type':file_type,
      }, // Pass any data you need to send to the server
      dataType: "json", // Specify the expected data type
      success: function(response) {
        current += '?date=' + date + '&type=' + file_type ;
        location.href = current;
      },
      error: function(error) {
        // Handle the error here
        console.error("Error fetching data:", error);
      }
    });
  }  
</script>