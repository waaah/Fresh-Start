function display(element)
{
	var modal_to_trigger = element.getAttribute('modal-to-trigger');
	document.getElementById('overlay').classList.remove('hidden');
	document.getElementById(modal_to_trigger).classList.remove('hidden');
	scrollTo(0,0);
}
function hide(element){
	document.getElementById('overlay').classList.add('hidden');
	element.classList.add('hidden');	
}