// process bar , input size and value (1-100)
/*
Same fuc* API

Class name:		ProcessBar(int width, int height, int value)
Description:	this is a process bar (you don't say)
				width & height is the size of the process bar
				value is the process % (write between 1 - 100)
				**If using style 1 or style 2, width and height should be equal

Method:			setElement(Element element)
return type:	null
Description:	set the element to canvas, or you can use createElement(Element element) to create new element

Method:			createElement(Element element)
return type:	null
Description:	create the new element for drawing, or you can use setElement(Element element) to create new element

Method:			setStyle(int styleID)
return type:	null
Description:	set the drawing style, there have 2 style 
				0 	normal rect style
				1	circle pie style

Method:			setAnimation(boolean bool)
return type:	null
Description:	the process bar will be run (about 0.1s)

Method:			setInnerColor(ColorName str)
return type:	null
Description:	set the inside color

Method:			setOuterColor(ColorName str)
return type:	null
Description:	set the outside boarder color

Method:			setLineWidth(int width)
return type:	null
Description:	set the boarder width

Method:			draw()
return type:	null
Description:	draw the process bar

Method:			afterRandomTimerDraw($time)
return type:	null
Description:	draw the process bar after 0 - 1 second, you don't need to call draw() if you call this method

Method:			startDraw()
return type:	null
Description:	you don;t need to call this, when timer stop will call this method

Method:			stopTimer()
return type:	null
Description:	you don;t need to call this, when timer stop will call this method

----------v1.1 support----------

Method:			getCurrentValue()
return type:	int
Description:	get the current value, very useful in animation

Method:			delegate()
return type:	null
Description:	no method inside, you need to overwrite 
				objectName.delegate = function(){
					// do in here
				}
				it will call this method when draw(), update the process, in animation
				overwrite before draw();
				
----------v1.2 no new method----------
new style for show value
				
Demo area:
	//init
	var processBar = new ProcessBar(200,20,80);
	//set the value again
	processBar.setValue(100);
	//create element
	processBar.createElement();
	//set style
	processBar.setStyle(0);
	//set boarder width
	processBar.setLineWidth(6);
	//set inside color
	processBar.setInnerColor("green");
	//set boarder color
	processBar.setOuterColor("black");
	//set animation
	processBar.setAnimation(true);
	//delegate (display the % in the element "value"
	processBar.delegate = function(){
		var value = this.getCurrentValue();
		var valueLabel =document.getElementById("value");
		valueLabel.innerHTML = value + "%";
	}
	//time before wait little time
	processBar.afterRandomTimeDraw();
	
*/


function ProcessBar(_width,_height,_value){

	var objId=Math.random();

	var width = _width;
	var height = _height;
	var value = _value;
	var style = 0;
	var ctx;
	var self = this;
	var chart;
	var animation = false;
	var timer;
	var innerColor = "green";
	var outerColor = "black";
	var lineWidth = 5;
	var tempValue = 0;
	var labelElement = null;
	
	
	this.setLabelElement = function(e){
		labelElement = e;
	}

	this.setElement = function(element){
		chart = element;
		width = chart.width;
		height = chert.height;
		ctx = chart.getContext("2d");	
	}
	
	this.createElement = function(target){
		chart = document.createElement("canvas");
		chart.width = width;
		chart.height = height;				
		target.appendChild(chart);	
		ctx = chart.getContext("2d");	
	}
	
	this.setStyle = function(styleNum){
		style = styleNum;
		if (style < 0)
			style = 0;
		if (style >= 3)
			style = 0;
	}
	
	this.setAnimation = function(bool){
		animation = bool;
	}
	
	this.setInnerColor = function(str){
		innerColor = str;
	}
	
	this.setOuterColor = function(str){
		outerColor = str;
	}
	
	this.setValue = function(processValue){
		value = processValue;
	}
	
	this.setLineWidth = function(width){
		lineWidth = width;
	}
	
	this.draw = function(){
		if (style == 0){
			//rect style
			if (animation){
				tempValue = 0;
				ctx.strokeStyle = outerColor;
				ctx.beginPath();
				ctx.lineWidth = lineWidth;
				ctx.moveTo(0,0);
				ctx.lineTo(width,0);
				ctx.lineTo(width,height);
				ctx.lineTo(0,height);
				ctx.lineTo(0,0);
				ctx.stroke();
				timer = setInterval(function(){
					ctx.fillStyle=innerColor;
					ctx.fillRect(lineWidth/2,lineWidth/2,(width - (lineWidth/2))* tempValue / 100,height - (lineWidth/2)); 
					tempValue += value/100;
					
					if (tempValue >= value){
						self.stopTimer();
						self.delegate();
					}else{
						self.delegate();
					}
					ctx.strokeStyle = outerColor;
				ctx.beginPath();
				ctx.lineWidth = lineWidth;
				ctx.moveTo(0,0);
				ctx.lineTo(width,0);
				ctx.lineTo(width,height);
				ctx.lineTo(0,height);
				ctx.lineTo(0,0);
				ctx.stroke();
					
					
				} , 20	);
				
			}else{
				tempValue = value;
				self.delegate();
				ctx.fillStyle=innerColor;
				ctx.fillRect(lineWidth/2,lineWidth/2,(width - (lineWidth/2))* value / 100,height - (lineWidth/2)); 
				ctx.strokeStyle = outerColor;
				ctx.beginPath();
				ctx.lineWidth = lineWidth;
				ctx.moveTo(0,0);
				ctx.lineTo(width,0);
				ctx.lineTo(width,height);
				ctx.lineTo(0,height);
				ctx.lineTo(0,0);
				ctx.stroke();
			}
			
		}else if (style == 1){
			if (animation){
				//draw the boarder back			
				ctx.beginPath();
				ctx.lineWidth = lineWidth;
				ctx.strokeStyle = outerColor;
				ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 0, 2* Math.PI);
				ctx.stroke();		
				
				timer = setInterval(function(){
					endAngle = (2/100 * tempValue) -0.5;
					if (endAngle < 0)
						endAngle += 2;
					ctx.beginPath();
					ctx.fillStyle = innerColor;
					ctx.moveTo(width/2,height/2);					
					ctx.lineTo(width/2, lineWidth);
					ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 1.5* Math.PI, endAngle* Math.PI, false);
					ctx.lineTo(width/2,height/2);
					ctx.fill();
					ctx.closePath();
					
					//draw the boarder back			
					ctx.beginPath();
					ctx.lineWidth = lineWidth;
					ctx.strokeStyle = outerColor;
					ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 0, 2* Math.PI);
					ctx.stroke();			
					
					tempValue += value/100;
					if (tempValue >= value){
						self.stopTimer();
						self.delegate();
					}else{
						self.delegate();
					}	
				} , 10	);
			}else{
				//draw inside
				endAngle = (2/100 * value) -0.5;
				if (endAngle < 0)
					endAngle += 2;
				if (value == 100)
					endAngle = 4;
				ctx.beginPath();
				ctx.fillStyle = innerColor;
				ctx.moveTo(width/2,height/2);					
				ctx.lineTo(width/2, lineWidth);
				ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 1.5* Math.PI, endAngle* Math.PI, false);
				ctx.lineTo(width/2,height/2);
				ctx.fill();
				ctx.closePath();

				//draw the boarder back			
				ctx.beginPath();
				ctx.lineWidth = lineWidth;
				ctx.strokeStyle = outerColor;
				ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 0, 2* Math.PI);
				ctx.stroke();			
			}			
		}else if (style == 2){
			if (animation){
				//draw the boarder back			
				ctx.beginPath();
				ctx.lineWidth = lineWidth;
				ctx.strokeStyle = outerColor;
				ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 0, 2* Math.PI);
				ctx.stroke();		
				
				
				timer = setInterval(function(){
				
					//fill full circle
					ctx.beginPath();
					ctx.fillStyle = innerColor;
					ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 0, 2 * Math.PI, false);
					ctx.fill();
					//clear circle using rect
					rectHeight = (100-tempValue) / 100 * height;
					ctx.clearRect(0,0,width,rectHeight);
					//draw the boarder
					ctx.beginPath();
					ctx.lineWidth = lineWidth;
					ctx.strokeStyle = outerColor;
					ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 0, 2* Math.PI);
					ctx.stroke();						
					
					
					tempValue += value/100;
					if (tempValue >= value){
						self.stopTimer();
						self.delegate();
					}else{
						self.delegate();
					}
				} , 10	);
				
			}else{
				//fill full circle
				ctx.beginPath();
				ctx.fillStyle = innerColor;
				ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 0, 2 * Math.PI, false);
				ctx.fill();
				//clear circle using rect
				rectHeight = (100-value) / 100 * height;
				ctx.clearRect(0,0,width,rectHeight);
				//draw the boarder
				ctx.beginPath();
				ctx.lineWidth = lineWidth;
				ctx.strokeStyle = outerColor;
				ctx.arc(width/2, height/2, (width > height)? width/2 - lineWidth : height /2 - lineWidth, 0, 2* Math.PI);
				ctx.stroke();						
			}
		}
	}
	
	this.afterRandomTimeDraw = function(time){
		self.delegate();
		ctx.strokeStyle = outerColor;
		ctx.beginPath();
		ctx.lineWidth = lineWidth;
		if (style == 0){
			ctx.moveTo(0,0);
			ctx.lineTo(width,0);
			ctx.lineTo(width,height);
			ctx.lineTo(0,height);
			ctx.lineTo(0,0);
			ctx.stroke();
		}		
		randomTime = time;
		timer = setInterval(function(){
			if ( -- randomTime <= 0 ){
				self.startDraw();
			}					
		} , 1	);
	}
	
	this.startDraw = function(){
		clearInterval(timer);
		this.draw();
	}
	
	this.stopTimer = function(){
		clearInterval(timer);
		this.setAnimation(false);
		this.draw();
	}
	
	this.getCurrentValue = function(){
	if (tempValue < 10)
		return "0" + (tempValue | 0);
	else
		return (tempValue | 0);
	}
	
	this.getV = function(){
		return tempValue | 0;
	}
	
	this.delegate = function(){
		self.setInnerColor(self.makeColor(self.getV() * 5.11));
		if (labelElement != null)
			labelElement.innerHTML = self.getCurrentValue()+"%";
	}
	
	this.makeColor = function(value) {
		//min: 0(red) max: 511(green)
	    var redValue;
    	var greenValue;
	    if (value < 255) {
    	    redValue = 255;
        	greenValue = Math.sqrt(value) * 16;
	        greenValue = Math.round(greenValue);
    	} else {
        	greenValue = 255;
	        value = value - 255;
    	    redValue = 256 - (value * value / 255)
        	redValue = Math.round(redValue);
	    }
    	var hexColor = "#" + redValue.toString(16) + greenValue.toString(16) + "00";
	    return hexColor;
}
	
	this.clearDraw = function(){
		clearInterval(timer);
		animation = true;
		ctx.clearRect(0,0,width,height);
		tempValue = 0;
		self.delegate();
		
	}
}