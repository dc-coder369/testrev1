<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
  <?php include 'layouts/alert.php'; ?>

  <?php

  $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  $locked = (isset($_GET['i'])) ? $_GET['i'] : '';
  if ($date) {
    $condition = ['record_date' => $date ,'log_type' => 'upload'];
  } else {
    $condition = [];
  }


  $listArr = $database->select('tab_logs_fileupload', "*", $condition, "AND", 'multiple', 'current_time desc');

  //  $listArr = $database->select('tab_logs_fileupload', "*", [], "AND", 'multiple');
  $userList = $database->select('tab_user_details', "*", ['account_type' => 'station'], "AND", 'multiple');
  ?>
  <div class="pagetitle">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">

            <div class="card-body">

              <div class="selctdatas col-2 mt-4 mb-2">
                <input type="date" class="form-control" style="margin-bottom:10px;" id="recordDate" value="<?= $date ?? date('Y-m-d'); ?>">


                <button class="btn btn-success mt-1" id="unlock" <?php if ($locked == 0) : ?> style="display: none;" <?php else : ?> style="display: block;" <?php endif; ?>>Unlock</button>
                <button class="btn btn-danger mt-1" id="lock" <?php if ($locked == 0) : ?> style="display: show;" <?php else : ?> style="display: none;" <?php endif; ?>>Lock</button>

              </div>
              <div class="">
                <?php foreach ($userList as $user) :
                  $fileUpload = $database->select('tab_logs_fileupload', "*", ['station_name' => $user['stationname'], 'record_date' => $date], "AND", 'single');
                  if ($fileUpload) : ?>
                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> <?= strtoupper($user['stationname']); ?></span>
                  <?php else : ?>
                    <span class="badge bg-secondary"><i class="bi bi-star me-1"></i> <?= strtoupper($user['stationname']); ?></span>
                <?php endif;
                endforeach; ?>
              </div>


            </div>
          </div>

          <div class="card">

            <div class="card-body">
              <div class="action-buttons float-end mt-3 d-flex justify-content-around">
                <form class="row g-3 needs-validation" method="post" action="actions/ActionController.php" id="download-all-files-form">
                  <input type="hidden" name="type" value="download-all-files">
                  <input type="hidden" name="hiddenrecordDate2" value="<?= $date ?? date('Y-m-d'); ?>">
                  <button type="submit" class="btn btn-info" id="download-files-btn">Download All</button>
                </form>
              </div>

              <div class="d-flex justify-content-between">
                <h5 class="card-title">RevenueCell Data</h5>  
              </div>

               
              <!-- Table with stripped rows -->
              <table class="table datatable table-responsive table-hover">
                <thead>
                  <tr>  
                    <th>SC Name </th>
                    <th>Station Name</th>
                    <th>Filename</th> 
                    <th>Category</th> 
                    <th data-type="date" data-format="YYYY/DD/MM">Record Date</th>
                    <th>Upload Time</th>
                    <th>Remark</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listArr as $list) :
                    $path = 'actions/scdata/'. $list['folder_name'] . '/' . $list['filename'];
                  ?>
                   <tr id="<?= $list['id']; ?>"> 
                      <td><?= $list['Sc_Name']; ?></td>
                      <td><?= strtoupper($list['station_name']); ?></td>
                      <td><a href="<?= $path ?>" download target="_balnk"><?= $list['filename']; ?></a></td>
                      <td><?= $list['file_type']; ?></td>
                      
                      <td><?= $list['record_date']; ?></td>
                      <td><?= $list['current_time']; ?></td>
                      <td><?= $list['Remark']; ?></td>
                    </tr>

                  <?php endforeach; ?>


                </tbody>
                <tfoot>
                  <tr>  
                    <th>SC Name </th>
                    <th>Station Name</th>
                    <th>Filename</th> 
                    <th>Category</th> 
                    <th data-type="date" data-format="YYYY/DD/MM">Record Date</th>
                    <th>Upload Time</th>
                    <th>Remark</th>
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

<script>
  var today = "<?= date('Y-m-d'); ?>";
  var getDate = "<?= $date; ?>";
  var locked = "<?= $locked; ?>";
  console.log("Asd", locked)
  if (getDate == '') {
    getAjax(today);
  }

  $("#recordDate").on("change", function() {
    var val = $(this).val();
    getAjax(val);
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

        if (response.lock_upload == "1" || response.lock_upload == 1 || locked == 1) {
          $("#unlock").show();
          $("#lock").hide();
          current += '?date=' + val + '&i=' + response.lock_upload;

        } else {

          $("#unlock").hide();
          $("#lock").show();
          current += '?date=' + val + '&i=' + response.lock_upload;
        }
        location.href = current;


      },
      error: function(error) {
        // Handle the error here
        console.error("Error fetching data:", error);
      }
    });

  }


  function postAjax(date, lock_upload) {
    var current = location.origin + location.pathname;
    $.ajax({
      url: "actions/ActionController.php", // Replace with the actual API endpoint
      method: "post", // Use GET or POST depending on your API requirements
      data: {
        "type": "update_lock_status",
        date: date,
        'status': lock_upload
      }, // Pass any data you need to send to the server
      dataType: "json", // Specify the expected data type
      success: function(response) {
        if (response.lock_upload == "1" || response.lock_upload == 1) {
          $("#unlock").show();
          $("#lock").hide();
          current += '?date=' + date + '&i=' + response.lock_upload;

        } else {

          $("#unlock").hide();
          $("#lock").show();
          current += '?date=' + date + '&i=' + response.lock_upload;
        }
        location.href = current;
      },
      error: function(error) {
        // Handle the error here
        console.error("Error fetching data:", error);
      }
    });
  }

  $("#lock").click(function() {
    var date = $("#recordDate").val();
    postAjax(date, 1);
  })

  $("#unlock").click(function() {
    var date = $("#recordDate").val();
    postAjax(date, 0)
  })
</script>