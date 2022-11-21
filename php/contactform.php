<?php

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

abstract class errorCodeEnum
{
	const ERRORNO = 0;
	const ERRORNAME = 1;
	const ERROREMAIL = 2;
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$logFileName = './../logs/OogVoorOvergangLog_'.date("Y.n").'.log';

try
{
	if(isset($_POST['submit'])) 
	{
		$name = htmlspecialchars(stripslashes(trim($_POST['name'])));
		$mailFrom = htmlspecialchars(stripslashes(trim($_POST['email'])));
		$message = htmlspecialchars(stripslashes(trim($_POST['message'])));
	
		$log = "[".date("Y.n.j, G:i:s")."] Submit Contact Form - Name: ".$name.", Email: ".$mailFrom.PHP_EOL;
		file_put_contents($logFileName, $log, FILE_APPEND);
	
		//Server settings
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'mail.mijndomein.nl';                   //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'esther.geel@oogvoorovergang.nl';       //SMTP username
		$mail->Password   = '!Info914615#';                         //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
		$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	
		//Recipients
		$mail->setFrom('esther.geel@oogvoorovergang.nl', 'Esther Geel');
		$mail->addAddress('info@oogvoorovergang.nl', 'Info_OogVoorOvergang');     //Add a recipient
		$mail->addReplyTo('info@oogvoorovergang.nl', 'Information');
		
		
		$txt = "
			<html>
			<body>
			<p><b>Contactformulier Oog Voor Overgang</b> <br><br> 
			Naam: ".$name." (".$mailFrom.")<br><br>"
			.$message.
			"</p>
			</body>
			</html>
			";
		
		$txt = wordwrap($txt,70);
		
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Contactformulier - Oog voor overgang';
		$mail->Body    = $txt;
		$mail->AltBody = $txt;
		
		$errorCode = errorCodeEnum::ERRORNO;
		
		if(!preg_match("/^[A-Za-z .'-]+$/", $name))
		{
		  $errorCode = errorCodeEnum::ERRORNAME;
		  echo "<script type='text/javascript'>alert('$nameErrorMessage');</script>";
		}
		
		if(!filter_var($mailFrom, FILTER_VALIDATE_EMAIL))
		{
		  $errorCode = errorCodeEnum::ERROREMAIL;
		  echo "<script type='text/javascript'>alert('$emailErrorMessage');</script>";
		}
		
		if ($errorCode == errorCodeEnum::ERRORNO)
		{
			$mail->send();
					
			$log = "[".date("Y.n.j, G:i:s")."] Email was sent successfully.".PHP_EOL;
			file_put_contents($logFileName, $log, FILE_APPEND);
			
			header("Location: ../index.html?contactform=correct");
		}
		else
		{
			$log = "[".date("Y.n.j, G:i:s")."] Error Occurred - Code: ".$errorCode.PHP_EOL;
			file_put_contents($logFileName, $log, FILE_APPEND);
			header("Location: ../index.html?contactform=errorOccurred");
		}
	}
	else
	{
		header("Location: ../contactform.html?contactform=errorSubmitNotSet");
	}
} catch (Exception $e)
{
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>