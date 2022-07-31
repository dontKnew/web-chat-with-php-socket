<?php
session_start();
require_once('./database/UserClass.php');
require_once('./database/ChatRoomClass.php');

if (!isset($_SESSION['isLogged'])) {
  header('location:./');
}

$chat_object = new ChatRooms;
$chat_data = $chat_object->get_all_chat_data();
$user_object = new User;
$user_data = $user_object->get_user_all_data();

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
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="./public/js/socket.js" type="text/javascript"></script>
</head>
<style>
  html,
  body {
    height: 100%;
    width: 100%;
    margin: 0;
  }
</style>

<body>
  <section style="background-color: #eee;">
    <div class="container py-5">

      <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-6">
          <div class="d-flex justify-content-between">
            <a href="logout.php" class=""> Welcome <?php echo strtoupper($_SESSION['user_data']['user_name']) ?> :) </a>
            <a href="logout.php" class="text-danger"> <strong>Logout</strong> </a>
          </div>
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-3">
              <h5 class="mb-0">Group-Chat</h5>
              <button type="button" class="btn btn-primary btn-sm" data-mdb-ripple-color="dark">Let's Chat
                App</button>
            </div>

            <div class="chat-body w-100 my-1" style="overflow-y:auto; height:450px; width:auto">
            <?php
            if(!empty($chat_data)){
              foreach ($chat_data as $chat) {
                if ($chat['user_id'] == $_SESSION['user_data']['user_id']) {
                  $from = 'You';
                  $row_class = 'd-flex flex-row justify-content-end';
                  $background_class = 'small p-2 me-3 mb-1 text-light rounded-3 bg-success';
                  echo '<div class="' . $row_class . '">
                      <div>
                        <p class="' . $background_class . '">' . $chat['msg'] . ' </p>
                        <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">' . $from . '</p>
                      </div>
                      <img src="./public//image/avtar.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                    </div>';
                } else {
                  $from = 'by '.strtolower($chat['user_name']);
                  $row_class = 'd-flex flex-row justify-content-start';
                  $background_class = 'small p-2 me-3 mb-1 rounded-3 bg-danger text-light';
                  echo '<div class="' . $row_class . '">
                        <img src="./public//image/avtar.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                      <div>
                        <p class="' . $background_class . '">' . $chat['msg'] . ' </p>
                        <p class="small me-3 mb-3 rounded-3 text-muted">' . $from . '</p>
                      </div>
                    </div>';
                }
              }
            }else{
              echo '
              <div class="d-flex flex-row justify-content-center mt-4 no-message">
                    <h5 class="text-muted mt-4"> <i>Start Your Group Chat Now..</i> </h5>
                </div>'; 
            }
            ?>
            <div id="chatBody">
            </div>
            </div>
          </div>
          <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
            <img src="./public/image/avtar.webp" alt="avatar 3" style="width: 40px; height: 100%;">
            <input type="text" class="form-control form-control-lg message" id="exampleFormControlInput1" placeholder="Type message">
            <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
            <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
            <a class="ms-3" href="#" id="send"><i class="fas fa-paper-plane"></i></a>
          </div>
        </div>

      </div>
    </div>

    </div>
  </section>
  <script>
    $("document").ready(function() {
      var conn = new WebSocket('ws://localhost:8080');
      conn.onopen = function(e) {
        console.log("Connection established!");
      };
      conn.onmessage = function(e) {
        var getData = jQuery.parseJSON(e.data);
        var html = '\
       <div class="d-flex flex-row justify-content-start">\
         <img src="./public//image/avtar.webp"\
           alt="avatar 1" style="width: 45px; height: 100%;">\
         <div>\
         <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-danger text-light">' + getData.msg + '\
                </p>\
           <p class="small me-3 mb-3 rounded-3 text-muted">Name: ' + getData.name + '</p>\
         </div>';
        jQuery('#chatBody').append(html);
      };

      $('#send').click(function() {
        var msg = jQuery('.message').val();
        var name = "<?php echo $_SESSION['user_data']['user_name'] ?>";
        var content = {
          msg: msg,
          name: name,
          userId: <?php echo $_SESSION['user_data']['user_id'] ?>
        };
        conn.send(JSON.stringify(content));
        var html = '<div class="d-flex flex-row justify-content-end new-message" >\
              <div>\
                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-success">' + msg + '\
                </p>\
                <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">You</p>\
              </div>\
              <img src="./public/image/avtar.webp"\
                alt="avatar 1" style="width: 45px; height: 100%;">\
            </div>';
        jQuery('#chatBody').append(html);
        $('.message').val('');        
        $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);
        $('.no-message').remove();
      });

    })
  </script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.js"></script>
</body>

</html>