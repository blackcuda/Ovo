var checkBox = document.getElementById("menyAvPaa");

var navLinks = document.querySelectorAll(".navLink");

for (var i = 0; i < navLinks.length; i++) {
	var navLink = navLinks[i];
	navLink.onclick = function() {
		checkBox.checked = false;
	}
}

