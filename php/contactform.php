<?php

abstract class errorCodeEnum
{
	const ERRORNO = 0;
	const ERRORNAME = 1;
	const ERROREMAIL = 2;
}

$logFileName = './../logs/OogVoorOvergangLog_'.date("Y.n").'.log';

if(isset($_POST['submit'])) 
{
	$name = htmlspecialchars(stripslashes(trim($_POST['name'])));
	$mailFrom = htmlspecialchars(stripslashes(trim($_POST['email'])));
	$message = htmlspecialchars(stripslashes(trim($_POST['message'])));
	
	$log = "[".date("Y.n.j, G:i:s")."] Submit Contact Form - Name: ".$name.", Email: ".$mailFrom.PHP_EOL;
	file_put_contents($logFileName, $log, FILE_APPEND);
	
	$mailTo = "info@oogvoorovergang.nl";
	$subject = "Contactformulier - Oog voor overgang";
	$headers = "From: ".$mailFrom;
	$txt = "You have received an e-mail from ".$name." ".$mailFrom.".\n\n".$message;

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
		if (mail($mailTo, $subject, $txt, $headers))
		{
			$log = "[".date("Y.n.j, G:i:s")."] Email was sent successfully.".PHP_EOL;
			file_put_contents($logFileName, $log, FILE_APPEND);
		}
		else
		{
			$log = "[".date("Y.n.j, G:i:s")."] Email was not sent. Mail error Occurred.".PHP_EOL;
			file_put_contents($logFileName, $log, FILE_APPEND);	
		}
		
		header("Location: ../index.html?contactform=correct");
	}
	else
	{
		$log = "[".date("Y.n.j, G:i:s")."] Error Occurred - Code: ".$errorCode.PHP_EOL;
		file_put_contents($logFileName, $log, FILE_APPEND);
    	header("Location: ../index.html?contactform=errorOccurred");
	}
	
	/*
	echo '<script type="text/javascript">
		contactServerReturn($errorCode);
	</script>';
	*/
	

	
	/*
	if (empty($name)|| empty($mailFrom) || empty($message))
	{
		header("Location: ../index.html?contactform=empty");
	}
	else
	{
		if (!filter_var($mailFrom, FILTER_VALIDATE_EMAIL))
		{
			header("Location: ../index.html?contactform=invalidemail");
		}
		else
		{
			mail($mailTo, $subject, $txt, $headers);
			header("Location: ../index.html?contactform=correct");
		}	
	}
	*/
}
else
{
	header("Location: ../contactform.html?contactform=errorSubmitNotSet");
}

?>