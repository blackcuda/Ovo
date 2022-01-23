function toggleMobileMenu(menu) {
    menu.classList.toggle('open');
}

window.onscroll = function() {
	handleStickyHeader()
};

var header = document.getElementById("pageHeader");
var sticky = header.offsetTop;

function handleStickyHeader()
{
	if (window.pageYOffset > sticky)
	{
		document.getElementById('pageHeader').classList.add("sticky");
	}
	else
	{
		document.getElementById('pageHeader').classList.remove("sticky");
	}
}

function scrollToTargetAdjusted(clickedId) {
	var element;
	var headerOffset = 150;

	switch (clickedId)
	{
		case 'buttonHome':
			element = document.getElementById('home');
			break;
		case 'buttonHomeMob':
			element = document.getElementById('home');
			break;
		case 'buttonOvergang':
			element = document.getElementById('overgang');
			break;
		case 'buttonOvergangMob':
			element = document.getElementById('overgang');
			break;
		case 'buttonWerkwijze':
			element = document.getElementById('werkwijze');
			break;
		case 'buttonWerkwijzeMob':
			element = document.getElementById('werkwijze');
			break;
		case 'buttonTarievenSectie':
			element = document.getElementById('tarievensectie');
			break;
		case 'buttonTarievenSectieMob':
			element = document.getElementById('tarievensectie');
			break;
		case 'buttonOverMij':
			element = document.getElementById('over_mij');
			break;
		case 'buttonOverMijMob':
			element = document.getElementById('over_mij');
			break;
		case 'buttonContact':
			element = document.getElementById('contact');
			break;
		case 'buttonContactMob':
			element = document.getElementById('contact');
			break;
		default:
			element = document.getElementById('home');
	}

	var elementPosition = element.getBoundingClientRect().top;
	var offsetPosition = elementPosition + window.pageYOffset - headerOffset;


	window.scrollTo({
		top: offsetPosition, 
		behavior: 'smooth'
	});
}