<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
    <?php include 'layouts/alert.php'; ?>

    <?php

$fileTypesArray=['PR','URC','RM','OS','MC','FOF','1stP','2ndP','3rdP','BS','CF','DR-CSC-CST'];

$fileTypesArray=['PR','URC','RM','OS','MC','FOF','1stP','2ndP','3rdP','BS','CF','DR-CSC-CST'];
$periodical_number=['Periodical 1','Periodical 2','Periodical 3','Balance Sheet'];
$months = array("January", "February","March","April","May","June","July","August","September","October","November","December");
$currentYear = date("Y");

// Set the range of years you want to include in the dropdown
$startYear = $currentYear - 20; // 10 years ago
$currentYear = date("Y");
// Generate an array of years within the range
$years = range($startYear, $currentYear);

  $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  $locked = (isset($_GET['i'])) ? $_GET['i'] : '';
  if ($date) {
    $condition = ['record_date' => $date, 'log_type' => 'upload'];
  } else {
    $condition = [];
  }
  $type = (isset($_GET['type'])) ? $_GET['type'] : '';


  $listArr = $database->select('tab_logs_fileupload', "*", $condition, "AND", 'multiple', '`upload_time` desc');

  // $listArr = $database->select('tab_status_lockupload', "*", [], "AND", 'multiple');
  $userList = $database->select('tab_user_details', "*", ['account_type' => 'station'], "AND", 'multiple');

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

                            <div class="selctdatas col-6 mt-4 mb-2">
                                <div class="d-flex justify-content-around col-sm-4">
                                    <select name="file_type" class="form-control" id="file_type">
                                        <option value="periodic" <?php if ($type == 'periodic') : ?> selected
                                            <?php endif; ?>>Periodic</option>
                                        <option value="daily" <?php if ($type == 'daily') : ?> selected <?php endif; ?>>
                                            Daily</option>
                                    </select>
                                </div> <br>
                                <div class="daily  col-sm-4 " <?php if ($type == 'daily') : ?> style="display: show;"
                                    <?php else : ?> style="display: none;" <?php endif; ?>>
                                    <input type="date" class="form-control ml-2" style="margin-bottom:10px;"
                                        id="recordDate" value="<?= $date ?? date('Y-m-d'); ?>"
                                        max="<?= date('Y-m-d'); ?>">
                                </div>
                                <div class="row mt-2 periodic" <?php if ($type == 'periodic') : ?>
                                    style="display: show;" <?php else : ?> style="display: none;" <?php endif; ?>>
                                        <div class="col-md-4">
                                    <label for="year" class="col-sm-4 col-form-label">Year</label>
                                    <div class="col-sm-11">
                                        <select class="form-control" name="year" id="year" required onchange="enableMonthDropdown()">
                                            <?php echo generateYearOptions(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="month" class="col-sm-4 col-form-label">Month</label>
                                    <div class="col-sm-11">
                                        <select class="form-control" name="month" id="month" required disabled>
                                            <option>Select Month</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="year" class="col-form-label">Periodical Number</label>
                                    <div class="col-sm-11">
                                        <select class="form-control" name="periodical_number" id="periodical_number" required disabled>
                                            <option value>Select Periodical</option>
                                            <?php foreach ($periodical_number as $number): ?>
                                                <option value="<?php if($number == "Periodical 1"){echo "Periodical1";}elseif($number == "Periodical 2"){echo "Periodical2";}elseif($number == "Periodical 3"){echo "Periodical3";} else{echo "Balance_Sheet";} ?>"><?php echo $number; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                </div><br>

                            </div>
                            <div class="periodic" id="periodic" <?php if ($type == 'periodic') : ?>
                                style="display: show;" <?php else : ?> style="display: none;" <?php endif; ?>>

                            </div>

                            <div class="daily" <?php if ($type == 'daily') : ?> style="display: show;" <?php else : ?>
                                style="display: none;" <?php endif; ?>>
                                <?php foreach ($userList as $user) :
                                    $fileUpload = $database->select('tab_status_lockupload', "*", [$user['user_code'] => 1,'date' => $date], "AND", 'single');
                                    if ($fileUpload) :?>
                                <button id="unlock" onclick="lockAjax('<?= $date ?>', 0, '<?= $user['user_code'] ?>')"
                                    class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
                                    <?= ($user['user_code']) ? strtoupper($user['user_code']) : strtoupper($user['stationname']); ?></button>
                                <?php else :?>
                                <button id="lock" onclick="lockAjax('<?= $date ?>', 1, '<?= $user['user_code'] ?>')"
                                    class="badge bg-secondary"><i class="bi bi-star me-1"></i>
                                    <?= ($user['user_code']) ? strtoupper($user['user_code']) : strtoupper($user['stationname']); ?></span>
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
<script>
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
$("#file_type").on("change", function() {
    var file_type = $(this).val(); // You can directly use $(this).val() to get the selected value

    var current = location.origin + location.pathname;
    var getDate = "<?= $date; ?>";
    current += '?date=' + getDate + '&type=' + file_type;
    location.href = current;
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
            var file_type = document.getElementById("file_type").value;
            if (response == "1" || response == 1) {
                current += '?date=' + val + '&type=' + file_type;
                // alert("You can't upload file Locked from Backend"); 
            } else {
                current += '?date=' + val + '&type=' + file_type;
            }
            location.href = current;

        },
        error: function(error) {
            // Handle the error here
            console.error("Error fetching data:", error);
        }
    });

}

function lockAjax(date, lock_upload, user_code = '') {
    var current = location.origin + location.pathname;
    var file_type = document.getElementById("file_type").value;
    $.ajax({
        url: "actions/ActionController.php", // Replace with the actual API endpoint
        method: "post", // Use GET or POST depending on your API requirements
        data: {
            type: "update_lock_status_station",
            date: date,
            user_code: user_code,
            'status': lock_upload,
            'file_type': file_type,
        }, // Pass any data you need to send to the server
        dataType: "json", // Specify the expected data type
        success: function(response) {
            current += '?date=' + date + '&type=' + file_type;
            location.href = current;
        },
        error: function(error) {
            // Handle the error here
            console.error("Error fetching data:", error);
        }
    });
}


function handleInputChange() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    if (month != '' && year != '' && periodical_number != '') {
        // getAjaxlockunlock(month, year, periodical_number);
        getAjaxvalue(month, year, periodical_number);
    }
    else
    {
        $("#periodic").empty();
    }   
}

$("#month, #year, #periodical_number").on("change", handleInputChange);

function getAjaxvalue(monthVal, yearVal, periodicalsVal) {
    $.ajax({
        url: "actions/ActionController.php", // Replace with the actual API endpoint
        method: "GET", // Use GET or POST depending on your API requirements
        data: {
            "type": "value_of_NON_AFC_periodical",
            month: monthVal,
            year: yearVal,
            periodicals: periodicalsVal
        }, // Pass any data you need to send to the server
        dataType: "json", // Specify the expected data type
        success: function(response) {
            $("#periodic").empty();
            if(response != null)
            {
                $.each(response, function(key, value) {
                var buttonId = "periodic_" + key.toLowerCase(); // Generate button ID
                var buttonText = key.toUpperCase(); // Use key as button text
                var buttonClass = (value === "0") ? "bg-secondary" :
                "bg-success"; // Determine button class based on value
                // Check if the column exists in the response
                // Create button element
                var button = $("<button>", {
                    id: buttonId,
                    class: "badge " + buttonClass,
                    text: buttonText
                });
                // Define onclick event
                button.on("click", function() {
                    postAjax(monthVal, yearVal, periodicalsVal, (value === "0") ? 1 : 0,
                        key);
                });

                // Append button to the periodic div
                $("#periodic").append(button);

            });
            }
            // Iterate over the response to create and append buttons
           
        },


        error: function(error) {
            // Clear existing table rows
            console.error("Error fetching data:", error);
        }
    });
}

function postAjax(month, year, periodicals, status, station) {
    $.ajax({
        url: "actions/ActionController.php", // Replace with the actual API endpoint
        method: "post", // Use GET or POST depending on your API requirements
        data: {
            "type": "update_lock_status_station",
            'month': month,
            'year': year,
            'periodicals': periodicals,
            'file_type': 'periodic',
            'status': status,
            'user_code': station,
        }, // Pass any data you need to send to the server
        dataType: "json", // Specify the expected data type
        success: function(response) {
            $("#periodic").empty();
            getAjaxvalue(month, year, periodicals);
        },
        error: function(error) {
            // Handle the error here
            alert("error");
            console.error("Error fetching data:", error);
        }
    });
}
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

$("#month").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value; 
    if(year != ''){
        var periodicalDropdown = document.getElementById("periodical_number");
        enablePeriodicalDropdown(month, year, periodicalDropdown);
    }
    if(month == ''){
        document.getElementById('periodical_number').value='';
    }
});
$("#year").on("change", function() {
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    var periodical_number = document.getElementById("periodical_number").value;
    var periodicalDropdown = document.getElementById("periodical_number");
    enablePeriodicalDropdown(month, year, periodicalDropdown);
});
</script>