


<!-- Assignment : lab4.php -->
<html>
	<head>
		<meta charset=“UTF-8”>
		<title>Assignment Lab 4 Sunny Desai</title>
		<style type="text/css">

			.register {
				float:left;

				margin:5mm;
				border:solid;
			}
			label {
					color: #191970;
					font-weight: bold;
					display: block;
					margin: 1mm;
					margin-right: 2mm;
			}

			h1 {
				margin:1mm;
			}
			#reg_submit{
				margin-left:15mm;
				font-size:18px;
			}

			#submit{
				margin-left:15mm;
				font-size:18px;
			}

			#email,#message{
				margin-left:5mm;
				font-size:18px;
			}

			#sub{
				margin-top:5mm;
				margin-left:20mm;
				font-size:18px;

			}

			#l_msg, #l_email, #l_time{

			text-align: left;
			}
		</style>
	</head>
<body>
<?php
// Start the session
session_start();
?>

	<?php
					$reg=0;
					$login=$_POST["login"];
					$usr="root";
					$pword="mysql";
					$server="localhost";
					$dbname="login";

					// Create connection
					$conn = new mysqli($server, $usr, $pword, $dbname);
					// Check connection
					if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
					}

					//receiving details from post method
					$userid = $email=$message=$timestamp=$status = "";
					$reg=$_POST["reg"];
					$email=$_POST["email"];
					$message=$_POST["message"];
					$data=$_SESSION["username"];
					$day=$_POST["day"];
					$time=$_POST["time"];
					$id_query="select userid from user where username='$data'";

					if((isset($_POST["email"]) && $_POST["email"] == "") || (isset($_POST["message"])
					&& $_POST["message"] == "") || (isset($_POST["day"]) && $_POST["day"] == "") || (isset($_POST["time"]) && $_POST["time"] == "")){
						print("Enter details in all the fields");
						$reg=0;
					}

					//email validation
					if(!preg_match("/^\S{1,}@\S{1,}[.]\S{1,}$/",$email) && isset($_POST["email"])){

							print("<p>Please enter valid email address.</p>");
							//header('Location: message.php');
							$reg=0;
					}

						//checking whether the fields are filled with information.
						if($reg==1 && isset($_POST["email"]) && $_POST["email"] != "" && isset($_POST["message"])
						&& $_POST["message"] != "" && isset($_POST["day"]) && $_POST["day"] != "" && isset($_POST["time"]) && $_POST["time"] != "" ){

							$result = $conn->query($id_query);
								if ($result->num_rows > 0) {
										while($row = $result->fetch_assoc()) {
											$userid=$row["userid"];
										}
								} 	else {
									echo "No one found";
								}

							//	echo $day;
							//	echo $time;
							//concat date and time
								$timestamp= $day . " " . $time . ":00";
							//	echo $timestamp;
							//query for inserting values
							$query="INSERT INTO message (userid,email,message,timestamp) VALUES ('$userid','$email','$message','$timestamp')";

							if ($conn->query($query) === TRUE) {
    							echo "New message added to the list successfully";
							} else {
    							echo "Error: " . $query . "<br>" . $conn->error;
								}

						}

	?>

	<div class="register" >
			<h1>Set details and Type your message in the text field.</h1><br>

			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<label id="l_email">Email Address:<input type="text" id="email" name="email" placeholder="Email Address"><span id="reg_errorUname"></span></label><br>
				<label id="l_msg">Message:<textarea name="message" id="message" ROWS="5" COLS="20"></textarea><span id="reg_errorUname"></span></label><br>
				<label id ="l_time">Timestamp:
								 <input type="date" name="day">
								 <input type="time" name="time"></label>
				<input type="hidden" name="reg" value="1">
				<input type="submit" id="sub" name="submit" value="Submit" >
			</form>
	</div>

</body>
</html>
