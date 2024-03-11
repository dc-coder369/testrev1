<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
    <?php include 'layouts/alert.php'; ?>

    <?php

  $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  $locked = (isset($_GET['i'])) ? $_GET['i'] : '';
  $month1 = (isset($_GET['month'])) ? $_GET['month'] : '';
  $year1 = (isset($_GET['year'])) ? $_GET['year'] : '';
  $periodicals = (isset($_GET['periodical_number'])) ? $_GET['periodical_number'] : '';
  $fileTypesArray=['PR','URC','RM','OS','MC','FOF','1stP','2ndP','3rdP','BS','CF','DR-CSC-CST'];
  if ($date) {
    $condition = ['log_type' => 'upload','file_type' => $fileTypesArray];
  } else {
    $condition = [];
  }

  $fileTypesArray=['PR','URC','RM','OS','MC','FOF','1stP','2ndP','3rdP','BS','CF','DR-CSC-CST'];
  $periodical_number=['Periodical_1','Periodical_2','Periodical_3','Balance Sheet'];
  $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
  $currentYear = date("Y");

  // Set the range of years you want to include in the dropdown
  $startYear = $currentYear - 20; // 10 years ago
  $currentYear = date("Y");
  // Generate an array of years within the range
  $years = range($startYear, $currentYear);
 
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
                            <h5 class="card-title">Create lock-unlock</h5>
                            <input type="hidden" name="user_code" id="user_code" value="<?= $_SESSION['user_code']; ?>">
                            <!-- Browser Default Validation --> 
                                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label for="month" class="col-sm-4 col-form-label">Month</label>
                                        <div class="col-sm-4">
                                            <!-- <input type="date" class="form-control" name="recordDate" id="recordDate" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>" min="2023-11-01" max="<?php echo date('Y-m-d'); ?>" onkeydown="return false"> -->
                                            <select class="form-control" name="month" id="month" required>
                                                <option>Select Month</option>
                                                <?php foreach ($months as $monthName) : ?>
                                                <?php $abbrMonth = substr($monthName, 0, 3); ?>
                                                <option value="<?= $abbrMonth; ?>"
                                                    <?php echo ($abbrMonth == $month1) ? 'selected' : ''; ?>>
                                                    <?= $monthName; ?> </option>
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
                                                <?php $lastTwoDigits = substr($year, -2); ?>
                                                <option value="<?= $lastTwoDigits; ?>"
                                                    <?php echo ($lastTwoDigits == $year1) ? 'selected' : ''; ?>>
                                                    <?php echo $year; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="periodical_number" class="col-form-label">Periodical Number</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="periodical_number" id="periodical_number"
                                                required>
                                                <option value="">Select Periodical</option>
                                                <?php foreach ($periodical_number as $number): ?>
                                                <?php $value = ($number == "Periodical_1") ? "Periodical1" : (($number == "Periodical_2") ? "Periodical2" : (($number == "Periodical_3") ? "Periodical3" : "Balance_Sheet")); ?>
                                                <option value="<?php echo $value; ?>"
                                                    <?php echo ($value == $periodicals) ? 'selected' : ''; ?>>
                                                    <?php echo $number; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div><br> 
                                <div id="display-lock-unlock-button-area" class="btn_lock_unlock"> 
                                </div>
                            <!-- End Browser Default Validation --> 
                        </div>
                    </div> 
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="card"> 
                        <div class="card-body"> 
                            <div class="selctdatas col-6 mt-4 mb-2">
                            </div>
                        </div> 
                        <div class="card">
                            <div class="card-body"> 
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">Revenue Cell Data for Perodical files</h5>
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
                                            <td><a href="#"
                                                    onclick="SingleDownload(<?= htmlspecialchars(json_encode($list), ENT_QUOTES, 'UTF-8'); ?>)"><?= $list['filename']; ?></a>
                                            </td>
                                            <td><?= $list['original_filename']; ?></td>
                                            <td><?= $list['file_type']; ?></td>
                                            <td><?= $list['record_date']; ?></td>
                                            <td><?= $list['upload_time']; ?></td>
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

function postAjax(month, year, periodicals, status) {
    
    $.ajax({
        url: "actions/ActionController.php", // Replace with the actual API endpoint
        method: "post", // Use GET or POST depending on your API requirements
        data: {
            "type" : "lock unlock for NON AFC",
            'month': month,
            'year': year,
            'periodicals': periodicals,
            'status': status,
        }, // Pass any data you need to send to the server
        dataType: "json", // Specify the expected data type
        success: function(response) {
          console.log(response);
          var buttonArea = $("#display-lock-unlock-button-area");
          if (response[0] == 1) {
            
              var unlockButton = '<button class="btn btn-success mt-1" name="status" value="0" id="unlock">Unlock</button>';
              buttonArea.empty(); // Clear existing content
              buttonArea.append(unlockButton); // Append the unlockButton
           
          } else {
              var lockButton = '<button class="btn btn-danger mt-1" name="status" value="1" id="lock">Lock</button>';
              buttonArea.empty(); // Clear existing content
              buttonArea.append(lockButton); // Append the lockButton
             
          }
          buttonArea.show();
      },
        error: function(error) {
            // Handle the error here
            alert("error");
            console.error("Error fetching data:", error);
        }
    });
}

$(document).on('click', '#lock', function() {
    var month = $("#month").val();
    var year = $("#year").val();
    var periodicals = $("#periodical_number").val();
    var status = $("#lock").val();
    // alert(month);
    postAjax(month, year, periodicals, status);
});

$(document).on('click', '#unlock', function() {
    var month = $("#month").val();
    var year = $("#year").val();
    var periodicals = $("#periodical_number").val();
    var status = $("#unlock").val();
    // alert(month);
    postAjax(month, year, periodicals, status);
});

// var monthVal, yearVal, periodicalsVal;
// $("#month, #year, #periodical_number").on("change", function() {
//     // Update the corresponding variable with the selected value
//     if ($(this).attr("id") === "month") {
//         monthVal = $(this).val();
//     } else if ($(this).attr("id") === "year") {
//         yearVal = $(this).val();
//     } else if ($(this).attr("id") === "periodical_number") {
//         periodicalsVal = $(this).val();
//     }

//     // Check if all three options are selected
//     if (monthVal !== undefined && yearVal !== undefined && periodicalsVal !== undefined) {
//         // Call the function with the selected values
//         getAjaxlockunlock(monthVal, yearVal, periodicalsVal);
//     }
// });

$("#month").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    if( year != '' && periodical_number != ''){
       getAjaxlockunlock(month, year, periodical_number);
    }
  });
  $("#year").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    if( month != '' && periodical_number != ''){
       getAjaxlockunlock(month, year, periodical_number);
    }
  });
  $("#periodical_number").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    if( year != '' && month != ''){
       getAjaxlockunlock(month, year, periodical_number);
    }
  });

function getAjaxlockunlock(monthVal, yearVal, periodicalsVal) {
    
    $.ajax({
        url: "actions/ActionController.php", // Replace with the actual API endpoint
        method: "GET", // Use GET or POST depending on your API requirements
        data: {
            "type": "local_unlock_status_NON_AFC",
            month: monthVal,
            year: yearVal,
            periodicals: periodicalsVal
        }, // Pass any data you need to send to the server
        dataType: "json", // Specify the expected data type
        success: function(response) {
            var buttonArea = $("#display-lock-unlock-button-area");
            if (response.lock_upload == "1" || response.lock_upload == 1) {
                var unlockButton =
                    '<button class="btn btn-success mt-1" name="status" value="0" id="unlock">Unlock</button>';
                buttonArea.html(unlockButton);
            } else {
                var lockButton =
                    '<button class="btn btn-danger mt-1" name="status" value="1" id="lock">Lock</button>';
                buttonArea.html(lockButton);
            }
            buttonArea.show();
        },
        error: function(error) {
            // Handle the error here
            console.error("Error fetching data:", error);
        }
    });
}

</script>