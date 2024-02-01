<?php include 'layouts/guest-head.php'; ?>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

			<div class="d-flex justify-content-center py-4">
                <a href="login.php" class="d-flex align-items-center w-auto">
                  <img src="assets/img/g-logo.png" alt="" style="width: 100px; height: auto;">
                </a>
              </div>
			  
              <div class="d-flex justify-content-center py-4">
                <a href="login.php" class="logo d-flex align-items-center w-auto">
                  <!--<img src="assets/img/g-logo.png" alt="">-->
                  <span class="d-none d-lg-block">GMRC Ops Connect</span>
                </a>
              </div><!-- End Logo -->

              

              <div class="card mb-3">


                <div class="card-body">


                <?php include 'layouts/alert.php'; ?>

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post" action="actions/ActionController.php">
                  <input type="hidden" name="type" value="login">
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0"><a href="pages-register.html"></a></p>
                    </div>
                  </form>

                </div>
              </div>
 
            </div>
          </div>
        </div>

      </section>

    </div>
<?php include 'layouts/guest-foot.php'; ?>
