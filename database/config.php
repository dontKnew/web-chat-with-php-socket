<?php

//Database_connection.php

class Database_connection
{
	function connect()
	{
		$connect = new PDO("mysql:host=localhost; dbname=socket-chat-app2", "root", "");

		return $connect;
	}
}

?>