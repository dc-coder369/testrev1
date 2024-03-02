<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
  <?php include 'layouts/alert.php'; ?>


  <?php
 
  
  
  $fileTypesArray=['PR','URC','RM','OS','MC','FOF','1stP','2ndP','3rdP','BS','CF','DR-CSC-CST'];
  $periodical_number=['Periodical 1','Periodical 2','Periodical 3','Balance Sheet'];
  $months = array(
      "January", 
      "February", 
      "March", 
      "April", 
      "May", 
      "June", 
      "July", 
      "August", 
      "September", 
      "October", 
      "November", 
      "December"
  );
  $currentYear = date("Y");

  // Set the range of years you want to include in the dropdown
  $startYear = $currentYear - 20; // 10 years ago
  $currentYear = date("Y");
  // Generate an array of years within the range
  $years = range($startYear, $currentYear);
 
   $condition = ['log_type' => 'upload','station_name' => $_SESSION['stationname'],'file_type' => $fileTypesArray];
   

  $listArr = $database->select('tab_logs_fileupload', "*", $condition, "AND", 'multiple', 'id DESC' ,[]);

  //  echo "<prE>"; print_r($listArr); die; 
  ?>
  <div class="pagetitle">

    <section class="section">

      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Files</h5>
              <input type="hidden" name="user_code" id="user_code" value="<?= $_SESSION['user_code']; ?>">
              <!-- Browser Default Validation -->
              <form class="g-3" method="post" enctype="multipart/form-data" id="uploadForm" action="actions/ActionController.php">

                <input type="hidden" name="type" value="upload-files">
                <input type="hidden" name="upload_type" value="periodic">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">

                <div class="row mt-2">
                  <div class="col-md-4">
                    <label for="month" class="col-sm-4 col-form-label">Month</label>
                    <div class="col-sm-4">
                      <!-- <input type="date" class="form-control" name="recordDate" id="recordDate" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>" min="2023-11-01" max="<?php echo date('Y-m-d'); ?>" onkeydown="return false"> -->
                      <select class="form-control" name="month" id="month" required>
                        <option>Select Month</option>
                        <?php foreach ($months as $month) : ?>
                          <option value="<?php echo $month; ?>"><?= $month; ?> </option>
                        <?php endforeach;  ?>
                      </select>
                    </div>
                    
                  </div>
                  <div class="col-md-4">
                    <label for="year" class="col-sm-4 col-form-label">Year</label>
                    <div class="col-sm-4">
                      <!-- <input type="date" class="form-control" name="recordDate" id="recordDate" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>" min="2023-11-01" max="<?php echo date('Y-m-d'); ?>" onkeydown="return false"> -->
                      <select class="form-control" name="year" id="year" required>
                        <option value="">Select Year</option>
                        <?php foreach ($years as $year): ?>
                          <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="year" class="col-form-label">Periodical Number</label>
                    <div class="col-sm-4">
                      <!-- <input type="date" class="form-control" name="recordDate" id="recordDate" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>" min="2023-11-01" max="<?php echo date('Y-m-d'); ?>" onkeydown="return false"> -->
                      <select class="form-control" name="periodical_number" id="periodical_number" required>
                        <option value="">Select Periodical</option>
                        <?php foreach ($periodical_number as $number): ?>
                          <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>



                <div id="file-upload-area" style="display:none;">
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <label for="validationDefault04" class="form-label">Select File Type:</label>
                      <select class="form-control" name="fileType" required>
                        <?php foreach ($checkBoxArrPeriodicals as $check) : ?>
                          <option><?= $check; ?> </option>
                        <?php endforeach;  ?>
                      </select>

                      <span class="form-text text-muted">Select a Category of the File</span>
                    </div>


                    <div class="col-md-6">
                      <label for="validationDefault03" class="form-label">Choose a File:</label>
                      <input type="file" class="form-control" id="file1" name="files[]" multiple>
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

                    

                    foreach ($checkBoxArrPeriodicals as $chekBox) { ?>
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
                <h5 class="card-title">Periodicals data (SC Data)</h5>
              </div>
              <!-- Table with stripped rows -->
              <table class="table datatable table-responsive table-hover">
                <thead>
                  <tr>
                   
                    <th>SC Name </th>
                    <th>Station Name</th>
                    <th>Filename (System)</th>
                     <th>Category</th>

                     
                    <th>Upload Time</th>
                    <th>Remark</th>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($listArr as $list) :
                    $path = 'actions/scdata/' . $list['folder_name'] . '/' . $list['filename'];
                  ?>
                    <tr id="<?= $list['id']; ?>">
                     
                      <td><?= $list['Sc_Name']; ?></td>
                      <td><?= strtoupper($list['station_name']); ?></td>
                      <td><a href="<?= $path ?>" download target="_balnk"><?= $list['filename']; ?></a></td>
                       <td><?= $list['file_type']; ?></td>
                      <td><?= $list['upload_time']; ?></td>
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
   
  //
  $("#recordDate").on("change", function() {
    var val = $(this).val();
    getAjax(val);
  });

  $("#month").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    if(month != '' && year != '' && periodical_number != '')
    {
      $("#file-upload-area").show();
    }
    else
    {
      $("#file-upload-area").hide();
    }
  });
  $("#year").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
     
    if(month != '' && year != '' && periodical_number != '')
    {
      $("#file-upload-area").show();
      // console.log('hey')
    }
    else
    {
      $("#file-upload-area").hide();
    }
  });
  $("#periodical_number").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    if(month != '' && year != '' && periodical_number != '')
    {
      $("#file-upload-area").show();
    }
    else
    {
      $("#file-upload-area").hide();
    }
  });
  
</script>