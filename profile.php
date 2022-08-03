<?php
    session_start();
    if (!isset($_SESSION['isLogged'])) {
        header('location:./');
    }
    if(isset($_REQUEST['submit'])){
        require_once('./database/UserClass.php');
        $user_object = new User;
        
        $name = trim($_POST['fullname']);
        $profile = $_FILES['profile'];

        $user_object->setUserEmail($_SESSION['user_data']['user_email']);
        $user_data = $user_object->get_user_data_by_email();
        $user_object->setUserName($user_data['user_name']);
        
        if($profile['name'] != '') {
            if($user_profile = $user_object->move_image($profile)){
                 
            }else {
                $error_message = "User Image could not moved";
            }
        }else {
            $user_profile = $user_data['user_profile'];
        }
        $user_object->setUserName($name);
        $user_object->setUserId($user_data['user_id']);
        $user_object->setUserPassword($user_data['user_password']);
        $user_object->setUserActivation($user_data['user_activation']);
        $user_object->setUserProfile($user_profile);
        $user_object->setUserVerificationCode($user_data['user_verification_code']);
        if($user_object->update_data()){
            $_SESSION['user_data']['user_name'] = $name;
            $_SESSION['user_data']['user_profile'] = $user_profile;
            $success_message = "Profile has been updated";
        }else {
            $error_message  = "Profile could not update, Please try again";
        }

    }

?>
<?php include('./include/header.php'); ?>
<section style="background-color: #eee;">
    <div class="container py-2">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="card p-2">
                <div class="card-header d-flex justify-content-between align-items-center p-3">
                    <h5 class="mb-0">Update Profile</h5>
                </div>
                    <div class="card-body">
                        <?php if (isset($error_message)) {
                            echo "<div class='alert alert-warning' alert='role'>" . $error_message . "</div>";
                        } ?>
                        <?php if (isset($success_message)) {
                            echo "<div class='alert alert-success' alert='role'>" . $success_message . "</div>";
                        } ?>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                            <img src="<?php echo $_SESSION['user_data']['user_profile'];?>" alt="profile" class="shadow-lg rounded-circle img-fluid mb-2" width="120" height="120">
                            <input type="file" name="profile" class="form-control form-control-sm w-50 text-center" id="customFile" />
                        </div>
                            <div class="form-outline mb-4 text-center">
                                <input type="button" name="fullname" class="btn btn-dark" value="<?php if(strtoupper($_SESSION['user_data']['user_activation'])=="ENABLE") {echo "Account Status : Acitve"; }else{echo "Account Status-Disabled";} ?>" readonly required />
                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" name="fullname" id="form1Example1" value="<?php echo $_SESSION['user_data']['user_name'] ?>" class="form-control" required />
                                <label class="form-label" for="form1Example1">Full Name</label>
                            </div>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="form1Example1" value="<?php echo $_SESSION['user_data']['user_email'] ?>" class="form-control" readonly  required />
                                <label class="form-label" for="form1Example1" >Email address</label>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="customFile">Date of Registration </label>
                                <input type="text"  value="<?php echo $_SESSION['user_data']['user_timestamp'] ?>" name="timestmap" class="form-control" id="customFile" readonly/>
                            </div>
                            
                    </div>
                    <!-- Submit button -->
                    <div class="mb-4">
                        <button name="submit" class="btn btn-warning btn-block">Update</button><br>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>
</section>
<?php include('./include/footer.php') ?>