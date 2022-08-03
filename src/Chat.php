<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

// require_once('../database/ChatRoomClass.php');
// require_once('../database/UserClass.php');
require dirname(__DIR__) . '/database/UserClass.php';
require dirname(__DIR__) . '/database/ChatRoomClass.php';
require dirname(__DIR__) . '/database/SecureChatClass.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo "Server Started";
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
            
            $data = json_decode($msg, true);

            if($data['chatType']=="secure"){
                
                $chat_object = new \SecureChat();
                $chat_object->setToUserId($data['to_user_id']);
                $chat_object->setFromUserId($data['from_user_id']);
                $chat_object->setChatMessage($data['msg']);
                $chat_object->save_chat();
                foreach ($this->clients as $client) {
                    if ($from !== $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send(json_encode($data));
                    }
                }
            }else {
                
                $chat_object = new \ChatRooms();
                $chat_object->setUser_Id($data['userId']);
                $chat_object->setMessage($data['msg']);
                $chat_object->save_chat();

                $user_object = new \User();
                $user_object->setUserEmail($data['userEmail']);
                $user_data = $user_object->get_user_data_by_email();
                $data['name'] = $user_data['user_name'];
                $data['email'] = $user_data['user_email'];
                $data['activation'] = $user_data['user_activation'];
                $data['profile'] = $user_data['user_profile'];
                $data['timestamp'] = $user_data['user_timestamp'];
                
                foreach ($this->clients as $client) {
                    if ($from !== $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send(json_encode($data));
                    }
                }
            }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}