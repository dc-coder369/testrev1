<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
    <?php include 'layouts/alert.php'; ?>

    <?php

$fileTypesArray=['PR','URC','RM','OS','MC','FOF','1stP','2ndP','3rdP','BS','CF','DR-CSC-CST'];

$fileTypesArray=['PR','URC','RM','OS','MC','FOF','1stP','2ndP','3rdP','BS','CF','DR-CSC-CST'];
$periodical_number=['Periodical_1','Periodical_2','Periodical_3','Balance Sheet'];
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
                                    <div class="col-md-4 col-sm-4">
                                        <label for="year" class="col-sm-4 col-form-label">Year</label>
                                        <div class="col-sm-4">
                                            <!-- <input type="date" class="form-control" name="recordDate" id="recordDate" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>" min="2023-11-01" max="<?php echo date('Y-m-d'); ?>" onkeydown="return false"> -->
                                            <select class="form-control" name="year" id="year" required>
                                                <option value="">Select Year</option>
                                                <?php foreach ($years as $year): ?>
                                                <?php $lastTwoDigits = substr($year, -2); ?>
                                                <option value="<?= $lastTwoDigits; ?>">
                                                    <?php echo $year; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="month" class="col-sm-4 col-form-label">Month</label>
                                        <div class="col-sm-4">
                                            <!-- <input type="date" class="form-control" name="recordDate" id="recordDate" value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>" min="2023-11-01" max="<?php echo date('Y-m-d'); ?>" onkeydown="return false"> -->
                                            <select class="form-control" name="month" id="month" required>
                                                <option>Select Month</option>
                                                <?php foreach ($months as $monthName) : ?>
                                                <?php $abbrMonth = substr($monthName, 0, 3); ?>
                                                <option value="<?= $abbrMonth; ?>">
                                                    <?= $monthName; ?> </option>
                                                <?php endforeach;  ?>
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
                                                <option value="<?php echo $value; ?>">
                                                    <?php echo $number; ?></option>
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
    console.log(file_type);
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
            console.log(response);
            // Iterate over the response to create and append buttons
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
        },


        error: function(error) {
            // Clear existing table rows
            console.error("Error fetching data:", error);
        }
    });
}

function postAjax(month, year, periodicals, status, station) {
    console.log(status);
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
            console.log(response);
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
</script>