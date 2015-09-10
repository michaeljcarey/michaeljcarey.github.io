<?php
	$s = $_GET["state"];
	//echo "here" .$s;
	
	switch ($s) {
		case "0":
			echo "open clock server program";
			break;
			
		case "1" :
			$host = "localhost";//"192.168.1.131"; //gethostbyname("www.example.com");
			$port = 444;

			if(!($clientSck = socket_create(AF_INET, SOCK_STREAM, 0)) ) { // no apparent error
				$errorcode = socket_last_error();
				$errormsg = socket_strerror($errorcode);
				die("Could not create socket: [$errorcode] $errormsg \n");
			}
			//echo "created";

			if (!($result = socket_connect($clientSck, $host, $port)) ) {
				echo "socket_connect() failed, reason: ".socket_strerror(socket_last_error())." \n";
				die("Could not connnect to server\n");
			}
			//echo "connected";
		
			$msg = ":1" . chr(10);
			$len = strlen($msg);
			while (true) {
				$sent = socket_write($clientSck, $msg, $len);
				if ($sent === false) {
					break;
				}
				
				if ($sent < $len) {			// check until entire message is sent
					$msg = substr($msg, $sent);	// continue getting the message
					$len -= $sent;
				} else {
					break;
				}
			}
			//echo "written";

			$rdVal = "";
			$rdVal = socket_read($clientSck, 25, PHP_NORMAL_READ);

			echo "Output: " . $rdVal;
			socket_shutdown($clientSck, 2);		// housekeeping
			socket_close($clientSck);
			break;
			
		case "2" :
			echo "You can service other commands in this switch statement";
			break;
			
		default:
			echo $s;
			break;
	}
?>
