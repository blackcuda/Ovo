
const ContacFormErrorCodeEnum = {
	noError: '0',
	nameError: '1',
	emailError: '2'
}

Object.freeze(ContacFormErrorCodeEnum)

function validateForm() 
{
	let contactMail = document.getElementById("mail").value;
	let contactName = document.getElementById("name").value;
	let contactMessage = document.getElementById("message").value;
	
	document.getElementById('name').style.borderColor = "black";	
	document.getElementById('mail').style.borderColor = "black";
	document.getElementById('nameErrorLabel').textContent = "";
	document.getElementById('mailErrorLabel').textContent = "";
	
	let nameCorrect = validateName(contactName);
	let emailCorrect = validateEmail(contactMail);
	
	if (false == nameCorrect)
	{
      document.getElementById('name').style.borderColor = "red";		
	}
	
	if (false == emailCorrect)
	{
	  document.getElementById('mail').style.borderColor = "red";
	}
	
	return nameCorrect && emailCorrect;
}

function validateEmail(email) 
{
	var returnValue = true;
	var re = /\S+@\S+\.\S+/;
	
	if ("" == email)
	{
	  returnValue = false;
	  document.getElementById('mailErrorLabel').textContent = "Voer hier uw e-mailadres in.";
	  document.getElementById('mailErrorLabel').style.color  = "red";
	}
	else if (!re.test(email))
	{
	  returnValue = false;
	  document.getElementById('mailErrorLabel').textContent = "Vul een geldig e-mailadres in.";
	  document.getElementById('mailErrorLabel').style.color  = "red";
	}

	return returnValue;
}

function validateName(name)
{
	var nameCorrect = true;
		
	if ("" == name)
	{
	  // Please enter your name.
	  nameCorrect = false;   	
	  document.getElementById('nameErrorLabel').textContent = "Voer hier uw naam in.";
	  document.getElementById('nameErrorLabel').style.color  = "red";
	}
	else if (false == (/^[A-Za-z .'-]+$/.test(name)))
	{
	  // Your name must contain only alphabetic characters
	  nameCorrect = false;
	  document.getElementById('nameErrorLabel').textContent = "Uw naam mag alleen bestaan uit letters.";
	  document.getElementById('nameErrorLabel').style.color  = "red";
	}
	
	return nameCorrect;
}

	
function contactServerReturn(errorCode) 
{ 


	
	var errorMessage = '';
	let nameErrorMessage = 'Server: Ongeldige naam';
	let emailErrorMessage = 'Server: Ongeldig e-mailadres';
	
	switch (errorCode)
	{
		case nameError:
		errorMessage = nameErrorMessage;
		break;
		case emailError:
		errorMessage = emailErrorMessage;
		break;
		default:
		break;
	}
	
	if (errorCode != noError)
	{
		alert(errorMessage);
	}
}