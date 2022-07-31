<?php
/*Testing
Code : 31d660814976a342d8bc3011f5e6ceeb
user : 1101001 1110011 1110010 1100001 1100110 1101001 1101100 110001 110010 110011 101110 1110011 1100001 1000000 1100111 1101101 1100001 1101001 1101100 101110 1100011 1101111 1101101
url : http://localhost/PHP/socket/web-chat/chat/changepassword.php?user=1101001%201110011%201110010%201100001%201100110%201101001%201101100%20110001%20110010%20110011%20101110%201110011%201100001%201000000%201100111%201101101%201100001%201101001%201101100%20101110%201100011%201101111%201101101&code=31d660814976a342d8bc3011f5e6ceeb
*/
  if(isset($_GET['code']) && isset($_GET['user'])){
    require_once './database/converter.php';
      $converter = new Converter();
      $email = $converter->binaryToString($_GET['user']);

    if(isset($_REQUEST['submit'])){
      $email = trim($_POST['email']); 
      $password1 = trim($_POST['password1']);
      $password2 = trim($_POST['password2']);
      
      require_once './database/UserClass.php';
        $user_object = new User;
        $user_object->setUserEmail($email);
        $user_data = $user_object->get_user_data_by_email();
        $user_object->setUserName($user_data['user_name']);
        $user_object->setUserId($user_data['user_id']);
        $user_object->setUserPassword($user_data['user_password']);
        $user_object->setUserActivation($user_data['user_activation']);
        $user_object->setUserProfile($user_data['user_profile']);
        $user_object->setUserVerificationCode($user_data['user_verification_code']);
          if($_GET['code']==$user_object->getUserVerificationCode()){
              if($password2 == $password1){
                      if($password1 == $user_object->getUserPassword()){
                          $error_message = "Old Password could not be as new password";        
                      }else {
                          $user_object->setUserPassword($password1);
                          $user_object->setUserVerificationCode(md5(uniqid()));
                          if($user_object->update_data()){
                              $success_message  = "Password has been changed successfully!";
                          }else {
                              $error_message = "Passowrd could not change, please try again later";
                          }
                      }
              }else {
                  $error_message = "Please enter same passsword";
              }
          }else {
              $error_message = "Verification code is incorrect";
          }
  }
  }else {
    header('location:forgetpassword.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Chat-Aplication </title>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./public/css/style.css">
  <link rel="stylesheet" href="./public/css/font-awesome.min.css">
</head>
<body>
  <section style="background-color: #eee;">
    <div class="container py-5">

      <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-6">

          <div class="card" id="chat2">
            <div class="card-header d-flex justify-content-between align-items-center p-3">
              <h5 class="mb-0">Change Password Form</h5>
              <a href="./"><button type="button" class="btn btn-primary btn-sm" data-mdb-ripple-color="dark">Back to Login</button></a>
            </div>

            <div class="card-body">
              <?php if(isset($error_message)) {echo "<div class='alert alert-warning' alert='role'>".$error_message."</div>";}?>
              <?php if(isset($success_message)) {echo "<div class='alert alert-success' alert='role'>".$success_message."</div>";}?>
              <form action="" method="POST">
                <!-- Email input -->
                <div class="form-outline">
                  <input type="email" name="email" value="<?php echo $email ?>" id="form1Example1" class="form-control" aria-describedby="emailHelp" readonly required/>
                  <label class="form-label" for="form1Example1">Registered Email address</label>
                </div>
                <div id="emailHelp" class="form-text mb-4">We'll send an link to your email address.</div>
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
              <button name="submit" class="btn btn-danger btn-block">Submit</button><br>
              <span class="mx-4">Are you having in tourbleshoot ?<a href="mailto:israfil123.sa@gmail.com" > <u> contact us </u></a></span>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    </div>
  </section>
  <!-- script -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
</body>

</html>