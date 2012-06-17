var canvas;
var context;
var cities = [];
var paths = [];
var holons = [];
var simTimes;
var simTimeNum = 0;
var radius = 6;
var holonColor = '#0000ff';
var pathColor = '#00ff00';

// parsing xml in order to draw holons locations
jQuery.fn.parseXml = function(){
	$.ajax({
		type: "GET",
		url: "./lc101.xls.xml",
		dataType: "xml",
		success: function(xml) {
			if(typeof simTimes == "undefined" || simTimes.length == 0)
				simTimes = $(xml).find('simmulation simTime');
			simTimeNum = simTimeNum % simTimes.length;
			$(simTimes[simTimeNum]).find('holons holon').each(function(index) {
				var x = parseFloat($(this).attr('locationX')) * (canvas.width / 100);
				var y = parseFloat($(this).attr('locationY')) * (canvas.height / 100);
				var id = $(this).attr('id');
				if(typeof holons[id] == 'undefined') {
					holons[id] = new Node(x, y, radius, holonColor, id);
					paths[id] = new Path(x, y, pathColor);
				} else {
					holons[id].moveTo(x, y);
					paths[id].add(x, y);
				}
			});
			// redraw holons positions
			drawGraph();
		}
	});
};

function Path(x, y, color) {
	this.color = color;
	this.path = [[x, y]];
	
	this.draw = function() {
		context.beginPath();
		var path = this.path;
		context.moveTo(path[0][0], path[0][1]);
		var pathLength = path.length;
		for(var i = 0; i < pathLength; ++i)
			context.lineTo(path[i][0], path[i][1]);
		context.strokeStyle = this.color;
		context.stroke();
		context.closePath();		
	}
	
	this.add = function(x, y) {
		this.path.push([x, y]);
	}
}

function Node(x, y, radius, color, text, connectNodeIndex) {
	this.color = color;
	this.radius = radius;
	this.x = x;
	this.y = y;
	this.text = text;
	this.connectNodeIndex = connectNodeIndex;	// used to draw map
	
	this.draw = function() {
		context.fillStyle = color;
		context.beginPath();
		context.arc(this.x, this.y, this.radius, 0, 2 * Math.PI, false);
		context.closePath();
		context.fill();
		if(typeof(text) !== 'undefined') {
			context.font = "10pt arial";
			context.fillStyle = "#000000";
			context.textAlign = "center";
			context.textBaseline = "middle";
			context.fillText(text, this.x, this.y + 1.5 * radius);
		}
	}
	
	this.moveTo = function(x, y) {
		this.x = x;
		this.y = y;
	}
	
	this.connectWith = function(node, color) {
		context.beginPath();
		context.moveTo(this.x, this.y);
		context.lineTo(node.x, node.y);
		context.strokeStyle = color;
		context.stroke();
		context.closePath();
	}
}

var drawMap = function() {
	canvas = document.getElementById("myCanvas");
	context = canvas.getContext("2d");
		
	for(var i = 0; i < cities.length; ++i)
		cities[i].connectWith(cities[cities[i].connectNodeIndex], '#EFEFEF');
	
	for(var city in cities)
		cities[city].draw();
		
	for(var path in paths)
		paths[path].draw();
}

var drawGraph = function () {
	for(holon in holons)
		holons[holon].draw();
}

var init = function(filepath) {	
	$.getJSON(filepath,function(data){
		var radius = 3;
		$.each(data, function(index){
			this.x *= (canvas.width) / 100;
			this.y *= (canvas.height) / 100;
			color = this.from > 0 ? '#ff0000' : '#929292';
			var connectNodeIndex = this.from > 0 ? this.from : this.to;
			cities.push(new Node(this.x, this.y, radius, color, index, connectNodeIndex));
		});
	});
}

var nextSimTime = function() {
	canvas = document.getElementById("myCanvas");
	context = canvas.getContext("2d");
	context.clearRect (0 , 0 , canvas.width , canvas.height);
	++simTimeNum;		// global variable
	drawMap();
	jQuery(document).parseXml();
}

$().ready(function(){ 
	init("./js/map.js");
	drawMap();
	jQuery(document).parseXml();
	
	setInterval("nextSimTime()", 14);
});
