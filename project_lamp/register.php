


<!-- Assignment : lab4.php - Registration Page-->
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
	$reg_username = $reg_password = "";
	$reg=$_POST["reg"];
	$reg_username = $_POST["reg_uname"];
	$reg_password = $_POST["reg_pass"];

	if((isset($_POST["reg_uname"]) && $_POST["reg_uname"] == "") || (isset($_POST["reg_pass"])
	&& $_POST["reg_pass"] == "")){
			print("<p>Enter details in all the fields</p>");
			$reg=0;
		}


		//new - /^(?=.*[\p{Ll}])(?=.*[\p{Lu}])(?=.*\d)(?=.*[.?~!@#$%^&*])[\p{L}\d\.?~!@#$%^&*]{8,}/ - From https://regex101.com

	 // -- /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=.\-_*])([a-zA-Z0-9@#$%^&+=*.\-_]){3,}$/ for JavaScript
	 //server side password check
	 if(!preg_match("/^(?=.*[\p{Ll}])(?=.*[\p{Lu}])(?=.*\d)(?=.*[.?~!@#$%^&*])[\p{L}\d\.?~!@#$%^&*]{8,}/",$reg_password) && isset($_POST["reg_pass"])){
			print("<p>The password didn't satisfied minimum requirements. Please Enter 1 upper (any unicode), 1 lower, 1 number, one symbol, 8 chars minimum.
			</p>");
			$reg=0;
		//header('Location: message.php');
	}

//whether user exists
	if($reg==1 && isset($_POST["reg_uname"]) && $_POST["reg_uname"] != ""){

		//Username Check - if username exists
			$query_uname="SELECT * FROM user WHERE username= '$reg_username'";
			$result_uname = $conn->query($query_uname);
				if ($result_uname->num_rows > 0) {
					print("Username Exists");
					$reg=0;
				}
		}

		//inserting in the table
	if($reg==1 && isset($_POST["reg_uname"]) && $_POST["reg_uname"] != "" && isset($_POST["reg_pass"])
	&& $_POST["reg_pass"] != ""){

		$reg_password=password_hash("".$reg_password, PASSWORD_DEFAULT);
		//query
		$query="INSERT INTO user (username, password) VALUES". "('$reg_username','$reg_password')";

			if ($conn->query($query) === TRUE) {
				echo "You are successfully registered with '$reg_username'";
			} else {
				echo "Error: " . $query . "<br>" . $conn->error;
			}
		}
	?>

	<div class="register" >
			<h1>Register Here</h1><br>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<label>Username:<input type="text" id="reg_username" name="reg_uname" placeholder="username"><span id="reg_errorUname"></span></label><br>
					<label>Password:<input type="password" id="reg_password" name="reg_pass" placeholder="password"><span id="reg_errorPass"></span> </label> <br>
					<input type="hidden" name="reg" value="1">
					<input type="submit" id="reg_submit" name="reg_submit" value="Register" >
			</form>

			<form action="login.php">
				<p><input type="submit" id="but_l" value="I want to Login"></p>
			</form>
	</div>

</body>
</html>
