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
	else if($query == "checkUser"){
		$user = $_GET['searchUser'];
		$connection = new mysqli("localhost","root","tushar1997","ChatApp");
		$result = $connection->query("select Username from LoginTable");
		$flag = false;
		while($row = $result->fetch_assoc()){
			if($row['Username'] == $user){
				$flag = true;
				break;
			}
		}
		if($flag){
			echo "Valid User";
		}
		else{
			echo "Invalid User";
		}
		$connection->close();
	}
	else if($query == "adduser"){
		$user2 = $_GET['addUser'];
		$user1 = $_GET['user1'];
		$connection = new mysqli("localhost","root","tushar1997","ChatApp");
		$result = $connection->query("insert into Requests values ('$user1','$user2')");
		$result2 = $connection->query("insert into Contacts values ('$user1','$user2')");
		if($result2){
			if($result){
				echo "request sent";
			}
		}
		$connection->close();
	}
	else if($query == "viewRequests"){
		$user = $_GET['user'];
		$connection = new mysqli("localhost","root","tushar1997","ChatApp");
		$result = $connection->query("select User from Requests where Request='$user'");
		echo "<table>";
		echo "<tr><th>Username</th></tr>";
		while($row = $result->fetch_assoc()){
			$user2 = $row['User'];
			echo "<tr><td>".$row['User']."</td><td><button onclick='acceptRequest(\"$user2\")'>Accept</button></td></tr>";
		}
		echo "</table>";
		$connection->close();
	}
	else if($query == "accept"){
		$user = $_GET['user1'];
		$contact = $_GET['contact'];
		$connection = new mysqli("localhost","root","tushar1997","ChatApp");
		$result = $connection->query("insert into Contacts values ('$user','$contact')");
		if($result){
			echo "Request Accepted";
		}
		$connection->close();
	}
?>
