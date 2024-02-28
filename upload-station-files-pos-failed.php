<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
  <?php include 'layouts/alert.php'; ?>


  <?php
   $data = $_SESSION['data'];
  ?>
  <div class="pagetitle">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Upload Files</h5>

              <!-- Browser Default Validation -->
              <form class="g-3" method="post" enctype="multipart/form-data" id="uploadForm" action="actions/ActionController.php">
                <input type="hidden" name="type" value="upload-subfile">
                <input type="hidden" name="fileType" value="pos-failed">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                <input type="hidden" name="master_file_id" value="<?= $data[0]['id']; ?>">
                <div class="row mt-2">
                  <div class="col-md-6">
                    <label class="col-sm-4 col-form-label">Master File :</label>
                    <label class="col-form-label"><?= $data[0]['filename']?></label>
                  </div>
                </div> 
                <div id="file-upload-area" style="display: block;">
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <label for="validationDefault03" class="form-label">Choose a File:</label>
                      <input type="file" class="form-control" id="file1" name="files[]">
                      <span class="form-text text-muted">Upload File of the Selected Category</span>
                    </div>
                    <div class="col-md-6">
                      <label for="inputDate" class="form-label">Uploaded By</label>
                      <input type="text" class="form-control" name="sc_name" placeholder="Enter SC name" required>
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
<script>