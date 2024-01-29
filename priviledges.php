<?php include 'layouts/header.php'; ?>
<main id="main" class="main">
    <?php include 'layouts/alert.php'; ?>
    <div class="pagetitle">

        <?php
        $usersList = $database->select('tab_user_details', "*", ['account_type' => 'SI'], "AND", 'multiple', 'id DESC', []);

        $selectedUser = (isset($_GET['selected_user'])) ?  $_GET['selected_user'] : '';
        function generateCheckBoxes($selectedUser, $database)
        {

            global $conn;
            // Check if a user is selected
            if (!empty($selectedUser)) {

                $result = $database->select('tab_user_details', "username", ['account_type' => 'station'], "AND", 'multiple', 'id DESC', []);

                $checkboxHTML = '';
                // Check if there are rows in the result
                if (!empty($result)) {
                    $checkboxHTML .= '<h2>Select Users from Station</h2>';

                    foreach ($result as $row) {

                        $username = htmlspecialchars($row["username"]); // Fetch the username
                        $checkboxHTML .= '<div class="col-md-2 mb-3">';
                        $checkboxHTML .= '<div class="form-check">';
                        $checkboxHTML .= '<input class="form-check-input" type="checkbox" name="checkbox_array[]" value="' . $username . '">';
                        $checkboxHTML .= '<label class="form-check-label">' . $username . '</label>'; // Display the username
                        $checkboxHTML .= '</div>';
                        $checkboxHTML .= '</div>';
                    }
                } else {
                    $checkboxHTML = 'No records found.';
                }
                return $checkboxHTML;
            } else {
                return ''; // Return an empty string if no user is selected
            }
        }

        ?>

        <section class="section dashboard">

            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Adjust Previledges</h5>
                            <form method="post" action="actions/ActionController.php" class="mb-4" name="form_f1" id="checkbox-form">
                                <!-- Add a hidden input field to capture the selected user value -->
                                <input type="hidden" id="selected-user" name="selected_user" value="<?=$selectedUser;?>">
                                <input type="hidden" name="type" value="update-privilege">

                                <div class="mb-3">
                                    <label for="si_user" class="form-label">Select SI User:</label>

                                    <select name="select_s1" id="select_s1" class="form-select">
                                        <?php foreach ($usersList as $user) : ?>
                                            <option 
                                                <?php if($selectedUser == $user['username'] ) { ?> selected <?php } ?>
                                            value='<?php echo $user['username']; ?>'>
                                                <?php echo $user['username']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>



                                </div>


                                <!-- Add an empty div to hold the checkboxes -->
                                <div id="checkbox-container" class="row">
                                    <?php echo generateCheckBoxes($selectedUser, $database); ?>
                                </div>

                                <button type="submit" name="submit_privilege" class="btn btn-primary">Submit privilege</button>
                            </form>

                            <h2>Privilege List</h2>
                            <p>Privilege list of SI users and Station users</p>

                            <div class="container mt-5">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>SI User</th>
                                            <th>Station User</th>
                                            <th>Station Allotted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rows = $database->select('tab_user_details', "*", ['account_type' => 'SI'], "AND", 'multiple', 'id DESC', []);


                                        foreach ($rows as $row) {
                                            echo "<tr>";
                                            echo "<td>{$row['username']}</td>";
                                            echo "<td>{$row['stationname']}</td>";
                                            echo "<td>{$row['stations_allotted']}</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
    </div>
    <script>
      

       
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</main>
<?php include 'layouts/footer.php'; ?>
<script>
$("#select_s1").on("change",function(){
            var val = $(this).val(); 
            var curnt = location.origin + location.pathname; 

            location.href=curnt+'?selected_user=' + val
});
</script>