  <!-- ======= Sidebar ======= -->

  <?php $current_page = basename($_SERVER['PHP_SELF']);?>
  <aside id="sidebar" class="sidebar">
    

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <?php if ($_SESSION['account_type'] == 'station') : ?>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-button-wide"></i><span>Stations</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav" 

          class="<?=($current_page == 'scdata-list.php' || $current_page == 'upload-files.php') ?'nav-content collapse show' : 'nav-content collapse'?>"
           
          data-bs-parent="#sidebar-nav">
            <!-- <li>
              <a href="upload-files.php" 
               
              class="<?=($current_page == 'upload-files.php') ?'active' : ''?>" >
                <i class="bi bi-circle"></i><span>Upload</span>
              </a>
            </li> -->
            <li>
              <a href="scdata-list.php" class="<?=($current_page == 'scdata-list.php') ?'active' : ''?>">
                <i class="bi bi-circle"></i><span>Upload Data</span>
              </a>
            </li>

          </ul>
        </li>

      <?php endif; ?>

      <?php if ($_SESSION['account_type'] == 'revenuecell') : ?>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-button-wide"></i><span>Revenue Cell</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav" 

          class="<?=($current_page == 'revenuecell-list.php' || $current_page == 'upload-files.php') ?'nav-content collapse show' : 'nav-content collapse'?>"
           
          data-bs-parent="#sidebar-nav">
            <li>
              <a href="revenuecell-list.php" 
               
              class="<?=($current_page == 'revenuecell-list.php') ?'active' : ''?>" >
                <i class="bi bi-circle"></i><span>View Data</span>
              </a>
            </li>
            

          </ul>
        </li>
      <?php endif; ?>



      <?php if ($_SESSION['account_type'] == 'SI') : ?>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-button-wide"></i><span>SI</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <!-- <li>
              <a href="upload-files.php" class="active">
                <i class="bi bi-circle"></i><span>Upload</span>
              </a>
            </li> -->
            <li>
              <a href="si-list.php" class="active">
                <i class="bi bi-circle"></i><span>Upload Data</span>
              </a>
            </li>

          </ul>
        </li>
      <?php endif; ?>






    </ul>

  </aside><!-- End Sidebar-->