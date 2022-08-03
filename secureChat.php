<?php
session_start();
require_once('./database/UserClass.php');
require_once('./database/SecureChatClass.php');
require_once('./database/converter.php');

if (!isset($_SESSION['isLogged'])) {
  header('location:./');
}

$user_object = new User;
$user_object->setUserId(trim($_GET['to_user_id']));
$user_data1 = $user_object->get_user_data_by_id_limit();

if(isset($_GET['to_user_id'])){
       if($_GET['to_user_id']==$_SESSION['user_data']['user_id']){
           header('location:./');
       }
}else {
  header('location:./');
}

$user_object = new User;
$user_data = $user_object->get_user_all_data();

$chat_object = new SecureChat;
$chat_object->setToUserId(trim($_GET['to_user_id']));
$chat_object->setFromUserId($_SESSION['user_data']['user_id']);
$chat_data = $chat_object->get_all_chat_data1();

$converter = new Converter();

?>
<?php include('./include/header.php'); ?>
<section style="background-color: #eee;">
  <div class="container py-2">
    <div class="row d-flex justify-content-center">
      <!-- col start -->
    <div class="col-md-4 col-sm-12">
        <h3 class="btn btn-secondary my-2 w-100">User List </h3>
        <?php foreach ($user_data as $user) { ?>
        <div class="card" style="border-radius: 15px;">
          <div class="card-body p-2">
            <div class="d-flex flex-column text-black">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <img src="<?php echo $user['user_profile'] ?>" alt="user-profile" class="img-fluid" style="width:100px; border-radius: 10px;">
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="mb-1"><?php echo $user['user_name'] ?></h5>
                  <p class="small text-muted mb-1">Last Active 2 mint ago</p>
                  <div class="d-flex justify-content-start rounded-3 p-1 mb-1" style="background-color: #efefef;">
                    <div>
                      <p class="small mb-1">Email : <span class='text-secondary'> <?php echo substr($user['user_email'], 0, 3); ?>******@gmail.com </span></p>
                      <p class="small mb-1">Phone : <span class='text-danger'> Not Available </span> </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex">
                 <?php if($user['user_id']==$_SESSION['user_data']['user_id']){
                    echo '<a href="#" class="btn btn-warning me-1 flex-grow-1"> You </a>';
                 }else { 
                  if(strtoupper($user['user_activation'])=="ENABLE"){
                    echo '<a href="secureChat.php?to_user_id='.$user['user_id'].'" target="blank" class="btn btn-outline-primary me-1 flex-grow-1"> Chat</a>';
                  }
                } 
                  if (strtoupper($user['user_activation']) == "ENABLE") {
                    echo '<a href="user-profile.php?id='.$user['user_id'].'" class="btn btn-primary flex-grow-1"> View-Profile </a>';
                        } else {
                          echo '<button type="button" class="btn btn-danger flex-grow-1"> Disabled </button>';
                        } ?>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>

      </div>  
    <!-- col end -->
    <!-- col start -->
      <div class="col-md-8 col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center p-3">
          <h5 class="mb-0"><?php echo $user_data1['user_name'] ?>'s chat</h5>
            <button type="button" class="btn btn-primary btn-sm" data-mdb-ripple-color="dark">Let's Chat
              App</button>
          </div>
          <div class="chat-body1 w-100 my-1" style="overflow-y:auto; height:450px; width:auto">
          <?php
            if (!empty($chat_data)) {
              foreach ($chat_data as $chat) {
              if ($chat['from_user_id']==$_SESSION['user_data']['user_id']) {
                $row_class = 'd-flex flex-row justify-content-end';
                $background_class = 'small p-2 me-2 mb-1 d-flex justify-content-end text-light rounded-3 bg-success';
                echo '<div class="' . $row_class . '">
                      <div>
                        <p class="' . $background_class . '">' . $chat['chat_msg'] . ' </p>
                        <p class="small me-2 mb-3 rounded-3 text-muted d-flex justify-content-end text-sm"><i> '.$converter->timeAgo($chat['timestamp']).'</i></p>
                      </div>
                      <img src="'. $chat['from_user_profile'].'"  class="rounded-circle mx-1" alt="avatar 1" style="width: 45px; height: 100%;">
                    </div>';
              } else  {
                $row_class = 'd-flex flex-row justify-content-start';
                $background_class = 'small p-2  me-2 mb-1 rounded-3 bg-danger text-light';
                echo '<div class="' . $row_class . '">
                        <img src="' . $chat['from_user_profile'] . '" alt="avatar 1" class="mx-1 rounded-circle" style="width: 45px; height: 100%;">
                      <div>
                        <p class="' . $background_class . '">' . $chat['chat_msg'] . ' </p>
                        <p class="small me-2 rounded-3 text-muted"> <i> '.$converter->timeAgo($chat['timestamp']).' </i></p>
                      </div>
                    </div>';
              }
              }
            } else {
              echo '
              <div class=" text-center mt-4 no-message1">
                    <h5 class="text-muted mt-4"> <i>Start Your Chat Now..</i> </h5>
                    <h6 class="text-secondary m-2"> Your`s messages will secured. <h6>
                </div>';
            }
            ?>
            <div id="chatBody1">
            </div>
          </div>
        </div>
        <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
          <img src="<?php echo $_SESSION['user_data']['user_profile']; ?>" alt="avatar 3" style="width: 40px; height: 100%;">
          <input type="text" class="form-control form-control-lg message" id="exampleFormControlInput1" placeholder="Type message">
          <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
          <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
          <a class="ms-3" href="#" id="send"><i class="fas fa-paper-plane"></i></a>
        </div>
      </div>
      <!-- col end  -->
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
         <img src="' + getData.profile + '"\
           alt="avatar 1" style="width: 45px; height: 100%;" class="rounded-circle mx-1">\
         <div>\
         <p class="small p-2  me-2 mb-1 rounded-3 bg-danger text-light">' + getData.msg + '\
                </p>\
           <p class="small me-2 rounded-3 text-muted"><i> just now </i> </p>\
         </div>';
      jQuery('#chatBody1').append(html);
      $('.chat-body1').scrollTop($('.chat-body1')[0].scrollHeight);
    };

    $('#send').click(function() {
      var msg = jQuery('.message').val();
      var content = {
        msg: msg,
        profile:"<?php echo $_SESSION['user_data']['user_profile'] ?>",
        from_user_id: "<?php echo $_SESSION['user_data']['user_id'] ?>",
        to_user_id: <?php echo trim($_GET['to_user_id']); ?>,
        chatType: "secure",
      };
      conn.send(JSON.stringify(content));
      var html = '<div class="d-flex flex-row justify-content-end new-message" >\
              <div>\
                <p class="small p-2 me-2 mb-1 text-white rounded-3 bg-success">' + msg + '\
                </p>\
                <p class="small me-2 mb-3 rounded-3 text-muted d-flex justify-content-end"><i> just now </i></p>\
              </div>\
              <img src="<?php echo $_SESSION['user_data']['user_profile'] ?>" class="rounded-circle mx-1"\
                alt="avatar 1" style="width: 45px; height: 100%;">\
            </div>';
      jQuery('#chatBody1').append(html);
      $('.message').val('');
      $('.chat-body1').scrollTop($('.chat-body1')[0].scrollHeight);
      $('.no-message1').remove();
    });
    // on browser refersh go to chat of bottm
    $('.chat-body1').scrollTop($('.chat-body1')[0].scrollHeight);
  })
</script>
<?php include('./include/footer.php') ?>