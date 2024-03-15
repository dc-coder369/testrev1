<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
<?php include 'layouts/alert.php'; ?>
  
<div class="pagetitle">
<?php 
   $condition = [];
   $listArr = $database->select('pos_failed_transaction', "*", $condition, "AND", 'multiple','`upload_time` desc');
   $date1 = new DateTime($listArr[0]['record_date']); 
   $date2 = new DateTime(date("Y-m-d")); 
   $diff = $date2->diff($date1);
   $differencedate =  $diff->format("%a");
   $condition = [];
   $listFeatures = $database->select('new_features_update', "*", $condition, "AND", 'multiple','`created_time` desc');
?>
<section class="section dashboard">

    <h3> Welcome, <?= strtoupper($_SESSION['username']) ;?> </h3>
    <div class="container mt-5 mb-3">
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon d-none"> <i class="bi bi-calendar2-date-fill"></i> </div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0">GMRC</h6> <span><?php if($differencedate == 0){echo "Today";} else{ echo $differencedate . " days ago";} ?> </span>
                        </div>
                    </div>
                    <div class="badge"> <span>Records</span> </div>
                </div>
                      <div class="mt-4">
                        <div class = "style-h5">
                           <h4 class="heading">New Failed-POS File <br>Uploaded By Revenuecell</h4>
                        </div>
                        <div class="files-records">
                          <?php 
                          $itemsPerPage = 3;
                          $totalItems = count($listArr);
                          $totalPages = ceil($totalItems / $itemsPerPage);
                          $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                          $startIndex = ($currentPage - 1) * $itemsPerPage;
                          $endIndex = min($startIndex + $itemsPerPage, $totalItems);

                          for ($i = $startIndex; $i < $endIndex; $i++) {
                              $list = $listArr[$i];
                          ?>
                              <h5 class="d-none">Sunday-18 August</h5>
                              <div class="d-flex mt-4">
                                  <div class="icon">
                                      <i class="bi bi-file-earmark-text"></i>
                                  </div>
                                  <div class="details-files">
                                      <p><?= $list['filename']; ?></p>
                                      <p><span><?= $list['file_type']; ?> </span><span><?= $list['upload_time']; ?></span></p>
                                  </div>
                              </div>
                          <?php } ?>
                      </div>

                      <nav aria-label="Page navigation" class ="navstart">
                          <ul class="pagination justify-content-center">
                              <?php if ($currentPage > 1): ?>
                                  <li class="page-item prev-next">
                                      <a class="page-link" href="?page=<?=($currentPage - 1); ?>">&laquo; Prev</a>
                                  </li>
                              <?php endif; ?>

                              <?php for ($page = max(1, $currentPage - 1); $page <= min($totalPages, $currentPage + 1); $page++): ?>
                                  <li class="page-item <?=($page == $currentPage) ? 'active' : ''; ?>">
                                      <a class="page-link" href="?page=<?= $page; ?>"><?= $page; ?></a>
                                  </li>
                              <?php endfor; ?>

                              <?php if ($currentPage < $totalPages): ?>
                                  <li class="page-item prev-next">
                                      <a class="page-link" href="?page=<?=($currentPage + 1); ?>">Next &raquo;</a>
                                  </li>
                              <?php endif; ?>
                          </ul>
                      </nav>
                    <div class="mt-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width:<?= ($currentPage / $totalPages) * 100; ?>%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="mt-3"> <span class="text1">10 Stations are checked <span class="text2">POS-File of 32</span></span> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 mb-2 second_card" >
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon d-none"> <i class="bx bxl-dribbble"></i></div>
                        <div class="ms-2 c-details">
                            <h6 class="mb-0">GMRC</h6> <span>4 days ago</span>
                        </div>
                    </div>
                    <div class="badge"> <span>Features</span> </div>
                </div>
                <!-- <div class="mt-5">
                    <h3 class="heading">Junior Product<br>Designer-Singapore</h3> -->
                    <div class="mt-4">
                        <div class = "style-h5">
                           <h4 class="heading">Let's See New Features<br> & Version </h4>
                        </div>
                        <div class="files-records" <?php if(count($listFeatures) == 0): ?> style="display:none" <?php endif ?>>
                              <div class="d-flex mt-3">
                                <div class="icon d-none">
                                  <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div class="details-files">
                                  <h5><?= $listFeatures[0]['title']; ?></h5>
                                  <div class="d-flex">
                                      <div class="description">
                                        <p><?= substr($listFeatures[0]['description'],0,65); echo "....";?></p>
                                      </div>
                                      <div class="icon">
                                          <i id="b6" class="bi bi-eye-fill"></i>
                                      </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                        <div class="files-records" <?php if(count($listFeatures) == 0): ?> style="display:none" <?php endif ?>>
                              <div class="d-flex mt-3">
                                <div class="icon d-none">
                                  <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div class="details-files">
                                  <h5><?= $listFeatures[1]['title']; ?></h5>
                                  <div class="d-flex">
                                      <div class="description">
                                        <p><?= substr($listFeatures[1]['description'],0,65); echo "....";?></p>
                                      </div>
                                      <div class="icon">
                                          <i id="b7" class="bi bi-eye-fill"></i>
                                      </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
      <div class="row d-none">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Sales <span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>145</h6>
                      <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Revenue <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>$3,264</h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div> 
            </div>
              
    </section>

</main><!-- End #main -->
 
<?php include 'layouts/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('b7').onclick = function(){
	swal.fire({
		title: "<?= $listFeatures[1]['title']; ?>",
		text: "<?= $listFeatures[1]['description']; ?>"
	});
};
document.getElementById('b6').onclick = function(){
	swal.fire({
		title: "<?= $listFeatures[0]['title']; ?>",
		text: "<?= $listFeatures[0]['description']; ?>"
	});
};
</script>