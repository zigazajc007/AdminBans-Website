export default class Utils{

	static toggleMenu(){
		if(document.getElementById("mobile-menu").className == 'hidden pt-2 pb-3 space-y-1'){
			document.getElementById("mobile-menu").className = 'pt-2 pb-3 space-y-1';
		}else{
			document.getElementById("mobile-menu").className = 'hidden pt-2 pb-3 space-y-1';
		}
	}

	static hide(element){
		document.getElementById(element).style.display = 'none';
	}

	static show(element, method = 'flex'){
		document.getElementById(element).style.display = method;
	}

}