<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
    <?php include 'layouts/alert.php'; ?>


    <?php

$year = (isset($_POST['year'])) ? $_POST['year'] : '';
$month = (isset($_POST['month'])) ? $_POST['month'] : '';
$periodical_number = (isset($_POST['periodicals'])) ? $_POST['periodicals'] : '';

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
   // code given by chintan sir.
   function generateYearOptions($selectedYear) {
    $currentYear = date('Y');
    $options = '<option value="">Select Year</option>';
    for ($year = 2023; $year <= $currentYear; $year++) {
        $lastTwoDigits = substr($year, -2);
        $selected = ($selectedYear == $lastTwoDigits) ? 'selected' : ''; // Check if $selectedYear matches the current $lastTwoDigits
        $options .= "<option value=\"$lastTwoDigits\" $selected>$year</option>";
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
                            <h5 class="card-title">Upload Files</h5>
                            <input type="hidden" name="user_code" id="user_code" value="<?= $_SESSION['user_code']; ?>">
                            <!-- Browser Default Validation -->
                            <form class="g-3" method="post" enctype="multipart/form-data" id="uploadForm"
                                action="actions/ActionController.php">

                                <input type="hidden" name="type" value="upload-files">
                                <input type="hidden" name="upload_type" value="periodic">
                                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">

                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label for="year" class="col-sm-4 col-form-label">Year</label>
                                        <div class="col-sm-5">
                                            <select class="form-control" name="year" id="year" required
                                                onchange="enableMonthDropdown()">
                                                <?php echo generateYearOptions($_POST['year']); ?>
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
                                            <select class="form-control" name="periodical_number" id="periodical_number"
                                                required disabled>
                                                <option value>Select Periodical</option>
                                                <?php foreach ($periodical_number as $number): ?>
                                                <option
                                                    value="<?php if($number == "Periodical 1"){echo "Periodical1";}elseif($number == "Periodical 2"){echo "Periodical2";}elseif($number == "Periodical 3"){echo "Periodical3";} else{echo "Balance_Sheet";} ?>">
                                                    <?php echo $number; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div><br>

                                <div id="file-upload-area" style="display:none;">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="validationDefault04" class="form-label">Select File
                                                Type:</label>
                                            <select class="form-control" name="fileType" id="fileTypea" value=""
                                                required>
                                                <?php foreach ($checkBoxArrPeriodicals as $check) : ?>
                                                <option value="<?php echo $check; ?>"><?= $check; ?> </option>
                                                <?php endforeach;  ?>
                                            </select>

                                            <span class="form-text text-muted">Select a Category of the File</span>
                                        </div>


                                        <div class="col-md-6">
                                            <label for="validationDefault03" class="form-label">Choose a File:</label>
                                            <input type="file" class="form-control" id="file1" name="files[]" multiple>
                                            <span class="form-text text-muted">Upload File of the Selected
                                                Category</span>

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
                                            <input class="form-check-input" name="fileType[<?= $chekBox; ?>]"
                                                type="checkbox" value="<?= $chekBox; ?>" id="flex<?= $chekBox; ?>">
                                            <label class="form-check-label" for="flex<?= $chekBox; ?>">
                                                <?= $chekBox; ?>
                                            </label>
                                        </div>

                                        <?php } ?>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="validationDefault03" class="form-label">Remark
                                                (Optional):</label>
                                            <textarea class="form-control" name="remark"
                                                placeholder="Enter Remark"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputDate" class="col-sm-2 col-form-label">Name of SC:</label>
                                            <input type="text" class="form-control" name="sc_name"
                                                placeholder="Enter SC name" required>
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
                                <form class="row g-3 needs-validation" method="post"
                                    action="actions/ActionController.php" id="download-all-files-form">
                                    <div id="fileids">
                                    </div>
                                    <input type="hidden" name="type" value="download-all-files">
                                    <input type="hidden" name="hiddenrecordDate2"
                                        value="<?= $date ?? date('Y-m-d'); ?>">
                                    <button type="submit" class="btn btn-info" id="download-files-btn">Download
                                        All</button>
                                </form>
                            </div><br>
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
                                        <th>Filename (Original)</th>
                                        <th>Category</th>
                                        <th>Upload Time</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>SC Name </th>
                                        <th>Station Name</th>
                                        <th>Filename (System)</th>
                                        <th>Filename (Original)</th>
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

function getAjaxlockunlock(monthVal, yearVal, periodicalsVal) {
    var user_code = "<?= $_SESSION['user_code'] ?>";
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
            if (response.lock_upload == "1" || response.lock_upload == 1 || response[user_code] == 1) {
                $("#file-upload-area").hide();
            } else {
                $("#file-upload-area").show();
            }
        },
        error: function(error) {
            // Handle the error here
            console.error("Error fetching data:", error);
        }
    });
}
// Call the function when the page loads

$("#year").change(function() {
    var date = new Date();
    var selectedmonth = parseInt(document.getElementById("year").value);
    var year = parseInt($(this).val());
    var currentMonth = date.getMonth() + 1; // Get current month
    var months = ['Select Month', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'
    ];
    var valueofmonth = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $("#month").html("");
    var d = new Date();
    var n = d.getMonth() + 2;
    if (year === selectedmonth && year != '') {
        if (year === 24) {
            for (var i = 1; i <= 13; i++) {
                $("#month").append("<option value='" + valueofmonth[i - 1] + "'>" + months[i - 1] +
                "</option>");
                document.getElementById('periodical_number').value = '';
            }
        } else if (year === 23) {
            for (var i = 1; i <= 13; i++) {
                $("#month").append("<option value='" + valueofmonth[i - 1] + "'>" + months[i - 1] +
                "</option>");
                document.getElementById('periodical_number').value = '';
            }
        } else {
            for (var i = 1; i <= 13; i++) {
                $("#month").append("<option value='" + valueofmonth[i - 1] + "'>" + months[i - 1] +
                "</option>");
                document.getElementById('periodical_number').value = '';
            }
        }
    } else {
        $("#file-upload-area").hide();
        $("#month").html("<option value=''>Select Month</option>");
        document.getElementById('periodical_number').value = '';
    }
});

function enablePeriodicalDropdown(month, year, periodicalDropdown) {
    // console.log("month: "+month);
    var yearDropdown = document.getElementById("year");
    var monthDropdown = document.getElementById("month");
    var periodicalDropdowns = document.getElementById("periodical_number");
    if (year !== "") {
        if (month !== "") {
            periodicalDropdowns.disabled = false;
        } else {
            $("#file-upload-area").hide();
            periodicalDropdowns.disabled = true;
        }
    } else {
        $("#file-upload-area").hide();
        periodicalDropdowns.disabled = true;
    }
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

$("#periodical_number").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    getAjaxvalue(month, year, periodical_number);
    if (year != '' && month != '') {
        getAjaxlockunlock(month, year, periodical_number);
    }
    $('#fileTypea option[value="1st Periodical"]').hide();
    $('#fileTypea option[value="2nd Periodical"]').hide();
    $('#fileTypea option[value="3rd Periodical"]').hide();
    $('#fileTypea option[value="Balance Sheet"]').hide();

    // Show all other options
    $('#fileTypea option').not(
        '[value="1st Periodical"], [value="2nd Periodical"], [value="3rd Periodical"], [value="Balance Sheet"]'
        ).show();


    // Show the required options based on periodical_number
    switch (periodical_number) {
        case 'Periodical1':
            $('#fileTypea option[value="1st Periodical"]').show();
            break;
        case 'Periodical2':
            $('#fileTypea option[value="2nd Periodical"]').show();
            break;
        case 'Periodical3':
            $('#fileTypea option[value="3rd Periodical"]').show();
            break;
        case 'Balance_Sheet':
            $('#fileTypea option[value="Balance Sheet"]').show();
            break;
        default:
            // Show all options if none of the above conditions are met
            $('#fileTypea option').show();
            break;
    }
});

$("#month").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    getAjaxvalue(month, year, periodical_number);
    if (year != '') {
        var periodicalDropdown = document.getElementById("periodical_number");
        enablePeriodicalDropdown(month, year, periodicalDropdown);
    }
    if (month == '') {
        document.getElementById('periodical_number').value = '';
    }
    if (year != '' && periodical_number != '') {
        getAjaxlockunlock(month, year, periodical_number);
    }
});
$("#year").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    console.log(periodical_number);
    var periodicalDropdown = document.getElementById("periodical_number");
    getAjaxvalue(month, year, periodical_number);
    if (month != '' && periodical_number != '') {
        getAjaxlockunlock(month, year, periodical_number);
    }
    enablePeriodicalDropdown(month, year, periodicalDropdown);
});

function getAjaxvalue(month, year, periodicalsVal) {
    // console.log("monthval: " month );
    $.ajax({
        url: "actions/ActionController.php", // Replace with the actual API endpoint
        method: "GET", // Use GET or POST depending on your API requirements
        data: {
            "type": "value_of_NON_AFC_STATION",
            month: month,
            year: year,
            periodicals: periodicalsVal
        }, // Pass any data you need to send to the server
        dataType: "json", // Specify the expected data type

        success: function(response) {
            // Clear existing table rows
            $("tbody").empty();
            if (response.error === "No data found for the specified date") {
                $("tbody").html(
                    "<tr><td colspan='8' style='text-align: center;'>No data available in table</td></tr>"
                    );
            } else {
                response.forEach(function(record) {
                    var path = 'actions/scdata/Periodicals/' + record.folder_name + '/' + record
                        .filename;

                    record.path = path;
                    var newRow = $("<tr id =" + record.id + ">");

                    newRow.append("<td>" + record.Sc_Name + "</td>");
                    newRow.append("<td>" + record.uploaded_for + "</td>");
                    newRow.append("<td><a href='#' onclick='SingleDownload(" + JSON.stringify(
                            record) +
                        ")'>" + record.filename + "</a></td>");
                    newRow.append("<td>" + record.original_filename + "</td>");
                    newRow.append("<td>" + record.file_type + "</td>");
                    // newRow.append("<td>" + record.record_date + "</td>");
                    newRow.append("<td>" + record.upload_time + "</td>");
                    newRow.append("<td>" + record.Remark + "</td>");

                    // Append the new row to the table body
                    $("tbody").append(newRow);
                    $("#fileids").append('<input type="hidden" name="fileid[]" value="' + record
                        .id + '">');
                });
            }
        },


        error: function(error) {
            // Clear existing table rows
            $("tbody").empty();
            // Display message indicating error
            $("tbody").html(
                "<tr><td colspan='8' style='text-align: center;'>No data available in table</td></tr>");
            console.error("Error fetching data:", error);
        }
    });
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
</script>