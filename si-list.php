<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
  <?php include 'layouts/alert.php'; ?>


  <?php

  $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  $locked = (isset($_GET['i'])) ? $_GET['i'] : '';

  $stationName = isset($_GET['stationName']) ? $_GET['stationName'] : '';
  if ($date) {

    if ($stationName) {
      $condition = ['record_date' => $date, 'station_name' => $stationName , 'log_type' => 'upload'];

    } else {
      $condition = ['record_date' => $date];
    };
  } else {
    $condition = [];
  }

  $listArr = $database->select('tab_logs_fileupload', "*", $condition, "AND", 'multiple', 'current_time desc');
  $UserList = $database->select('tab_user_details', "*", ['id' => $_SESSION['user_id']], "AND", 'single', 'id DESC');
  $SessionList = explode(',', $UserList['stations_allotted']);

  ?>
  <div class="pagetitle">

    <section class="section">

      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Earning Sheet</h5>

              <div class="adw">
                <span> Stations Allotted:</span> <br>
                <?php foreach ($SessionList as $stations) : ?>
                  <?php if ($stations == $stationName) : ?>
                    <span class="badge bg-success"><i class="bi bi-star me-1"></i> <?= strtoupper($stations); ?></span>
                  <?php else : ?>
                    <span class="badge bg-secondary"><i class="bi bi-star me-1"></i> <?= strtoupper($stations); ?></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>

              <!-- Browser Default Validation -->
              <form class="g-3" method="post" enctype="multipart/form-data" id="uploadForm" action="actions/ActionController.php">

                <input type="hidden" name="type" value="upload-files">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">

                <div class="row mt-2">
                  <div class="col-md-6">
                    <label for="inputDate" class="col-sm-6 col-form-label">Date</label>
                    <div class="col-sm-4">
                      <input type="date" class="form-control" name="recordDate" id="recordDate" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>" min="2023-11-01" max="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="inputDate" class="col-sm-4 col-form-label">Select Station</label>
                    <select name="station_name_si" id="station_name_si" class="form-select" style="width: 250px;">
                      <option value="">Select Station</option>
                      <?php foreach ($SessionList as $list) : ?>
                        <option value="<?= $list; ?>" <?php if ($stationName == $list) : ?> selected <?php endif; ?>><?= $list; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>


                </div>



                <div id="file-upload-area" <?php if ($locked) : ?> style="display: none;" <?php else : ?> style="display: block;" <?php endif; ?>>

                  <?php
                      $checkBoxArr = [
                        'Daily Earning Sheet', 'Paytm POS Transaction', 'SBI POS Transaction', 'Penalty', 'URC', 'Refund Memo', 'Manual Collection', 'Outstanding',
                        'Forfeit Format', 'Ref. Def. CSC', 'Def. CST', '1st Periodical', '2nd Periodical', '3rd Periodical', 'Balance Sheet'
                      ];

                    ?>

                    <div class="col-md-6">
                      <label for="validationDefault04" class="form-label">Select File Type:</label>
                      <select class="form-control" name="fileType" required>
                        <?php foreach ($checkBoxArr as $check) : ?>
                          <option><?= $check; ?> </option>
                        <?php endforeach;  ?>
                      </select>
                 
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <label for="validationDefault03" class="form-label">Choose Daily Revenue Sheets:</label>
                      <input type="file" class="form-control" id="file1" name="files[]" multiple>
                      <span class="form-text text-muted">Upload Earning Sheet, POS, NON-AFC Formats, etc.</span>

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
              <!-- <div class="action-buttons float-end mt-3">
                <a href="upload-files.php" class="btn btn-success">Upload Csv</a>   
            </div> -->

              <div class="d-flex justify-content-between">
                <h5 class="card-title">SI Data List</h5>
              </div>
              <!-- Table with stripped rows -->
              <table class="table  table-responsive" id="myDataTable">
                <thead>
                <tr id="<?= $list['id']; ?>">
                    <th>SC Name </th>
                    <th>Station Name</th>
                    <th>Filename</th>
                    <th>Category</th>
                    <th data-type="date" data-format="YYYY/DD/MM">Record Date</th>
                    <th>Current Time</th>
                    <th>Remark</th>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($listArr as $list) :
                    $path = 'actions/scdata/tmp/' . $list['record_date'] . '/' . $list['folder_name'] . '/' . $list['filename'];
                  ?>
                    <tr>
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
                    <th>Current Time</th>
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
  var today = "<?= date('Y-m-d'); ?>";
  var stationName = "<?= isset($_GET['stationName']) ? $_GET['stationName'] : '' ?>"
  var getDate = "<?= $date; ?>";
  if (getDate == '') {
    getAjax(today, stationName);
  }
  //
  $("#recordDate").on("change", function() {
    var val = $(this).val();
    getAjax(val, stationName);
  });

  $("#station_name_si").change(function() {
    $this = $(this);

    var val = $(this).val();
    if (val) {
      var current = location.origin + location.pathname + '?stationName=' + val;

      location.href = current;
    } else {
      var current = location.origin + location.pathname
      location.href = current;
    }


  })

  function getAjax(val, stationName = '') {

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
        console.log("current", current)
        if (response.lock_upload == "1" || response.lock_upload == 1) {
          console.log("lcoation", location)
          $("#file-upload-area").hide();
          current += '?date=' + val + '&i=' + response.lock_upload + '&stationName=' + stationName;
          // alert("You can't upload file Locked from Backend"); 
        } else {
          current += '?date=' + val + '&i=' + response.lock_upload + '&stationName=' + stationName;
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

  $(document).ready(function() {
    // Initialize DataTable
    var table = $('#myDataTable').DataTable({
        // DataTable options and configurations
    });

    // Add a category filter
    addCategoryFilter(table);

    // Add dropdown filters for each column
    table.columns().every(function() {
        var column = this;

        if (column.index() !== 2) { // Exclude column 2 (Category) from dropdown filters
            var select = $('<select><option value=""></option></select>')
                .appendTo($(column.header()))
                .on('change', function() {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                });

            column.data().unique().sort().each(function(d, j) {
                select.append('<option value="' + d + '">' + d + '</option>');
            });
        }
    });
});
</script>