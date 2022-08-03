<?php

class ChatRooms
{
	private $chat_id;
	private $user_id;
	private $message;
	private $timestamp;
	protected $connect;

	public function setChatId($chat_id)
	{
		$this->chat_id = $chat_id;
	}

	function getChatId()
	{
		return $this->chat_id;
	}

	function setUser_Id($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUser_Id()
	{
		return $this->user_id;
	}

	function setMessage($message)
	{
		$this->message = $message;
	}

	function getMessage()
	{
		return $this->message;
	}

	function getTimestamp()
	{
		return $this->timestamp;
	}

	public function __construct()
	{
		require_once("config.php");
		$database_object = new Database_connection;
		$this->connect = $database_object->connect();
	}

	function save_chat()
	{
		$query = "
		INSERT INTO chatrooms 
			(user_id, msg) 
			VALUES (:user_id, :msg)
		";
		$statement = $this->connect->prepare($query);
		$statement->bindParam(':user_id', $this->user_id);
		$statement->bindParam(':msg', $this->message);
		try {
			if ($statement->execute()) {
				return "true";
			} else {
				return "Unable to saved data";
			}
		} catch (Exception $e) {
			return "Error " . $e;
		}
	}

	function get_all_chat_data()
	{
		$query = "
		SELECT * FROM chatrooms 
			INNER JOIN users 
			ON users.user_id = chatrooms.user_id 
			ORDER BY chatrooms.chat_id ASC
		";
		$statement = $this->connect->prepare($query);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	function timeAgo($time_ago)
	{
		$time_ago = strtotime($time_ago);
		$cur_time   = time();
		$time_elapsed   = $cur_time - $time_ago;
		$seconds    = $time_elapsed;
		$minutes    = round($time_elapsed / 60);
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400);
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640);
		$years      = round($time_elapsed / 31207680);
		// Seconds
		if ($seconds <= 60) {
			return "just now";
		}
		//Minutes
		else if ($minutes <= 60) {
			if ($minutes == 1) {
				return "one minute ago";
			} else {
				return "$minutes minutes ago";
			}
		}
		//Hours
		else if ($hours <= 24) {
			if ($hours == 1) {
				return "an hour ago";
			} else {
				return "$hours hrs ago";
			}
		}
		//Days
		else if ($days <= 7) {
			if ($days == 1) {
				return "yesterday";
			} else {
				return "$days days ago";
			}
		}
		//Weeks
		else if ($weeks <= 4.3) {
			if ($weeks == 1) {
				return "a week ago";
			} else {
				return "$weeks weeks ago";
			}
		}
		//Months
		else if ($months <= 12) {
			if ($months == 1) {
				return "a month ago";
			} else {
				return "$months months ago";
			}
		}
		//Years
		else {
			if ($years == 1) {
				return "one year ago";
			} else {
				return "$years years ago";
			}
		}
	}
}
