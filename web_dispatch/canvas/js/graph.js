function Node(context, x, y, radius, color, text) {
	this.color = color;
	this.radius = radius;
	this.x = x;
	this.y = y;
	this.text = text;
	this.context = context;
	
	this.draw = function() {
		context.fillStyle = color;
		context.beginPath();
		context.arc(x, y, radius, 0, 2 * Math.PI, false);
		context.closePath();
		context.fill();
		if(typeof(text) !== 'undefined') {
			context.font = "10pt arial";
			context.fillStyle = "#000000";
			context.textAlign = "center";
			context.textBaseline = "middle";
			context.fillText(text, x, y + 1.5 * radius);
		}
	}
	
	this.moveTo = function(x, y) {
		this.x = x;
		this.y = y;
	}
	
	this.connectWith = function(node, color) {
		context.beginPath();
		context.moveTo(x, y);
		context.lineTo(node.x, node.y);
		context.strokeStyle = color;
		context.stroke();
		context.closePath();
	}
}


var canvas;
var context;
var cities = [];
	
jQuery.fn.parseXml = function(){
	var radius = 6;
	var color = '#0000ff';
	$.ajax({
		type: "GET",
		url: "./lc101.xls.xml",
		dataType: "xml",
		success: function(xml) {
			$(xml).find('simmulation simTime').first().each(function() {
				$(this).find('holons holon').each(function(index) {
					var x = parseFloat($(this).attr('locationX')) * (canvas.width / 100);
					var y = parseFloat($(this).attr('locationY')) * (canvas.height / 100);
					var id = $(this).attr('id');
					cities.push(new Node(context, x + 10, y + 10, radius, color, id));
				});
				
			});
		}
	});
};

$().ready(function(){ 
	canvas = document.getElementById("myCanvas");
	context = canvas.getContext("2d");	


	$.getJSON('js/map.js',function(data){
		var radius = 3;
		var color = '#ff0000';
		var currentLength = cities.length;
		$.each(data, function(index){
			this.x *= (canvas.width) / 100;
			this.y *= (canvas.height) / 100;
			cities.push(new Node(context, this.x + 10, this.y + 10, radius, color, index));
		});
		
		for(var i = currentLength; i < cities.length; ++i)
			cities[i].connectWith(cities[0], '#EFEFEF');
		
		for(city in cities)
			cities[city].draw();
	});



    
});
