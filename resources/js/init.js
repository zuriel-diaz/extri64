var option = '';
$(document).ready(init);

function init(){
	$(":radio").click(function(){
		option = $("input:checked").val();
		if (option != 'none'){ showNextStep(); }
		else { hideElement("step_2"); }
	});
}

function showNextStep(){ showElement("step_2"); showMessage(); showOption(); }

function showMessage(){
	switch(option)
	{
		case 'none':
			setMessage('none');
			break;
		case 'text':
			setMessage('input the string');
			break;
		case 'image':
			setMessage('select your image');
			break;
		case 'ringtone':
			setMessage('select your ringtone');
			break;
		default:
			setMessage('not available');
	}
}

function showOption(){
	switch(option)
	{
		case 'none':
			hideElement('ringtone'); hideElement('string'); hideElement('image');
			break;
		case 'text':
			showElement('string'); hideElement('image'); hideElement('ringtone');
			break;
		case 'image':
			showElement('image'); hideElement('string'); hideElement('ringtone');
			break;
		case 'ringtone':
			showElement('ringtone'); hideElement('string'); hideElement('image');
			break;
		case 'default':
			hideElement('ringtone'); hideElement('string'); hideElement('image');
			break;
	}
}

function setMessage(value){ $(".message").text("");$(".message").text(value); }

function showElement(name){ $("#"+name).css("display","block"); }
function hideElement(name){ $("#"+name).css("display","none"); }
