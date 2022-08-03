<?php
require 'database/ChatRoomClass.php';

$chat = new ChatRooms;
$data = $chat->get_all_chat_data();
// echo print_r($data[0]['timestamp']);

$current =  date('d-m-y h:i:s');
echo $chat->timeAgo($data[0]['timestamp']);

?>