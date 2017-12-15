<?php
	$user1 = $_GET['user'];
	$pass = $_GET['pass'];
	$query = $_GET['query'];
	if($query == "login"){
		$connection = new mysqli("localhost","root","tushar1997","ChatApp");
		$result = $connection->query("select Username,Password from LoginTable");
		$flag = false;
		while($row = $result->fetch_assoc()){
			if($row['Username'] == $user1){
				$flag = true;
				if($row['Password'] == $pass){
					echo "verified";
				}
				else {
					echo "Invalid Password";
				}
			}
		}
		if(!$flag){
			echo "Username does not exist";
		}
		$connection->close();
	}
	else if($query == "chats"){
		$connection = new mysqli("localhost","root","tushar1997","ChatApp");
		$result = $connection->query("select Contact from Contacts where User='$user1'");
		if(!$result){
			echo "Query Error<br>";
		}
		while($row = $result->fetch_assoc()){
			$contact = $row['Contact'];
			echo "<button onclick='startConversation(\"".$contact."\")'>".$contact."</button>";
			echo "<br><br>";
		}
		$connection->close();
	}
	else if($query == "chatSelect"){
		$user1 = $_GET['user1'];
		$user2 = $_GET['user2'];
		echo $user1." with ".$user2;
	}
	else if($query == "sendMsg"){
		$user1 = $_GET['user1'];
		$user2 = $_GET['user2'];
		$msg = $_GET['msg'];
		$connection = new mysqli("localhost","root","tushar1997","ChatApp");
		$result = $connection->query("select max(ID) from Messages");
		$row = $result->fetch_assoc();
		$id = $row['max(ID)'] + 1;
		$result = $connection->query("insert into Messages values($id,'$msg','$user1','$user2')");
		if($result)
			echo "Insert Successful";
		else
			echo "Query Error";
		$connection->close();
	}
	else if($query == "loadChat"){
		$user1 = $_GET['user1'];
		$user2 = $_GET['user2'];
		$connection = new mysqli("localhost","root","tushar1997","ChatApp");
		$result = $connection->query("select Message from Messages where Sender='$user1' and Receiver='$user2'");
		echo "<div id='sent'>Sent messages<br>";
		while($row = $result->fetch_assoc()){
			echo $row['Message'];
			echo "<br><br>";
		}
		echo "</div>";
		$result = $connection->query("select Message from Messages where Sender='$user2' and Receiver='$user1'");
		echo "<div id='recvd'>Received messages<br>";
		while($row = $result->fetch_assoc()){
			echo $row['Message'];
			echo "<br><br>";
		}
		echo "</div>";
		$connection->close();
	}
?>
