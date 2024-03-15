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

  $startYear = $currentYear - 20; // 10 years ago
  $currentYear = date("Y");
  $years = range($startYear, $currentYear);
 
//   $listArr = $database->select('tab_logs_fileupload', "*", $condition, "AND", 'multiple', '`upload_time` desc');

//   $userList = $database->select('tab_user_details', "*", ['account_type' => 'station'], "AND", 'multiple');
  // code given by chintan sir.
    function generateYearOptions() {
        $currentYear = date('Y');
        $options = '<option value="">Select Year</option>';
        // print_r($year);
        for ($year = 2023; $year <= $currentYear; $year++) {
            $lastTwoDigits = substr($year, -2);
            $options .= "<option value=\"$lastTwoDigits\">$year</option>";
        }
        return $options;
    }
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
                                    <label for="year" class="col-sm-4 col-form-label">Year</label>
                                    <div class="col-sm-5">
                                        <select class="form-control" name="year" id="year" required onchange="enableMonthDropdown()">
                                            <?php echo generateYearOptions(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="month" class="col-sm-4 col-form-label">Month</label>
                                    <div class="col-sm-5">
                                        <select class="form-control" name="month" id="month" required disabled>
                                            <option>Select Month</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="year" class="col-form-label">Periodical Number</label>
                                    <div class="col-sm-5">
                                        <select class="form-control" name="periodical_number" id="periodical_number" required disabled>
                                            <option value>Select Periodical</option>
                                            <?php foreach ($periodical_number as $number): ?>
                                                <option value="<?php if($number == "Periodical_1"){echo "Periodical1";}elseif($number == "Periodical_2"){echo "Periodical2";}elseif($number == "Periodical_3"){echo "Periodical3";} else{echo "Balance_Sheet";} ?>"><?php echo $number; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div><br>
                                <div id="display-lock-unlock-button-area" class="btn_lock_unlock"> 
                                </div>
                        </div>
                    </div> 
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="card"> 
                        
                        <div class="card">
                            <div class="card-body"> 
                             <div class="action-buttons float-end mt-3 d-flex justify-content-around">
                                <form class="row g-3 needs-validation" method="post" action="actions/ActionController.php" id="download-all-files-form">
                                <input type="hidden" name="type" value="download-all-files">
                                <input type="hidden" name="hiddenrecordDate2" value="<?=  date('Y-m-d'); ?>">
                                <button type="submit" class="btn btn-info" id="download-files-btn">Download All</button>
                                </form>
                            </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">Revenue Cell Data for Periodical files</h5>
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
                                        <!-- <?php foreach ($listArr as $list) :
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
                                        <?php endforeach; ?> -->
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
                            </div>
                        </div>

                    </div>
                </div>
        </section>
</main>

<?php include 'layouts/footer.php'; ?>

<script>
$("#year").change(function () {
    var date = new Date();
    var selectedmonth = parseInt(document.getElementById("year").value); 
    var year = parseInt($(this).val());
    var currentMonth = date.getMonth() + 1; // Get current month
    var months = ['Select Month','January', 'February', 'March', 'April','May', 'June', 'July', 'August','September', 'October', 'November', 'December'];
    var valueofmonth = ['','Jan', 'Feb', 'Mar', 'Apr','May', 'Jun', 'Jul', 'Aug','Sep', 'Oct', 'Nov', 'Dec'];
    $("#month").html("");
    var d = new Date();
    var n = d.getMonth()+2;
    if (year === selectedmonth && year != '') {
        if (year === 24) { 
            for (var i = 1; i <= 13; i++) { 
                $("#month").append("<option value='" + valueofmonth[i - 1] + "'>" + months[i - 1] + "</option>");
                document.getElementById('periodical_number').value='';
            }
        }
        else if(year === 23) { 
            for (var i = 1; i <= 13; i++) { 
                $("#month").append("<option value='" + valueofmonth[i - 1] + "'>" + months[i - 1] + "</option>");
                document.getElementById('periodical_number').value='';
            }
        }
         else {
            for (var i = currentMonth; i <= 13; i++) {
                $("#month").append("<option value='" + valueofmonth[i - 1] + "'>" + months[i - 1] + "</option>");
                document.getElementById('periodical_number').value='';
            }
        }
    }
    else {
        $("#month").html("<option value=''>Select Month</option>");
        document.getElementById('periodical_number').value='';
    }
});

function enablePeriodicalDropdown(month, year,periodicalDropdown) {
    // console.log("month: "+month);
    var yearDropdown = document.getElementById("year");
        var monthDropdown = document.getElementById("month");
        var periodicalDropdowns = document.getElementById("periodical_number");
        if (year !== "") {
            if(month !== ""){
                periodicalDropdowns.disabled = false;
            }
            else {
                periodicalDropdowns.disabled = true;
            }
        } else {
            periodicalDropdowns.disabled = true;
        }

        // if(year == '' || month == '' || periodicalDropdown == '')
        // {
        //       $("#display-lock-unlock-button-area").hide();
        // }
}


    function enableMonthDropdown() {
        var yearDropdown = document.getElementById("year");
        var monthDropdown = document.getElementById("month");
        if (yearDropdown.value !== "") {
            monthDropdown.disabled = false;
        } else {
            monthDropdown.disabled = true;
        }
    }

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
        //   buttonArea.show();
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
    postAjax(month, year, periodicals, status);
    
});

$(document).on('click', '#unlock', function() {
    var month = $("#month").val();
    var year = $("#year").val();
    var periodicals = $("#periodical_number").val();
    var status = $("#unlock").val();
    postAjax(month, year, periodicals, status);
});

$("#month").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    getAjaxvalue(month, year, periodical_number);
    if( year != '' && periodical_number != '' && month != ''){
       getAjaxlockunlock(month, year, periodical_number);
    }
    if(year != ''){
        var periodicalDropdown = document.getElementById("periodical_number");
        enablePeriodicalDropdown(month, year, periodicalDropdown);
    }
    if(month === ""){
        document.getElementById('periodical_number').value='';
    }
    handleInputChange();
    if (month == '' || year == '' || periodical_number == '') {
        $("#display-lock-unlock-button-area").hide();
    }
});
$("#year").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;

    getAjaxvalue(month, year, periodical_number);
    if( month != '' && periodical_number != '' && year != ''){
       getAjaxlockunlock(month, year, periodical_number);
    }
        var periodicalDropdown = document.getElementById("periodical_number");
        enablePeriodicalDropdown(month, year, periodicalDropdown);
        handleInputChange();
        if (month == '' || year == '' || periodical_number == '') {
        $("#display-lock-unlock-button-area").hide();
    }
});
$("#periodical_number").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    handleInputChange();
    getAjaxvalue(month, year, periodical_number);
    if( year != '' && month != '' && periodical_number != ''){
       getAjaxlockunlock(month, year, periodical_number);
    }
    if (month == '' || year == '' || periodical_number == '') {
        $("#display-lock-unlock-button-area").hide();
    }
});
function handleInputChange() {
    var month = document.getElementById("month").value;
  console.log('month'+month);
    
    // var year = document.getElementById("year").value;
    // var periodical_number = document.getElementById("periodical_number").value;
   
    
}
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


function getAjaxvalue(month, year, periodicalsVal) {
    // console.log("monthval: " month );
$.ajax({
    url: "actions/ActionController.php", // Replace with the actual API endpoint
    method: "GET", // Use GET or POST depending on your API requirements
    data: {
        "type": "value_of_NON_AFC",
        month: month,
        year: year,
        periodicals: periodicalsVal
    }, // Pass any data you need to send to the server
    dataType: "json", // Specify the expected data type
    
    success: function(response) {
        // Clear existing table rows
        $("tbody").empty();
        if(response.error === "No data found for the specified date"){
            $("tbody").html("<tr><td colspan='8' style='text-align: center;'>No data available in table</td></tr>");
        }else{
        // Iterate over each record in the response
        response.forEach(function(record) {
            var path = 'actions/scdata/Periodicals/' + record.folder_name + '/' + record.filename;

            record.path = path;
            // Create a new table row
            var newRow = $("<tr id ="+ record.id + ">");

            // Populate table cells with record data
            newRow.append("<td>" + record.Sc_Name + "</td>");
            newRow.append("<td>" + record.uploaded_for + "</td>");
            newRow.append("<td><a href='#' onclick='SingleDownload(" + JSON.stringify(record) +
                ")'>" + record.filename + "</a></td>");
            newRow.append("<td>" + record.original_filename + "</td>");
            newRow.append("<td>" + record.file_type + "</td>");
            newRow.append("<td>" + record.record_date + "</td>");
            newRow.append("<td>" + record.upload_time + "</td>");
            newRow.append("<td>" + record.Remark + "</td>");

            // Append the new row to the table body
            $("tbody").append(newRow);
            $("#download-all-files-form").append('<input type="hidden" name="fileid[]" value="'+ record.id +'">');
        });
      }
    },

    error: function(error) {
// Clear existing table rows
$("tbody").empty();
// Display message indicating error
$("tbody").html("<tr><td colspan='8' style='text-align: center;'>No data available in table</td></tr>");
console.error("Error fetching data:", error);
}
});
}

</script>