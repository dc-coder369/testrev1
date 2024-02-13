<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
  <?php include 'layouts/alert.php'; ?>

  <?php

  $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  $locked = (isset($_GET['i'])) ? $_GET['i'] : '';
  if ($date) {
    $condition = ['record_date' => $date ,'log_type' => 'upload','uploaded_for'=>'revenuecell'];
  } else {
    $condition = ['log_type' => 'upload','uploaded_for'=>'revenuecell'];
  }


  $listArr = $database->select('tab_logs_fileupload', "*", $condition, "AND", 'multiple', '`upload_time` desc');
 
  $userList = $database->select('tab_user_details', "*", ['account_type' => 'station'], "AND", 'multiple');
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

              <div class="d-flex justify-content-between">
                <h5 class="card-title">Uploaded File Logs</h5>  
              </div>

               
              <!-- Table with stripped rows -->
              <table class="table datatable table-responsive table-hover">
                <thead>
                  <tr>  
                    <th>SC Name </th>
                    <th>Station Name</th>
                    <th>Filename (System)</th>
                    <th>Filename (Original)</th>
                    <th>Category</th> 
                    <th data-type="date" data-format="YYYY/DD/MM">Record Date</th>
                    <th>Upload Time</th>
                    <th>Remark</th>
                    <?php if($_SESSION['account_type'] == 'admin'):?>  <th>HostName</th><?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listArr as $list) :
                    $path = 'actions/scdata/'. $list['folder_name'] . '/' . $list['filename'];
                    $list['path']=$path;
                  ?>
                   <tr id="<?= $list['id']; ?>"> 
                      <td><?= $list['Sc_Name']; ?></td>
                      <td><?= strtoupper($list['station_name']); ?></td>
                      <td><a href="#" onclick="SingleDownload(<?= htmlspecialchars(json_encode($list), ENT_QUOTES, 'UTF-8'); ?>)"><?= $list['filename']; ?></a></td>
                      <td><?= $list['original_filename']; ?></td>
                      <td><?= $list['file_type']; ?></td>
                      <td><?= $list['record_date']; ?></td>
                      <td><?= $list['upload_time']; ?></td>
                      <td><?= $list['Remark']; ?></td>
                      <?php if($_SESSION['account_type'] == 'admin'):?>   <td><?= $list['hostname']; ?></td> <?php endif; ?>
                    </tr>

                  <?php endforeach; ?>


                </tbody>
                <tfoot>
                  <tr>  
                    <th>SC Name </th>
                    <th>Station Name</th>
                    <th>Filename (System)</th>
                    <th>Filename (Original)</th>
                    <th>Category</th> 
                    <th data-type="date" data-format="YYYY/DD/MM">Record Date</th>
                    <th>Upload Time</th>
                    <th>Remark</th>
                    <?php if($_SESSION['account_type'] == 'admin'):?>  <th>HostName</th><?php endif; ?>
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
  function SingleDownload(val) { 
    $.ajax({ 
      url: "actions/ActionController.php", // Replace with the actual API endpoint
      method: "GET", // Use GET or POST depending on your API requirements
      data: {
        "type": "create log for single file",
        "path": val.path,
        "Sc_name": val.Sc_Name,
        "file_type": val.file_type,
        "station_name": val.station_name,
        "record_date": val.record_date,
        "fileName": val.filename,
      }, // Pass any data you need to send to the server
      dataType: "json", // Specify the expected data type
      success: function(response) {
        var path = response.filepath
        var link = document.createElement('a');
          link.href = path;
          link.target = "_blank"; // Open in a new tab
          link.download = path.split('/').pop(); // Set the filename to be downloaded

          // Simulate a click event to trigger the download
          document.body.appendChild(link);
          link.click(); 
          // Clean up
          document.body.removeChild(link);
      },
      error: function(error) {
        // Handle the error here
        console.error("Error fetching data:", error);
      }
    }); 
  }
  </script>
 
 