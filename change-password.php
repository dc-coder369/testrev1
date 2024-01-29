<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
    <?php include 'layouts/alert.php'; ?>
    <div class="pagetitle">


        <?php


        $usersList = $database->select('tab_user_details', "*", [], "AND", 'multiple', 'id DESC', []);


        ?>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Change Password</h5>

                            <form method="post" action="actions/ActionController.php" class="mb-4" id="passwordChangeForm">
                                <input type="hidden" name="type" value="update-password">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                    <label for="user" class="form-label">Select User:</label>
                                    <select name="user_id" id="user" class="form-select">
                                        <?php foreach ($usersList as $user) : ?>
                                            <option value='<?php echo $user['id']; ?>'>
                                                <?php echo $user['username']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                    <label for="new_password" class="form-label">New Password:</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                                    </div>
                                </div>
 
                                <button type="submit " name="submit" class="btn btn-success mt-4">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>

        </section>
    </div>
</main>
<?php include 'layouts/footer.php'; ?>