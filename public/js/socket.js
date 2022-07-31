// $("document").ready(function(){
//   var conn = new WebSocket('ws://localhost:8080');
//   conn.onopen = function(e) {
//       console.log("Connection established!");
//   };
  
//   conn.onmessage = function(e) {
//     var getData=jQuery.parseJSON(e.data);
//       // var html="<b>"+getData.name+"</b>: "+getData.msg+"<br/>";
//        var html = '<div class="card-body">\
//        <div class="d-flex flex-row justify-content-start mb-4">\
//          <img src="./public//image/avtar.webp"\
//            alt="avatar 1" style="width: 45px; height: 100%;">\
//          <div>\
//            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Sorry I don`t have. changed my phone.</p>\
//            <p class="small ms-3 mb-3 rounded-3 text-muted">Name:Sajid Ali</p>\
//          </div>\
//        </div>';
//     jQuery('#chatBody').append(html);
//   };
  
//   $('#send').click(function(){
//     console.warn("ciekced");
//     var msg=jQuery('.message').val();
//     var name="<?php echo $_SESSION['fullname']?>";
//     var content={
//       msg:msg,
//       name:name
//     };
//     conn.send(JSON.stringify(content));
//       var html = '<div class="card-body">\
//        <div class="d-flex flex-row justify-content-start mb-4">\
//          <img src="./public//image/avtar.webp"\
//            alt="avatar 1" style="width: 45px; height: 100%;">\
//          <div>\
//            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">'+msg+'</p>\
//            <p class="small ms-3 mb-3 rounded-3 text-muted">Name:'+name+'</p>\
//          </div>\
//        </div>';
//     jQuery('#chatBody').append(html);
//       $('.message').val('');
//   });
  
// })
