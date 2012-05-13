function addMessage(containerElement, message){
	if(message) {
		containerElement.removeClass();
		containerElement.addClass("error");
		containerElement.next('.message').html(message);
	} else {
		containerElement.removeClass();
		containerElement.addClass("success");
		containerElement.next('.message').html('');
	}
}

function validateTaskName(input){	
	if(input.val().length < 1){
		addMessage(input.parent(), 'Wprowadź nazwę zadania');
		return false;
	}
	addMessage(input.parent(), null);
	return true;
}

function validateFile(input, extensions) {
	if(input.val().length < 1){
		addMessage(input.parent(), 'Wybierz plik');
		return false;
	} 
	
	if(extensions.indexOf(input.val().split('.').pop()) < 0) {
		text = extensions.join(', ');
		addMessage(input.parent(), "Tylko pliki: <code>" + text + "</code>");
		return false;
	}
	
	addMessage(input.parent(), null);
	return true;
}

function confirmDelete() {
	return confirm('Na pewno chcesz usunąć? (operacja nieodwracalna!)');
}

jQuery(document).ready(function(){	
	// add task validation
	$("#addTask #task").blur(function(){
		validateTaskName($(this));
	});
	
	var properties = ['txt', 'properties'];
	
	$("#addTask #trucks").blur(function(){
		validateFile($(this), properties);
	});
	
	$("#addTask #trailers").blur(function(){
		validateFile($(this), properties);
	});
	
	$("#addTask #drivers").blur(function(){
		validateFile($(this), properties);
	});
	
	$("#addTask #holons").blur(function(){
		validateFile($(this), properties);
	});
	
	$("#addTask #configuration").blur(function(){
		validateFile($(this), ['xml']);
	});
	
	$("#addTask").submit(function(){
		var res = validateTaskName($("#addTask #task"));
		res = validateFile($("#addTask #trucks"), properties) && res;
		res = validateFile($("#addTask #trailers"), properties) && res;
		res = validateFile($("#addTask #drivers"), properties) && res;
		res = validateFile($("#addTask #holons"), properties) && res;
		res = validateFile($("#addTask #configuration"), ['xml']) && res;
		return res;
	});
	
	
	// flash message
	$('.flash').click(function ( event ) {
		event.preventDefault();
		$(this).hide();
	});
});
