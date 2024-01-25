<?php include 'layouts/header.php'; ?>
<?php 
   $listArr = $database->select('tab_logs_fileupload', "*", [], "AND", 'multiple');
?>


<main id="main" class="main">
    <?php include 'layouts/alert.php'; ?>
    <div class="pagetitle">


        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Upload Csv Here</h5>

                            <!-- Browser Default Validation -->
                            <form class="g-3" method="post" enctype="multipart/form-data" id="uploadForm" action="actions/ActionController.php"> 
                                
                            <input type="hidden" name="type" value="upload-files">
                            <input type="hidden" name="user_id" value="<?=$_SESSION['user_id'];?>">

                            <div class="row mt-2">
                                <div class="col-md-12">
                                        <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                                        <input type="date" class="form-control" name="recordDate"  id="recordDate"
                                        value="<?php echo htmlspecialchars($_POST['recordDate'] ?? date('Y-m-d')); ?>" min="2023-11-01"
                                        max="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
                                </div>

                            </div>
                            

                                <div id="file-upload-area" style="display: none;">
                                <div class="row mt-2">
                                    <div class="col-md-6" >
                                        <label for="validationDefault03" class="form-label">Choose Daily Revenue Sheets:</label>
                                        <input type="file" class="form-control" id="file1" name="files[]" multiple>
                                        <span>Upload File of the Selected Category</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validationDefault04" class="form-label">Choose URC Images Only:</label>
                                        <input type="file" class="form-control" id="file2" name="files2[]" accept="image/*, application/pdf" multiple >
                                
                                        <span>Upload Scanned Images or PDFs of URC Receipts</span>
                                    </div>
                                </div>


                                </div>


                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="validationDefault03" class="form-label">Remark</label>
                                        <textarea class="form-control" name="remark" placeholder="Enter Remark optional"></textarea> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputDate" class="col-sm-2 col-form-label">Name of Sc</label>
                                        <input type="text" class="form-control" name="sc_name" placeholder="Enter Sc name" required>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <!-- End Browser Default Validation -->

                        </div>
                    </div>

                </div>


            </div>
        </section>


</main><!-- End #main -->

<?php include 'layouts/footer.php'; ?>

<script>
    var today = "<?=date('Y-m-d');?>"; 
    getAjax(today);
        $("#recordDate").on("change", function () {
            var val = $(this).val(); 
            getAjax(val);  
        });

function getAjax(val){

    $.ajax({
        url: "actions/ActionController.php", // Replace with the actual API endpoint
        method: "GET", // Use GET or POST depending on your API requirements
        data: { "type" : "local_unlock_status", date: val }, // Pass any data you need to send to the server
        dataType: "json", // Specify the expected data type
        success: function (response) {
            if(response.lock_upload == "1" || response.lock_upload == 1 ){
                $("#file-upload-area").hide();
               // alert("You can't upload file Locked from Backend"); 
            }else{
                $("#file-upload-area").show();
            } 
        },
        error: function (error) {
            // Handle the error here
            console.error("Error fetching data:", error);
        }
    });

} 
</script>