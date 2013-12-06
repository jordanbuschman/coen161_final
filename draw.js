var canvas;
var ctx;
var drawBool = false;

var canvasWidth;
var canvasHeight;

// Vectoring
var prevX = 0;
var prevY = 0;
var nextX = 0;
var nextY = 0;

var color = "black"; 
var radius = 3;

function initializeCanvas() {
    canvas = document.getElementById('can');
    ctx = canvas.getContext("2d");
    canvasWidth = canvas.width;
    canvasHeight = canvas.height;
	fillWhite();

	// Listener for moving mouse
    canvas.addEventListener("mousemove", function (e) {
        if (drawBool) {
            setMouseVectors(e);
        	//Draw Vector
            ctx.beginPath();
    		ctx.moveTo(prevX, prevY);
    		ctx.lineTo(nextX, nextY);
    		ctx.lineWidth = radius;
    		ctx.strokeStyle = color;
   	 		ctx.stroke();
    		ctx.closePath();
        }
    }, false);
    
    // Listener for mouse click down
    canvas.addEventListener("mousedown", function (e) {
        drawBool = true;
        setMouseVectors(e);
    }, false);
    
    // Listener for mouse click up
    canvas.addEventListener("mouseup", function (e) {
        drawBool = false;
    }, false);    
}

function fillWhite(){
	ctx.beginPath();
	ctx.moveTo(0, 0);
    ctx.lineTo(0, canvasHeight);
    ctx.lineTo(canvasWidth, canvasHeight);
    ctx.lineTo(canvasWidth, 0);
	ctx.lineTo(0, 0);
    ctx.lineWidth = 1;
    ctx.strokeStyle = "white";
    ctx.stroke();
    ctx.fillStyle = "white";
    ctx.fill();
	ctx.closePath();
}

//Set new xy vector based on mouse movement
function setMouseVectors(e){
	prevX = nextX;
    prevY = nextY;
	if (e.pageX || e.pageY) { 
  		nextX = e.pageX;
  		nextY = e.pageY;
	} else { 
  		nextX = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft; 
  		nextY = e.clientY + document.body.scrollTop + document.documentElement.scrollTop; 
    }
    nextX -= canvas.offsetLeft;
    nextY -= canvas.offsetTop;
}


function clearCanvas() {
    if ( confirm("Are you sure you want to clear your drawing?") ) {
        ctx.clearRect(0, 0, canvasWidth, canvasHeight);
        fillWhite();
        document.getElementById("canvasimg").style.display = "none";
    }
}

function save() {
    window.location = canvas.toDataURL();
}