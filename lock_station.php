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
          <!-- <div class="d-flex justify-content-around col-sm-4">
            <select name="station_name" class="form-control" id="station_name">
            <option value="all" selected>All Station </option>
              <?php foreach ($userList as $user) :?>
                <option value="<?=($user['user_code']) ? $user['user_code'] : $user['username']; ?>"
                
                > <?=$user['username']; ?> </option>
              <?php  endforeach; ?>
            </select>
          </div>  -->
            <button class="btn btn-success mt-1" id="unlock" <?php if ($locked == 0) : ?> style="display: none;" <?php else : ?> style="display: block;" <?php endif; ?>>Unlock</button>
            <button class="btn btn-danger mt-1" id="lock" <?php if ($locked == 0) : ?> style="display: show;" <?php else : ?> style="display: none;" <?php endif; ?>>Lock</button>

          </div>
          <div class="">
            <?php foreach ($userList as $user) :
              $fileUpload = $database->select('tab_logs_fileupload', "*", ['station_name' => $user['stationname'], 'record_date' => $date], "AND", 'single');
              if ($fileUpload) : ?>
                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> <?= ($user['user_code']) ? strtoupper($user['user_code']) : strtoupper($user['stationname']); ?></span>
              <?php else : ?>
                <span class="badge bg-secondary"><i class="bi bi-star me-1"></i>  <?= ($user['user_code']) ? strtoupper($user['user_code']) : strtoupper($user['stationname']); ?></span>
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