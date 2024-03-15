<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
  <?php include 'layouts/alert.php'; ?>

  <?php

  // $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  // $locked = (isset($_GET['i'])) ? $_GET['i'] : '';
  // if ($date) {
  //   $condition = [];
  //   // $condition = ['record_date' => $date ,'log_type' => 'upload'];
  // } else {
  //   $condition = [];
  // }


  // $listArr = $database->select('tab_status_lockupload', "*", $condition, "AND", 'multiple', 'date desc');
 
  $userList = $database->select('tab_user_details', "*", ['account_type' => 'station'], "AND", 'multiple');

  $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  $locked = (isset($_GET['i'])) ? $_GET['i'] : '';
  if ($date) {
    $condition = [];
    // $condition = ['record_date' => $date ,'log_type' => 'upload'];
  } else {
    $condition = [];
  }
  $type = isset($_GET['type']) ? $_GET['type'] : '';
  // echo $type;
  $listArray = "";
 if($type == "daily"){
  $listArr = $database->select('tab_status_lockupload', "*", $condition, "AND", 'multiple', 'date desc');
 }else{
  $listArr = $database->select(' lock_unlock_periodicals_balance_sheet', "*", $condition, "AND", 'multiple');
  $listArray = $database->select(' lock_unlock_periodicals_balance_sheet', "*", $condition, "AND", 'multiple');
 }
  ?>
  <div class="pagetitle">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">

            <div class="card-body d-none">

              <!-- <div class="selctdatas col-2 mt-4 mb-2">
                <input type="date" class="form-control" style="margin-bottom:10px;" id="recordDate" value="<?= $date ?? date('Y-m-d'); ?>"> 
                <button class="btn btn-success mt-1" id="unlock" <?php if ($locked == 0) : ?> style="display: none;" <?php else : ?> style="display: block;" <?php endif; ?>>Unlock</button>
                <button class="btn btn-danger mt-1" id="lock" <?php if ($locked == 0) : ?> style="display: show;" <?php else : ?> style="display: none;" <?php endif; ?>>Lock</button>

              </div> -->
              <!-- <div class=""> 
                <?php foreach ($userList as $user) :
                  $fileUpload = $database->select('tab_logs_fileupload', "*", ['station_name' => $user['stationname'], 'record_date' => $date], "AND", 'single');
                  if ($fileUpload) : ?>
                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> <?= strtoupper($user['stationname']); ?></span>
                  <?php else : ?>
                    <span class="badge bg-secondary"><i class="bi bi-star me-1"></i> <?= strtoupper($user['stationname']); ?></span>
                <?php endif;
                endforeach; ?>
              </div> -->


            </div>
          </div>

          <div class="card">

            <div class="card-body">
              <!-- <div class="action-buttons float-end mt-3 d-flex justify-content-around">
                <form class="row g-3 needs-validation" method="post" action="actions/ActionController.php" id="download-all-files-form">
                  <input type="hidden" name="type" value="download-all-files">
                  <input type="hidden" name="hiddenrecordDate2" value="<?= $date ?? date('Y-m-d'); ?>">
                  <button type="submit" class="btn btn-info" id="download-files-btn">Download All</button>
                </form>
              </div> -->
              <br>
              <div class="d-flex justify-content-between col-sm-2">
              <select name="file_type" class="form-control" id="file_type" <?php if($_SESSION['account_type'] == 'revenuecell'): ?>style="display: show;" <?php else : ?>style="display: none;" <?php endif ?> > 
                 <option value="periodic"  <?php if ($type == 'periodic') : ?> selected <?php endif; ?>>Periodic</option>
                 <option value="daily"   <?php if ($type == 'daily') : ?> selected <?php endif; ?>>Daily</option>
              </select>
              </div> <br>

              <div class="d-flex justify-content-between">
                <h5 class="card-title">Check Locked Status</h5>  
              </div>

               
              <!-- Table with stripped rows -->
              <table class="table datatable table-responsive table-hover">
              <?php if (!empty($listArr[0]['date'])): ?>
              <colgroup>
                 <col style="width: 250px;"> 
                 <col style="width: 250px;">
                 <col> 
              </colgroup>
              <?php else: ?>
                <colgroup>
                 <col style="width: 150px;"> 
                 <col style="width: 150px;">
                 <col> 
              </colgroup>
              <?php endif; ?>
                <thead>
                  <tr>   
                  <?php if($listArray) :?><th data-type="date" data-format="YYYY/DD/MM">Year</th><th data-type="date" data-format="YYYY/DD/MM">Month</th><th data-type="date" data-format="YYYY/DD/MM">Periodicals</th><?php else : ?><th data-type="date" data-format="YYYY/DD/MM">Record Date</th> <?php endif ?>
                    <th>Lock Status</th>
                    <th>Station Lock/Unlock status</th>
                  </tr>
                </thead>
                <tbody>
                
                  <?php foreach ($listArr as $list) : $count=0; $unlocked=[];?>
                    <tr id="<?= $list['id']; ?>"> 
                    <?php if (!empty($list['date'])): ?>
                            <td><?= $list['date']; ?></td>
                          <?php else: ?>
                            <td><?= $list['year'] ?></td>
                            <td><?= $list['month']; ?></td>
                            <td><?= $list['periodicals']; ?></td>
                          <?php endif; ?>
                      <td><?= ($list['lock_upload'] == '1' || $list['lock_upload'] == 'Locked') ? 'Locked' : 'Unlocked'; ?></td> 
                      <?php if (!empty($list['date'])): ?>
                      <td value="<?php echo $list['date'];?>">
                        <?php 
                          foreach ($userList as $user) :
                            $fileUpload = $database->select('tab_status_lockupload', "*", [$user['user_code'] => 1,'date' =>$list['date']], "AND", 'single');
                            $lock_upload = $database->select('tab_status_lockupload', "*", ['lock_upload' => 1,'date' =>$list['date']], "AND", 'single');
                            if (!$fileUpload) :
                              $count++;  
                              $unlocked[]=$user['user_code'];
                            endif;
                          endforeach; 
                          $user_count=count($userList); if($count == $user_count) :
                        ?> 
                        All station are un-locked 
                        <?php elseif($count == 0): ?>
                          All station are locked
                        <?php else:
                        foreach ($unlocked as $user) :
                          ?>
                            <button class="badge bg-secondary"><i class="bi bi-star me-1"></i>  <?= ($user) ? strtoupper($user) : strtoupper($user); ?></span>
                          <?php endforeach;
                        endif; ?>
                      </td> 
                      <?php else: ?>
                        <td value="<?php echo $list['month'];?>">
                        <?php 
                          foreach ($userList as $user) :
                            $fileUpload = $database->select('lock_unlock_periodicals_balance_sheet', "*", [$user['user_code'] => 1,'month' =>$list['month'], 'year' => $list['year'],  'periodicals' => $list['periodicals']], "AND", 'single');
                            $lock_upload = $database->select('lock_unlock_periodicals_balance_sheet', "*", ['lock_upload' => 1,'month' =>$list['month'], 'year' => $list['year'],  'periodicals' => $list['periodicals']], "AND", 'single');
                            if (!$fileUpload) :
                              $count++;  
                              $unlocked[]=$user['user_code'];
                            endif;
                          endforeach; 
                          $user_count=count($userList); if($count == $user_count) :
                        ?> 
                        All station are un-locked 
                        <?php elseif($count == 0): ?>
                          All station are locked
                        <?php else:
                        foreach ($unlocked as $user) :
                          ?>
                            <button class="badge bg-secondary"><i class="bi bi-star me-1"></i>  <?= ($user) ? strtoupper($user) : strtoupper($user); ?></span>
                          <?php endforeach;
                        endif; ?>
                      </td> 

                      <?php endif; ?>
                    </tr> 
                  <?php endforeach; ?>


                </tbody>
                <tfoot>
                  <tr>   
                  <?php if($listArray) :?><th data-type="date" data-format="YYYY/DD/MM">Year</th><th data-type="date" data-format="YYYY/DD/MM">Month</th><th data-type="date" data-format="YYYY/DD/MM">Periodicals</th><?php else : ?><th data-type="date" data-format="YYYY/DD/MM">Record Date</th> <?php endif ?>
                    <th>Lock Status</th> 
                    <th>Station Lock/Unlock status</th>
                  </tr>
                </tfoot>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

</main>

<?php include 'layouts/footer.php'; ?>
<style>
  .column1 {
    width: 100px; /* Set width for the first column */
}

.column2 {
    width: 150px; /* Set width for the second column */
}

</style>
<script>
  
$("#file_type").on("change", function() {
    var file_type = $(this).val(); // You can directly use $(this).val() to get the selected value
    
    var current = location.origin + location.pathname;
    var getDate = "";
    current += '?type=' + file_type;

    location.href = current;
  });
</script>