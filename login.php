<!-- Assignment : lab4  - Login page -->
<html>
	<head>
		<meta charset=“UTF-8”>
		<title>Assignment Lab 4 Sunny Desai</title>
		<style type="text/css">
			.login {
				margin:5mm;
				float:left;
				width:40%;
				border:solid;
			}
			.register {
				float:left;
				width:40%;
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

			#username,#reg_username,#password,#reg_password{
				margin-left:5mm;
				font-size:18px;
			}

			#but_l, #but_r{

				margin-left:15mm;
				font-size:18px;

			}
		</style>
	</head>
<body>

<?php
// Start the session
session_start();
?>
	<?php
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

		$username = $password = "";

		if((isset($_POST["uname"])
			&& $_POST["uname"] == "")
			|| (isset($_POST["pass"])
			&& $_POST["pass"] == "")){
				print("<p>Enter details in all the fields</p>");
				$login=0;

			}
	if ($login==1 && isset($_POST["uname"])
		&& $_POST["uname"] != ""
		&& isset($_POST["pass"])
		&& $_POST["pass"] != "")
	{
		$username = $_POST["uname"];
		$password = $_POST["pass"];
		//query for getting the password matching the username
		$query="SELECT password FROM user WHERE username= '$username'";
		$result = $conn->query($query);

				if ($result->num_rows > 0) {
						// output data of each row
							while($row = $result->fetch_assoc()) {
									$pass_hash=$row["password"];
				}
				}	else {
						echo "No user with this username exists";
				}
				//password Verfication
				if (password_verify($password, $pass_hash)) {
						$_SESSION["username"] = $username;//saving the username to session id
						header('Location: lab4.php'); // diverting to messages page
				} else {
    			echo 'Invalid Username/password.';
				}
	}

					?>

	<div class="login">
		<h1>Login Here</h1><br>
		<form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<label>Username:<input type="text" id="username" name="uname" placeholder="username"><span id="errorUname"></span></label><br>
			<label>Password:<input type="password" id="password" name="pass" placeholder="password"><span id="errorPass"></span></label><br>
			<input type="hidden" name="login" value="1">
			<input type="submit" id="submit" name="submit" value="Log In" >
		</form>
		<!-- Buuton to go for registration -->
		<form action="register.php">
				<p><input type="submit" id="but_r" value="I want to Register"></p>
			</form>
	</div>




</script>
</body>
</html>
