<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
    <?php include 'layouts/alert.php'; ?>
    
    <?php
        $data = $_SESSION['data'];
        if($data):
        $condition = ['id' => $data[0]['master_file_id']];
        $listArr = $database->select('pos_failed_transaction', "*", $condition, "AND", 'multiple', '`upload_time` desc');
        endif;
    ?>
    <div class="pagetitle">

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <a href="Failed-POS-Transactions.php">
                                    <svg height="42px" id="Layer_1" style="enable-background:new 0 0 512 512;"
                                        version="1.1" viewBox="0 0 512 512" width="42px" xml:space="preserve"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <polygon
                                            points="352,128.4 319.7,96 160,256 160,256 160,256 319.7,416 352,383.6 224.7,256 " />
                                    </svg>
                                </a>
                                <h5 class="card-title">Failed POS Transaction</h5>
                            </div>
                            <div class="fw-bold py-4">Master File : <?php if($data):echo($listArr[0]['id']); endif; ?></div>
                            <!-- Table with stripped rows -->
                            <table class="table datatable table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th>SC Name </th>
                                        <th>Station Code</th>
                                        <th>Filename (System)</th>
                                        <th>Filename (Original)</th>
                                        <th>Category</th>
                                        <th data-type="date" data-format="YYYY/DD/MM">Record Date</th>
                                        <th>Upload Time</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($_SESSION['data']  as $list) :
                    $path = 'actions/scdata/' . $list['folder_name'] . '/' . $list['filename'];
                    $list['path']=$path;
                  ?>
                                    <tr id="<?= $list['id']; ?>">
                                        <td><?= $list['Sc_Name']; ?></td>
                                        <td><?= strtoupper($list['station_code']); ?></td>
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
                                        <th>Station Code</th>
                                        <th>Filename (System)</th>
                                        <th>Filename (Original)</th>
                                        <th>Category</th>

                                        <th data-type="date" data-format="YYYY/DD/MM">Record Date</th>
                                        <th>Upload Time</th>
                                        <th>Description</th>

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