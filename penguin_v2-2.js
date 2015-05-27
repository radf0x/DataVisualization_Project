/*
PenguinJS v2.2
Copyright by David K.H.FUNG
Developed by David K.H.FUNG
*/



var penguinbox_data={defaultZIndex:10000,boxesArray:[]};

function PenguinBox(_target){

var self=this;
var lightWhenSelected=false;
var bgcRGBA={r:0,g:0,b:0,a:1};
var onHideListener=null;
var onShowListener=null;
var box=document.createElement('div');
box.style.zIndex=penguinbox_data.defaultZIndex+penguinbox_data.boxesArray.length;
box.style.position='absolute';
box.style.width=60+'%';
box.style.height=65+'%';
box.style.top=((100/2)-(parseInt(box.style.height)/2))+'%';
box.style.left=((100/2)-(parseInt(box.style.width)/2))+'%';
box.onmousedown=function(){
self.setZIndex();
}
setBackgroundColorWithRGBA(255,255,255,0.3);
var topBar=document.createElement('div');
topBar.style.position='absolute';
topBar.style.width=100+'%';
topBar.style.height=5+'%';
topBar.style.top=0+'%';
topBar.style.left=0+'%';
topBar.style.textAlign='center';
var closeBtn=document.createElement('div');
closeBtn.style.position='absolute';
closeBtn.style.width='8%';
closeBtn.style.left=((100/2)-(parseInt(closeBtn.style.width)/2))+'%';
closeBtn.style.color='black';
closeBtn.style.cursor='pointer';
closeBtn.setAttribute('onselectstart','return false;');
closeBtn.innerHTML='X';
closeBtn.onclick=function(){
self.hide();
}
topBar.appendChild(closeBtn);
box.appendChild(topBar);
if(_target!=null && _target!='')append(_target);
penguinbox_data.boxesArray.push({obj:box,appended:_target});



//this.self=box;

this.onHide=null;

this.onShow=null;


this.getTopBar=function(){
return topBar;
}


this.append=function(_target){
append(_target);
}
function append(_target){
if(_target!=null)_target.appendChild(box);
}


this.show=function(){
box.style.display='';
self.setZIndex();
if(onShowListener!=null && onShowListener!='')onShowListener();
}


this.hide=function(){
box.style.display='none';
if(onHideListener!=null && onHideListener!='')onHideListener();
}


this.release=function(){
box.style.display='none';
for(var i in penguinbox_data.boxesArray){
if(penguinbox_data.boxesArray[i].obj==box){
penguinbox_data.boxesArray[i].appended.removeChild(box);
penguinbox_data.boxesArray.splice(i,1);
}
}
}


this.getIsShow=function(){
if(box.style.display=='')return true;
return false;
}


this.getPosition=function(){
return {top:parseInt(box.style.height),left:parseInt(box.style.width)};
}


this.setOnShowListener=function(_fun){
onShowListener=_fun;
}


this.setOnHideListener=function(_fun){
onHideListener=_fun;
}


this.setId=function(_boxName){
box.setAttribute('id',_boxName);
}


this.setAllowClose=function(_bool){
if(_bool==true){
closeBtn.style.display='';
}else{
closeBtn.style.display='none';
}
}


this.setLightWhenSelected=function(_boolean){
if(box.style.backgroundColor.indexOf('rgba(')!=-1 && _boolean==true)lightWhenSelected=true;
else lightWhenSelected=false;
}


this.setBorderRadius=function(_radius){
box.style.borderRadius=_radius+'px';
}

this.setPositionWay=function(_way){
box.style.position=_way;
}

this.setPosition=function(_sizeTop,_sizeLeft){
box.style.top=_sizeTop+'%';
box.style.left=_sizeLeft+'%';
}

this.setToCenterMiddle=function(){
box.style.top=(50-(parseInt(box.style.height)/2))+'%';
box.style.left=(50-(parseInt(box.style.width)/2))+'%';
}

this.setSize=function(_sizeWidth,_sizeHeight){
box.style.width=_sizeWidth+'%';
box.style.height=_sizeHeight+'%';
}


this.setBackgroundColor=function(_color){
if(_color!=null)box.style.backgroundColor=_color;
}


this.setBackgroundColorWithRGBA=function(_r,_g,_b,_a){
setBackgroundColorWithRGBA(_r,_g,_b,_a)
}
function setBackgroundColorWithRGBA(_r,_g,_b,_a){
bgcRGBA.r=_r;
bgcRGBA.g=_g;
bgcRGBA.b=_b;
bgcRGBA.a=_a;
box.style.backgroundColor='rgba('+_r+'%, '+_g+'%, '+_b+'%, '+_a+')';
}


this.setTopBarColor=function(_color){
if(_color!=null)topBar.style.backgroundColor=_color;
}


this.setCloseBtnColor=function(_color){
if(_color!=null)closeBtn.style.color=_color;
}


this.setBackgroundImage=function(_image){
if(_image!=null)box.style.backgroundImage="url('"+_image+"')";
}


this.setContentObjectToBox=function(_contentObject){
if(_contentObject!=null){
_contentObject.style.position='absolute';
_contentObject.style.overflowY='auto';
_contentObject.style.width=100+'%';
_contentObject.style.height=95+'%';
_contentObject.style.left=0+'%';
_contentObject.style.top=5+'%';
}
box.appendChild(_contentObject);
}


this.setContentPageToBox=function(_pageSrc){
var page=document.createElement('iframe');
if(_pageSrc!='')page.setAttribute('src',_pageSrc);
page.style.position='absolute';
page.style.width=100+'%';
page.style.height=(100-(parseInt(topBar.style.height)))+'%';
page.style.left=((100/2)-(parseInt(page.style.width)/2))+'%';
page.style.bottom=0+'%';
page.setAttribute('frameborder',0);
page.setAttribute('marginwidth',0);
page.setAttribute('marginheight',0);
page.setAttribute('scrolling','yes');
box.appendChild(page);
}


var movingJSON={down:false};
this.setMoveable=function(_target){
if(_target!=null && _target!=''){
box.style.cursor='all-scroll';
box.onmousedown=function(){
self.setZIndex();
movingJSON.down=true;
movingJSON.x=penguin_getCursorPercent(box,_target).x-parseInt(box.style.left);
movingJSON.y=penguin_getCursorPercent(box,_target).y-parseInt(box.style.top);
if(lightWhenSelected==true){
box.style.backgroundColor='rgba('+bgcRGBA.r+'%, '+bgcRGBA.g+'%, '+bgcRGBA.b+'%, '+(bgcRGBA.a+0.3)+')';
}
_target.onmousemove=function(){
if(movingJSON.down==true){
if(penguin_getCursorPercent(box,_target).x-movingJSON.x>0 && (penguin_getCursorPercent(box,_target).x-movingJSON.x)+parseInt(box.style.width)<100)
box.style.left=penguin_getCursorPercent(box,_target).x-movingJSON.x+'%';
if(penguin_getCursorPercent(box,_target).y-movingJSON.y>0 && (penguin_getCursorPercent(box,_target).y-movingJSON.y)+parseInt(box.style.height)<100)
box.style.top=penguin_getCursorPercent(box,_target).y-movingJSON.y+'%';
}
}
_target.onmouseup=function(){
movingJSON.down=false;
if(lightWhenSelected==true){
self.setBackgroundColorWithRGBA(bgcRGBA.r,bgcRGBA.g,bgcRGBA.b,bgcRGBA.a);
}
}
}
}
}


this.setZIndex=function(){
var nowZIndexArr=new Array();
for(var i=0;i<penguinbox_data.boxesArray.length;i++){
nowZIndexArr[i]=penguinbox_data.boxesArray[i].obj.style.zIndex;
}
var nowMax=Math.max.apply(Math,nowZIndexArr);
var nowMeIndex=box.style.zIndex;
if(nowMax>nowMeIndex){
for(var i=0;i<penguinbox_data.boxesArray.length;i++){
if(i!=box){
if(penguinbox_data.boxesArray[i].obj.style.zIndex>nowMeIndex)penguinbox_data.boxesArray[i].obj.style.zIndex=penguinbox_data.boxesArray[i].obj.style.zIndex-1;
}
}
box.style.zIndex=nowMax;
}
}


this.setBorder=function(_bWidth,_bColor,_bStyle){
if(_bStyle=='' || _bStyle==null)_bStyle='solid';
box.style.borderWidth=_bWidth+'px';
box.style.borderColor=_bColor;
box.style.borderStyle=_bStyle;
}


this.setCloseButtonBackgroundColor=function(_color){
if(_color!=null)topBar.style.backgroundColor=_color;
}


}












function PenguinMessageBar(){

var mbar=document.createElement('table');
mbar.border=0;
mbar.style.position='fixed';
mbar.style.top=40+'%';
mbar.style.left=0+'%';
mbar.style.width=100+'%';
mbar.style.height=20+'%';
mbar.style.backgroundColor='rgba(255%,255%,255%,0.9)';
mbar.style.cursor='default';
mbar.style.zIndex=10100;
mbar.style.display='none';
mbar.setAttribute('onselectstart','return false;');
var mbtr=document.createElement('tr');
var mbtd=document.createElement('td');
mbtd.width='100%';
mbtd.height='100%';
mbtd.setAttribute('align','center');
mbtd.setAttribute('valign','middle');
mbtd.style.fontSize=68+'px';
mbtd.style.fontFamily="'HelveticaNeue-UltraLight',Helvetica,Arial,sans-serif";
mbtd.style.color='red';
mbtd.innerHTML='Penguin Message Bar';
mbtr.appendChild(mbtd);
mbar.appendChild(mbtr);
document.body.appendChild(mbar);
var bIsShowing=false;



this.show=function(_msg){
show(_msg);
}
function show(_msg){
bIsShowing=true;
mbar.style.display='';
setMessage(_msg);
penguin_animation_opacityObj(mbar,0.5,'ease',0,0,1);
}


this.hide=function(){
hide();
}
function hide(){
penguin_animation_opacityObj(mbar,0.8,'ease',0,1,0);
setTimeout(function(){
if(bIsShowing==false)mbar.style.display='none';
},800);
}


this.setMessage=function(_msg){
setMessage(_msg);
}
function setMessage(_msg){
mbtd.innerHTML=_msg;
}


this.setZIndex=function(_zindex){
mbar.style.zIndex=_zindex;
}


this.setTop=function(_top){
setTop(_top);
}
function setTop(_top){
mbar.style.top=_top;
}


this.setBackgroundColor=function(_color){
mbar.style.backgroundColor=_color;
}

this.setFontColor=function(_color){
mbtd.style.color=_color;
}

}












function PenguinMessagePopBox(){

var mpb=document.createElement('table');
var mpbWidth=28;
var mpbShowAnimationTime=0.2;
mpb.border=0;
mpb.style.zIndex=10200;
mpb.style.position='fixed';
mpb.style.width=mpbWidth+'%';
mpb.style.height='28%';
mpb.style.bottom='3%';
mpb.style.left=(50-(mpbWidth/2))+'%';
mpb.style.backgroundColor='rgba(83,83,83,0.7)';
mpb.style.borderRadius='30px';
mpb.style.display='none';
var mpbTr=document.createElement('tr');
var mpbTd=document.createElement('td');
mpbTd.setAttribute('align','center');
mpbTd.setAttribute('valign','middle');
mpbTd.style.fontSize='25px';
mpbTd.style.color='white';
mpbTr.appendChild(mpbTd);
mpb.appendChild(mpbTr);
document.body.appendChild(mpb);

this.show=function(_text){
show(_text);
}
this.showWithTime=function(_text,_second){
show(_text);
setTimeout(function(){
hide();
},_second*1000);
}
function show(_text){
mpbTd.innerHTML=_text;
mpb.style.display='';
penguin_animation_opacityObj(mpb,mpbShowAnimationTime,'ease',0,0,1);
}

this.hide=function(){
hide();
}
function hide(){
penguin_animation_opacityObj(mpb,mpbShowAnimationTime,'ease',0,1,0);
setTimeout(function(){mpb.style.display='none';},(mpbShowAnimationTime*1000));
}

this.setId=function(_id){
mpb.setAttribute('id',_id);
}

this.setZIndex=function(_zindex){
mpb.style.zIndex=_zindex;
}

this.setShowAnimationTime=function(_second){
mpbShowAnimationTime=_second;
}

this.setWidth=function(_width){
mpbWidth=_width;
mpb.style.width=_width;
}

this.setHeight=function(_height){
mpb.style.height=_height;
}

this.setLeft=function(_left){
mpb.style.left=_left;
}

this.setBottom=function(_bottom){
mpb.style.bottom=_bottom;
}

this.setBorder=function(_border){
mpb.border=_border;
}

this.setFontSize=function(_size){
mpbTd.style.fontSize=_size+'px';
}

this.setFontColor=function(_color){
mpbTd.style.color=_color;
}

this.setBackgroundColor=function(_color){
mpb.style.backgroundColor=_color;
}

this.setRadius=function(_radius){
mpb.style.borderRadius=_radius+'px';
}

this.getObjects=function(){
return {mainObject:mpb,contentObject:mpbTd};
}

}












function PenguinButton(_target,_pWidth,_pHeight,_fColor,_text){

var btnTable=document.createElement('table');
btnTable.style.width=_pWidth+'%';
btnTable.style.height=_pHeight+'%';
btnTable.style.cursor='pointer';
btnTable.style.color=_fColor;
btnTable.style.fontSize=60+'px';
btnTable.style.fontFamily="'HelveticaNeue-UltraLight',Helvetica,Arial,sans-serif";
btnTable.style.backgroundColor='white';
var btnTr=document.createElement('tr');
var btnTd=document.createElement('td');
btnTd.setAttribute('width','100%');
btnTd.setAttribute('height','100%');
btnTd.setAttribute('align','center');
btnTd.setAttribute('valign','middle');
btnTd.innerHTML=_text;
btnTr.appendChild(btnTd);
btnTable.appendChild(btnTr);
_target.appendChild(btnTable);


this.setText=function(_text){
setText(_text);
}
function setText(_text){
btnTd.innerHTML=_text;
}


this.setTextColor=function(_color){
setTextColor(_color);
}
function setTextColor(_color){
btnTd.style.color=_color;
}

this.setTextSize=function(_size){
btnTable.style.fontSize=_size+'px';
}


this.setBackgroundColor=function(_color){
setBackgroundColor(_color);
}
function setBackgroundColor(_color){
btnTable.style.backgroundColor=_color;
}

this.setTopLeft=function(_pTop,_pLeft){
btnTable.style.position='absolute';
btnTable.style.top=_pTop+'%';
btnTable.style.left=_pLeft+'%';
}


this.setOnClickListener=function(_fun){
btnTable.onclick=function(){
_fun();
}
}

this.releaseOnClickListener=function(){
btnTable.onclick=function(){}
}


}












function PenguinMenuList(_target,_width,_height){

var backgroundColor='';
var selectedColor='';
var moverColor='';
var textNormalColor='black';
var textSelectedColor='silver';
var fFamily='';
var fSize=36;
var onSelectListener=null;
var buttonList=[];
var menu=document.createElement('div');
menu.style.width=_width+'%';
menu.style.height=_height+'%';
var mtable=document.createElement('table');
mtable.style.width='100%';
mtable.style.minWidth='100%';
mtable.style.maxWidth='100%';
mtable.setAttribute('border','0');
mtable.setAttribute('cellspacing','0');
mtable.setAttribute('cellpadding','6');
menu.appendChild(mtable);
_target.appendChild(menu);

function setBackgroundColor(){
menu.style.backgroundColor=backgroundColor;
}

this.addButton=function(_text){
var mtr=document.createElement('tr');
var mtd=document.createElement('td');
var btnData={tr:mtr,td:mtd,selected:false};
mtr.onmouseover=function(){
if(btnData.selected==false)mtr.style.backgroundColor=moverColor;
}
mtr.onmouseout=function(){
if(btnData.selected==false)mtr.style.backgroundColor='';
}
mtr.onclick=function(){
for(var i=0;i<buttonList.length;i++){
buttonList[i].selected=false;
buttonList[i].tr.style.backgroundColor='';
buttonList[i].td.style.color=textNormalColor;
}
btnData.selected=true;
mtr.style.backgroundColor=selectedColor;
mtd.style.color=textSelectedColor;
if(onSelectListener!=null)onSelectListener();
}
mtd.setAttribute('align','center');
mtd.style.fontSize=fSize+'px';
mtd.style.color=textNormalColor;
mtd.innerHTML=_text;
mtr.appendChild(mtd);
mtable.appendChild(mtr);
buttonList.push(btnData);
}

this.setColor=function(_backgroundColor,_moverColor,_selectedColor,_textNormalColor,_textSelectedColor){
backgroundColor=_backgroundColor;
selectedColor=_selectedColor;
moverColor=_moverColor;
textNormalColor=_textNormalColor;
textSelectedColor=_textSelectedColor;
setBackgroundColor(_backgroundColor);
for(var i=0;i<buttonList.length;i++){
if(buttonList[i].selected==false)buttonList[i].tr.style.backgroundColor='';
else buttonList[i].tr.style.backgroundColor=selectedColor;
}
}

this.setFontFamily=function(_family){
fFamily=_family;
for(var i=0;i<buttonList.length;i++)buttonList[i].tr.style.fontFamily=fFamily;
}

this.setFontSize=function(_size){
fSize=_size;
for(var i=0;i<buttonList.length;i++)buttonList[i].tr.style.fontSize=fSize;
}

function setSelectedUI(_index){
if(_index<buttonList.length && _index>=0){
buttonList[_index].selected=true;
buttonList[_index].tr.style.backgroundColor=selectedColor;
buttonList[_index].td.style.color=textSelectedColor;
return true;
}
return false;
}

this.setDefaultSelected=function(_index){
setSelectedUI(_index);
}

this.setSelected=function(_index){
if(setSelectedUI(_index) && onSelectListener!=null)onSelectListener();
}

this.setOnSelectListener=function(_fun){
onSelectListener=_fun;
}

this.getSelected=function(){
for(var i=0;i<buttonList.length;i++){
if(buttonList[i].selected==true)return i;
}
return -1;
}

}












function penguin_getCursorPercent(_obj,_target){
if(_target!=document.body){
return {x:((event.pageX)-(parseInt(_obj.style.left)/100)-((parseInt(_target.style.left)+parseInt(_obj.style.width))/100))/((penguin_getBrowserWidthHeight().width*(parseInt(_target.style.width)/100))/100),y:((event.pageY)-(parseInt(_obj.style.top)/100)-((parseInt(_target.style.top)+parseInt(_obj.style.height))/100))/((penguin_getBrowserWidthHeight().height*(parseInt(_target.style.height)/100))/100)};
}else{
return {x:event.pageX/(window.innerWidth/100),y:event.pageY/(window.innerHeight/100)};
}
}


function penguin_getBrowserWidthHeight(){
return {width:window.innerWidth,height:window.innerHeight};
}


function penguin_opacityObj(_obj,_opacity){
if(_obj!=null){
_obj.style.opacity=_opacity;
}
}


function penguin_animation_setObjTransition(_obj,_cmd){
if(_obj!=null){
try{
if(_obj.style.webkitTransition){
var penguin_webkit_nowTr=_obj.style.webkitTransition;
if(penguin_webkit_nowTr.indexOf(_cmd)!=-1){
var penguin_webkit_newTr=penguin_webkit_nowTr.split(_cmd);
if(penguin_webkit_newTr[0] && penguin_webkit_newTr[1])_obj.style.webkitTransition=penguin_webkit_newTr[0]+', '+_cmd+', '+penguin_webkit_newTr[1];
else if(penguin_webkit_newTr[0])_obj.style.webkitTransition=penguin_webkit_newTr[0]+', '+s;
else if(penguin_webkit_newTr[1])_obj.style.webkitTransition=_cmd+', '+penguin_webkit_newTr[1];
}else _obj.style.webkitTransition=_obj.style.webkitTransition+', '+_cmd;
}else _obj.style.webkitTransition=_cmd;
}catch(err){}
try{
if(_obj.style.msTransition){
var penguin_ms_nowTr=_obj.style.msTransition;
if(penguin_ms_nowTr.indexOf(_cmd)!=-1){
var penguin_ms_newTr=penguin_ms_nowTr.split(_cmd);
if(penguin_ms_newTr[0] && penguin_ms_newTr[1])_obj.style.msTransition=penguin_ms_newTr[0]+', '+_cmd+', '+penguin_ms_newTr[1];
else if(penguin_ms_newTr[0])_obj.style.msTransition=penguin_ms_newTr[0]+', '+s;
else if(penguin_ms_newTr[1])_obj.style.msTransition=_cmd+', '+penguin_ms_newTr[1];
}else _obj.style.msTransition=_obj.style.msTransition+', '+_cmd;
}else _obj.style.msTransition=_cmd;
}catch(err){}
try{
if(_obj.style.mozTransition){
var penguin_moz_nowTr=_obj.style.mozTransition;
if(penguin_moz_nowTr.indexOf(_cmd)!=-1){
var penguin_moz_newTr=penguin_moz_nowTr.split(_cmd);
if(penguin_moz_newTr[0] && penguin_moz_newTr[1])_obj.style.mozTransition=penguin_moz_newTr[0]+', '+_cmd+', '+penguin_moz_newTr[1];
else if(penguin_moz_newTr[0])_obj.style.mozTransition=penguin_moz_newTr[0]+', '+s;
else if(penguin_moz_newTr[1])_obj.style.mozTransition=_cmd+', '+penguin_moz_newTr[1];
}else _obj.style.mozTransition=_obj.style.mozTransition+', '+_cmd;
}else _obj.style.mozTransition=_cmd;
}catch(err){}
try{
if(_obj.style.oTransition){
var penguin_o_nowTr=_obj.style.oTransition;
if(penguin_o_nowTr.indexOf(_cmd)!=-1){
var penguin_o_newTr=penguin_o_nowTr.split(_cmd);
if(penguin_o_newTr[0] && penguin_o_newTr[1])_obj.style.oTransition=penguin_o_newTr[0]+', '+_cmd+', '+penguin_o_newTr[1];
else if(penguin_o_newTr[0])_obj.style.oTransition=penguin_o_newTr[0]+', '+s;
else if(penguin_o_newTr[1])_obj.style.oTransition=_cmd+', '+penguin_o_newTr[1];
}else _obj.style.oTransition=_obj.style.oTransition+', '+_cmd;
}else _obj.style.oTransition=_cmd;
}catch(err){}
try{
if(_obj.style.transition){
var tpenguin_nowTr=_obj.style.transition;
if(tpenguin_nowTr.indexOf(_cmd)!=-1){
var tpenguin_newTr=tpenguin_nowTr.split(_cmd);
if(tpenguin_newTr[0] && tpenguin_newTr[1])_obj.style.transition=tpenguin_newTr[0]+', '+_cmd+', '+tpenguin_newTr[1];
else if(tpenguin_newTr[0])_obj.style.transition=tpenguin_newTr[0]+', '+s;
else if(tpenguin_newTr[1])_obj.style.transition=_cmd+', '+tpenguin_newTr[1];
}else _obj.style.transition=_obj.style.transition+', '+_cmd;
}else _obj.style.transition=_cmd;
}catch(err){}
}else{return false;}
}


function penguin_animation_opacityObj(_obj,_duration,_showMethod,_delay,_fromOpacity,_toOpacity){
penguin_opacityObj(_obj,_fromOpacity);
var penguin_s='opacity '+_duration+'s '+_showMethod+' '+_delay+'s';
penguin_animation_setObjTransition(_obj,penguin_s);
setTimeout(function(){
penguin_opacityObj(_obj,_toOpacity);
},0);
}