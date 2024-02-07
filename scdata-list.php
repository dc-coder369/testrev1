<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
  <?php include 'layouts/alert.php'; ?>


  <?php
  //  echo  $_SESSION['stationname']; die;
  $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  $locked = (isset($_GET['i'])) ? $_GET['i'] : '';
  if ($date) {
   $condition = ['record_date' => $date ,'log_type' => 'upload','station_name' => $_SESSION['stationname']];
  } else {
    $condition = [];
  }
  // echo "<prE>"; print_r($condition); die; 
  $listArr = $database->select('tab_logs_fileupload', "*", $condition, "AND", 'multiple','`current_time` desc');
  
  // echo "<prE>"; print_r($listArr); die; 
  ?>
  <div class="pagetitle">

    <section class="section">

      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Files</h5>

              <!-- Browser Default Validation -->
              <form class="g-3" method="post" enctype="multipart/form-data" id="uploadForm" action="actions/ActionController.php">

                <input type="hidden" name="type" value="upload-files">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">

                <div class="row mt-2">
                  <div class="col-md-6">
                    <label for="inputDate" class="col-sm-4 col-form-label">Date</label>
                    <div class="col-sm-4">
                      <input type="date" class="form-control" name="recordDate" id="recordDate" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>" min="2023-11-01" max="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
                    </div>
                  </div>
                </div>



                <div id="file-upload-area" <?php if ($locked) : ?> style="display: none;" <?php else : ?> style="display: block;" <?php endif; ?>>
                  <div class="row mt-2">
                     

                    <div class="col-md-6">
                      <label for="validationDefault04" class="form-label">Select File Type:</label>
                      <select class="form-control" name="fileType" id="select-file-type" required>
                        <?php foreach ($checkBoxArr as $check) : ?>
                          <option><?= $check; ?> </option>
                        <?php endforeach;  ?>
                      </select>

                      <span class="form-text text-muted">Select a Category of the File</span>
                    </div>


                    <div class="col-md-6">
                      <label for="validationDefault03" class="form-label">Choose a File:</label>
                      <input type="file" class="form-control" id="file1" name="files[]">
                      <span class="form-text text-muted">Upload File of the Selected Category</span>

                    </div>
                    <!-- <div class="col-md-6">
                      <label for="validationDefault04" class="form-label">Choose URC Images Only:</label>
                      <input type="file" class="form-control" id="file2" name="files2[]" accept="image/*, application/pdf" multiple>

                      <span class="form-text text-muted">Upload Scanned Images or PDFs of URC Receipts</span>
                    </div> -->
                  </div>
                  <div class="row mt-2 d-none">
                    <?php

                    

                    foreach ($checkBoxArr as $chekBox) { ?>
                      <div class="form-check">
                        <input class="form-check-input" name="fileType[<?= $chekBox; ?>]" type="checkbox" value="<?= $chekBox; ?>" id="flex<?= $chekBox; ?>">
                        <label class="form-check-label" for="flex<?= $chekBox; ?>">
                          <?= $chekBox; ?>
                        </label>
                      </div>

                    <?php } ?>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <label for="validationDefault03" class="form-label">Remark (Optional):</label>
                      <textarea class="form-control" name="remark" placeholder="Enter Remark"></textarea>
                    </div>
                    <div class="col-md-6">
                      <label for="inputDate" class="col-sm-2 col-form-label">Name of SC:</label>
                      <input type="text" class="form-control" name="sc_name" placeholder="Enter SC name" required>
                    </div>
                  </div>


                  <div class="row mt-2">
                    <div class="col-12">
                      <button class="btn btn-primary float-end" type="submit">Upload</button>
                    </div>
                  </div>
                </div>
              </form>
              <!-- End Browser Default Validation -->

            </div>
          </div>

        </div>


      </div>

      <div class="row">
        
        <div class="col-lg-12">
          
        
          <div class="card">

         

            <div class="card-body">
            <div class="action-buttons float-end mt-3 d-flex justify-content-around">
                <form class="row g-3 needs-validation" method="post" action="actions/ActionController.php" id="download-all-files-form">
                  <input type="hidden" name="type" value="download-all-files">
                  <input type="hidden" name="hiddenrecordDate2" value="<?= $date ?? date('Y-m-d'); ?>">
                  <button type="submit" class="btn btn-info" id="download-files-btn">Download All</button>
                </form>
              </div>
              <!-- <div class="action-buttons float-end mt-3">
                <a href="upload-files.php" class="btn btn-success">Upload Csv</a>   
            </div> -->

              <div class="d-flex justify-content-between">
                <h5 class="card-title">SC Data</h5>
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
                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($listArr as $list) :
                    $path = 'actions/scdata/' . $list['folder_name'] . '/' . $list['filename'];
                    $list['path']=$path;
                  ?>
                    <tr id="<?= $list['id']; ?>">
                     
                      <td><?= $list['Sc_Name']; ?></td>
                      <td><?= strtoupper($list['station_name']); ?></td>
                      <td><a href="#" onclick="SingleDownload(<?= htmlspecialchars(json_encode($list), ENT_QUOTES, 'UTF-8'); ?>)"><?= $list['filename']; ?></a></td>
                      <td><?= $list['original_filename']; ?></td>
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
                    <th>Filename (System)</th>
                    <th>Filename (Original)</th>
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

</main><!-- End #main -->

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
      
        if (response.lock_upload == "1" || response.lock_upload == 1) {
          
          $("#file-upload-area").hide();
          current += '?date=' + val + '&i=' + response.lock_upload;
          // alert("You can't upload file Locked from Backend"); 
        } else {
          current += '?date=' + val + '&i=' + response.lock_upload;
          $("#file-upload-area").show();
        }
        location.href = current;

      },
      error: function(error) {
        // Handle the error here
        console.error("Error fetching data:", error);
      }
    });

  }

  $("#select-file-type").change(function(){
    var vd = $(this).find(":selected").val(); 
    if(vd == "URC Images"){
      $("#file1").prop('multiple',true);
    }else{
      $("#file1").removeAttr('multiple');
    }
  })

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