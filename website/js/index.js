import Utils from './utils.js';

const parms = new URLSearchParams(window.location.search);

document.getElementById("menu-toggle-btn").addEventListener('click', () => {
	Utils.toggleMenu();
});

document.getElementById('dialog-button-cancel').addEventListener('click', () => {
	Utils.hide('dialog');
});

try{
	if(parms.get('player') !== null){
		document.getElementById("search").value = parms.get('player');
	}

	document.getElementById("search").addEventListener("keypress", (event) => {
		if (event.key !== "Enter" && event.key !== " ") return;
		event.preventDefault();
		let search = document.getElementById("search").value.split(' ')[0];
		if(search.length !== 0) window.location.href = "/?page=" + parms.get('page') + "&player=" + search;
	});
}catch{};