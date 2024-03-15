<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
    <?php include 'layouts/alert.php'; ?>


    <?php
  //  echo  $_SESSION['stationname']; die;
  $date = (isset($_GET['date'])) ? $_GET['date'] : '';
  $locked = (isset($_GET['i'])) ? $_GET['i'] : '';
  if ($date) {
   $condition = ['log_type' => 'upload'];
  } else {
    $condition = [];
  }
  // echo "<prE>"; print_r($condition); die; 
  $listArr = $database->select('pos_failed_transaction', "*", $condition, "AND", 'multiple','`upload_time` desc');
  
  // echo "<prE>"; print_r($listArr); die; 
  ?>
    <div class="pagetitle">

        <section class="section">

      <?php if($_SESSION['account_type'] == 'revenuecell'):?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Failed POS Transactions Master File</h5>

                            <!-- Browser Default Validation -->
                            <form class="g-3" method="post" enctype="multipart/form-data" id="uploadForm"
                                action="actions/ActionController.php">
                                <input type="hidden" name="type" value="upload-files">
                                <input type="hidden" name="fileType" value="pos-failed">
                                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="inputDate" class="col-sm-4 col-form-label">Date</label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="recordDate" id="recordDate"
                                                value="<?php echo htmlspecialchars($date ?? date('Y-m-d')); ?>"
                                                min="2023-11-01" max="<?php echo date('Y-m-d'); ?>"
                                                onkeydown="return false">
                                        </div>
                                    </div>
                                </div>
                                <div id="file-upload-area" style="display: block;">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="validationDefault03" class="form-label">Choose a File:</label>
                                            <input type="file" class="form-control" id="file1" name="files[]">
                                            <span class="form-text text-muted">Upload File of the Selected
                                                Category</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputDate" class="form-label">Uploaded By</label>
                                            <input type="text" class="form-control" name="sc_name"
                                                placeholder="Enter SC name" required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <label for="validationDefault03" class="form-label">Description
                                                (Optional):</label>
                                            <textarea class="form-control" name="remark"
                                                placeholder="Enter Description"></textarea>
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
                <div id="file-upload-area" style="display: block;">
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <label for="validationDefault03" class="form-label">Choose a File:</label>
                      <input type="file" class="form-control" id="file1" name="files[]">
                      <span class="form-text text-muted">Upload Consolidated Transactions File</span>
                    </div>
                    <div class="col-md-6">
                      <label for="inputDate" class="form-label">Uploaded By</label>
                      <input type="text" class="form-control" name="sc_name" placeholder="Enter name" required>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-12">
                      <label for="validationDefault03" class="form-label">Description (Optional):</label>
                      <textarea class="form-control" name="remark" placeholder="Enter Description"></textarea>
                    </div> 
                  </div>
                  <div class="row mt-2">
                    <div class="col-12">
                      <button class="btn btn-primary float-end" type="submit">Upload</button>
                    </div>
                  </div>
                </div>
            </div>
            <?php endif;?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Failed POS Transaction</h5>
                            </div>
                            <!-- Table with stripped rows -->
                            <table class="table datatable table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th>Filename (System)</th>
                                        <th>Filename (Original)</th>
                                        <th>Category</th>
                                        <th data-type="date" data-format="YYYY/DD/MM">Record Date</th>
                                        <th>Upload Time</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($listArr as $list) :
                    $path = 'actions/scdata/' . $list['folder_name'] . '/' . $list['filename'];
                    $list['path']=$path;
                  ?>
                                    <tr id="<?= $list['id']; ?>">
                                        <td><a href="#"
                                                onclick="SingleDownload(<?= htmlspecialchars(json_encode($list), ENT_QUOTES, 'UTF-8'); ?>)"><?= $list['filename']; ?></a>
                                        </td>
                                        <td><?= $list['original_filename']; ?></td>
                                        <td><?= $list['file_type']; ?></td>
                                        <td><?= $list['record_date']; ?></td>
                                        <td><?= $list['upload_time']; ?></td>
                                        <td><?= $list['Remark']; ?></td>
                                        <td>
                                            <form method="post" action="actions/ActionController.php"
                                                id="view-data-form">
                                                <input type="hidden" name="type" value="view-data-form">
                                                <input type="hidden" name="record_id" value="<?= $list['id']; ?>">
                                                <?php if($_SESSION['account_type'] == 'revenuecell'): ?>
                                                <button type="submit" class="btn btn-info"
                                                    id="view-file-data">View</button>
                                                <?php else :?>
                                                <button type="submit" class="btn btn-info"
                                                    id="view-file-data">Upload-file</button>
                                                <?php endif;?>
                                            </form>
                                        </td>
                                    </tr>

                                    <?php endforeach; ?>


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Filename (System)</th>
                                        <th>Filename (Original)</th>
                                        <th>Category</th>

                                        <th data-type="date" data-format="YYYY/DD/MM">Record Date</th>
                                        <th>Upload Time</th>
                                        <th>Description</th>
                                        <th>Action</th>
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

            if (response == "1" || response == 1) {

                $("#file-upload-area").hide();
                current += '?date=' + val;
                // alert("You can't upload file Locked from Backend"); 
            } else {
                current += '?date=' + val;
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

$("#select-file-type").change(function() {
    var vd = $(this).find(":selected").val();
    if (vd == "URC Images") {
        $("#file1").prop('multiple', true);
    } else {
        $("#file1").removeAttr('multiple');
    }
})

function SingleDownload(val) {
    var code = "<?= $_SESSION['user_code'] ?>";
    if(code == "revenuecell"){
        var type = "create log for single file";
    }else{
        var type = "create log for single file failed pos";
    }
    $.ajax({
        url: "actions/ActionController.php", // Replace with the actual API endpoint
        method: "GET", // Use GET or POST depending on your API requirements
        data: {
            "type": type,
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

function getCurrentDate() {
    var today = new Date();
    var year = today.getFullYear();
    var month = String(today.getMonth() + 1).padStart(2, '0');
    var day = String(today.getDate()).padStart(2, '0');
    return year + month + day;
}
</script>
<script src="path/to/xlsx.full.min.js"></script>