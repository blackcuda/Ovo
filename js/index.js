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