<?php
/*Testing
Code : 31d660814976a342d8bc3011f5e6ceeb
user : 1101001 1110011 1110010 1100001 1100110 1101001 1101100 110001 110010 110011 101110 1110011 1100001 1000000 1100111 1101101 1100001 1101001 1101100 101110 1100011 1101111 1101101
url : /http://localhost/PHP/socket/web-chat/chat/changepassword.php?user=1101001%201110011%201110010%201100001%201100110%201101001%201101100%20110001%20110010%20110011%20101110%201110011%201100001%201000000%201100111%201101101%201100001%201101001%201101100%20101110%201100011%201101111%201101101&code=31d660814976a342d8bc3011f5e6ceeb
*/
    session_start();
    if(!isset($_SESSION['isLogged'])){
        header("location:login.php");
    }
    require_once './database/converter.php';
    if(isset($_REQUEST['submit'])){
        $email = trim($_POST['email']); 
        $password = trim($_POST['password']);
        $password1 = trim($_POST['password1']);
        $password2 = trim($_POST['password2']);
         
        require_once './database/UserClass.php';
        $user_object = new User;
        $user_object->setUserEmail($email);
        $user_data = $user_object->get_user_data_by_email();
        $user_object->setUserName($user_data['user_name']);
        $user_object->setUserId($user_data['user_id']);
        // $user_object->setUserPassword($user_data['user_password']);
        $user_object->setUserActivation($user_data['user_activation']);
        $user_object->setUserProfile($user_data['user_profile']);
        $user_object->setUserVerificationCode($user_data['user_verification_code']);
            
        if($password2 == $password1){
                if($password1 == $password){
                    $error_message = "Old Password could not be as new password";        
                }else {
                    $user_object->setUserPassword($password1);
                    if($user_object->update_data()){
                        $success_message  = "Password has been changed successfully!";
                    }else {
                        $error_message = "Passowrd could not change, please try again later";
                    }
                }
        }else {
            $error_message = "Please enter same passsword";
        }
    }
?>
<?php include('./include/header.php'); ?>
  <section style="background-color: #eee;">
    <div class="container py-5">

      <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-6">

          <div class="card" id="chat2">
            <div class="card-header d-flex justify-content-between align-items-center p-3">
              <h5 class="mb-0">Change Password Form</h5>
            </div>
            <div class="card-body">
              <?php if(isset($error_message)) {echo "<div class='alert alert-warning' alert='role'>".$error_message."</div>";}?>
              <?php if(isset($success_message)) {echo "<div class='alert alert-success' alert='role'>".$success_message."</div>";}?>
              <form action="" method="POST">
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="email" name="email" value="<?php echo $_SESSION['user_data']['user_email'] ?>" id="form1Example1" class="form-control" aria-describedby="emailHelp" readonly required/>
                  <label class="form-label" for="form1Example1">Registered Email address</label>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form1Example2" class="form-control" aria-describedby="emailHelp" required/>
                  <label class="form-label" for="form1Example2">Current Password </label>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="password1" id="form1Example2" class="form-control" aria-describedby="emailHelp" required/>
                  <label class="form-label" for="form1Example2">New Password </label>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="password2" id="form1Example3" class="form-control" aria-describedby="emailHelp" required/>
                  <label class="form-label" for="form1Example3">Confirm Password </label>
                </div>
            </div>
            <!-- Submit button -->
            <div class="mb-4">
              <button name="submit" class="btn btn-secondary btn-block">SUBMIT</button><br>
              <span class="mx-4">Are you having in tourbleshoot ?<a href="mailto:israfil123.sa@gmail.com" > <u> contact us </u></a></span>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    </div>
  </section>
<?php include('include/footer.php') ?>