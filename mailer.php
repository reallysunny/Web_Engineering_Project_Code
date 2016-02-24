<?php
date_default_timezone_set('America/Los_Angeles');

//reference from http://stackoverflow.com/questions/712392/send-email-using-the-gmail-smtp-server-from-a-php-page
// Swift Mailer Library
require_once '/Users/reallysunny/swiftmailer/lib/swift_required.php';

//Connect to MySQL
		if(!($database = mysql_connect("localhost","root","mysql")))
			die("Could not connect to database");

//open the database
		if(!mysql_select_db("login",$database))
			die("Could not open books database");



$query="SELECT msgid,email, message from message WHERE timestamp <= NOW() AND sent = 0";

//execute the query
		if(!($result = mysql_query($query,$database))){
			print("Could not execute query\n");
			die(mysql_error());
		}
		else{
			print($result . "\n");
		}


//fetch each record in resultset
		while($row = mysql_fetch_row($result)){
		$count=0;
		$cnt=0;
			//build table to display results
			foreach($row as $key => $value){
				if($key==0){
					$msgid=$value;
					print("msgid is " . $msgid . "   \n");
				}
				else if($key==1){
					$email=$value;
					print("email is " . $email . "   \n");
				}
				else if($key==2){
					$msg=$value;
					print("message is " . $msg . "   \n");
				}
				//counter
				print("Cnt is:" . $cnt . "   \n");
				$cnt++;
			}
			$count++;
			print("Count is:" . $count . "   \n");

			// Mail Transport
			$transport = Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
    			->setUsername('sddesai003@gmail.com') // Your Gmail Username
   				 ->setPassword('#######'); // Your Gmail Password

			// Mailer
				$mailer = Swift_Mailer::newInstance($transport);

			// Create a message
				$message = Swift_Message::newInstance('Message from Sunny Desai')
    					->setFrom(array('sddesai003@gmail.com.com' => 'SUNNY DESAI')) // can be $_POST['email'] etc...
    					->setTo(array($email => 'DESAI SUNNY')) // your email / multiple supported.
    					->setBody($msg,'text/html');

			// Send the message
				if ($mailer->send($message)) {
    				echo 'Mail sent successfully.';
    				$update_query="UPDATE message SET sent=1 WHERE msgid='$msgid'";

    				if(!($result_update = mysql_query($update_query,$database))){
						print("Could not execute query\n");
						die(mysql_error());
					}
				} else {
   					echo 'I am sure, your configuration are not correct. :(';
				}

			}

?>
