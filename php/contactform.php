<?php

	
abstract class errorCodeEnum
{
	const ERRORNO = 0;
	const ERRORNAME = 1;
	const ERROREMAIL = 2;
}

if(isset($_POST['submit'])) 
{
	$name = htmlspecialchars(stripslashes(trim($_POST['name'])));
	$mailFrom = htmlspecialchars(stripslashes(trim($_POST['mail'])));
	$message = htmlspecialchars(stripslashes(trim($_POST['message'])));
	
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
		mail($mailTo, $subject, $txt, $headers);
		header("Location: ../index.html?contactform=correct");
	}
	else
	{
		header("Location: ../index.html?contactform=error");
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
	header("Location: ../contactform.html?contactform=error");
}