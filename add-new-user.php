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
                            <h5 class="card-title">Create New User</h5>
                            <form method="post"  action="actions/ActionController.php"  class="mb-4" id="addnewuser">

                                <input type="hidden" name="type" value="add-new-user">

                                <script>
                                    function updateLabel() {
                                        var userType = document.getElementById("station_type").value;
                                        var label = document.getElementById("label_station_name");

                                        if (userType == "Station") {
                                            label.innerHTML = "Station Name:";
                                        } else if (userType == "SI") {
                                            label.innerHTML = "Station Incharge Name:";
                                        }
                                    }
                                </script>

                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label for="station_type" class="form-label">Select User Type:</label>
                                        <select name="station_type" id="station_type" onchange="updateLabel()" class="form-select">
                                            <option value="Station">STATION</option>
                                            <option value="SI">SI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="label_station_name" for="station_name" class="form-label">Station Name:</label>
                                        <input type="text" name="station_name" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="user_code" for="station_name" class="form-label">User Code:</label>
                                        <input type="text" name="user_code" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username:</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                </div> 

                                <button type="submit" name="submit1" class="btn btn-success mt-4">Create User</button>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</main>
<?php include 'layouts/footer.php'; ?>