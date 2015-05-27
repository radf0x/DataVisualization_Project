docW=window.innerWidth;
docH=window.innerHeight;

function createXMLHttpRequest2(link,dataJSON,returnType,endFunction,progressFunction){
var formData=new FormData();
for(var i in dataJSON)formData.append(i,dataJSON[i]);
var xhr=new XMLHttpRequest();
xhr.open('POST',link,true);
xhr.onload=function(e){
};
xhr.onreadystatechange=function(){
if((xhr.readyState==4)&&(xhr.status==200)){
try{
if(endFunction!=null){
if(returnType.toUpperCase()=='JSON')endFunction(eval('('+xhr.responseText+')'));
else endFunction(xhr.responseText);
}
}catch(e){}
}
};
xhr.upload.onprogress=function(e){
if(e.lengthComputable){
if(progressFunction!=null)progressFunction(e);
}
};
xhr.send(formData);
}

function obj(o){
return document.getElementById(o);
}
function objv(o){
return document.getElementById(o).value;
}

function ajax(in_request,in_data,in_returnType,in_function){
createXMLHttpRequest2(in_request,in_data,in_returnType,function(msg){
in_function(msg);
},null);
}

function ajaxt(in_request,in_data,in_function){
ajax(in_request,in_data,'text',in_function);
}

function ajaxj(in_request,in_data,in_function){
ajax(in_request,in_data,'json',in_function);
}

function PositionManager(){
var self=this;

this.absoluteObject=function(_obj){
_obj.style.position='absolute';
}

this.centerObject=function(_obj,_unit,_usingCSS){
if(_obj!=null){
self.absoluteObject(_obj);
var doc_w=0;
if(_unit=='%' && _usingCSS==true)doc_w=100;
if(_usingCSS)_obj.style.left=((doc_w/2)-(parseInt(_obj.style.width)/2))+_unit;
else _obj.style.left=((doc_w/2)-(_obj.width/2))+_unit;
}else{return false;}
}

this.middleObject=function(_obj,_unit,_usingCSS){
if(_obj!=null){
self.absoluteObject(_obj);
var doc_h=0;
if(_unit=='%' && _usingCSS==true)doc_h=100;
if(_usingCSS)_obj.style.top=((doc_h/2)-(parseInt(_obj.style.height)/2))+_unit;
else _obj.style.top=((doc_h/2)-(_obj.height/2))+_unit;
}else{return false;}
}

}



function DateHelper(){

var self=this;

this.getTodayDateString=function(){
var todayTodayString=new Date();
var todayMonthString=todayTodayString.getMonth()+1;
if(todayMonthString<10)todayMonthString='0'+todayMonthString;
var todayDateString=todayTodayString.getDate();
if(todayDateString<10)todayDateString='0'+todayDateString;
todayTodayString=todayTodayString.getFullYear()+'-'+todayMonthString+'-'+todayDateString;
return todayTodayString;
}

this.getNowTime=function(){
var nowt=new Date();
var mi=nowt.getMinutes();
var se=nowt.getSeconds();
var ms=nowt.getMilliseconds();
if(mi<10)mi='0'+mi;
if(se<10)se='0'+se;
if(ms<10)ms='0'+ms;
return nowt.getHours()+':'+mi+':'+se+'.'+ms;
}

this.datesComparing=function(startDate,endDate){
startDate=startDate.split('-');
endDate=endDate.split('-');
return Math.ceil(new Date(startDate[0],startDate[1],startDate[2]).getTime()-new Date(endDate[0],endDate[1],endDate[2]).getTime())/(24*60*60*1000);
}

this.toTimeHM=function(theDate){
return theDate.substr(0,5);
}

this.toTimeHMS=function(theDate){
return theDate.substr(0,8);
}

this.getDateYMByDropMonth=function(da,mo){
var nM=(new Date(da).getMonth())+1;
var yr=new Date(da).getFullYear();
for(var i=0;i<mo;i++){
nM--;
if(nM==0){
nM=12;
yr--;
}
}
if(nM<10)nM='0'+nM;
return (yr+'-'+nM);
}

}




function AnimationManager(){

var self=this;

this.setAnimaTionOpacity=function(_obj,_duration,_delay,_showMethod,_fromOpacity,_toOpacity){
_obj.style.opacity=_fromOpacity;
var animationScript='opacity '+_duration+'s '+_showMethod+' '+_delay+'s';
self.setObjTransition(_obj,animationScript);
setTimeout(function(){
_obj.style.opacity=_toOpacity;
},0);
}

this.setAnimationMove=function(_obj,_duration,_delay,_showMethod,_fromLeft,_fromTop,_toLeft,_toTop,_unit){
_obj.style.left=_fromLeft+_unit;
_obj.style.top=_fromTop+_unit;
var animationScript='left '+_duration+'s '+_showMethod+' '+_delay+'s, '+'top'+' '+_duration+'s '+_showMethod+' '+_delay+'s';
self.setObjTransition(_obj,animationScript);
setTimeout(function(){
_obj.style.left=_toLeft+_unit;
_obj.style.top=_toTop+_unit;
},0);
}

this.setAnimationScale=function(_obj,_duration,_showMethod,_delay,_fromScale,_toScale){
self.animation_transformObj(_obj,_duration,_showMethod,_delay,{scale:{fromScale:_fromScale,toScale:_toScale}});
}

this.setAnimationBackgroundColor=function(_obj,_duration,_showMethod,_delay,_fromColor,_toColor){
var _theObj=_obj;
if(_theObj!=null){
_obj.style.backgroundColor=_fromColor;
setTimeout(function(){
var _s='background-Color '+_duration+'s '+_showMethod+' '+_delay+'s';
self.setObjTransition(_obj,_s);
setTimeout(function(){
_obj.style.backgroundColor=_toColor;
},0);
},0.1);
}else{return false;}
}

this.animation_transformObj=function(_obj,_duration,_showMethod,_delay,_transformJSON){
var _theObj=_obj;
if(_theObj!=null){
if(_transformJSON['rotate'])self.rotateObj(_obj,_transformJSON['rotate']['fromRotateAngle']);
if(_transformJSON['rotateX'])self.rotateXObj(_obj,_transformJSON['rotateX']['fromRotateAngle']);
if(_transformJSON['rotateY'])self.rotateYObj(_obj,_transformJSON['rotateY']['fromRotateAngle']);
if(_transformJSON['scale'])self.scaleObj(_obj,_transformJSON['scale']['fromScale']);
if(_transformJSON['skew'])self.skewObj(_obj,_transformJSON['skew']['formXAngle'],_transformJSON['skew']['fromYAngle']);
setTimeout(function(){
// Can add more start.
var _s='';
if(self.checkBrowserKernel()!='none')_s='-'+self.checkBrowserKernel()+'-transform '+_duration+'s '+_showMethod+' '+_delay+'s';
else _s='transform '+_duration+'s '+_showMethod+' '+_delay+'s';
// Can add more end.
self.setObjTransition(_obj,_s);
setTimeout(function(){
if(_transformJSON['rotate'])self.rotateObj(_obj,_transformJSON['rotate']['toRotateAngle']);
if(_transformJSON['rotateX'])self.rotateXObj(_obj,_transformJSON['rotateX']['toRotateAngle']);
if(_transformJSON['rotateY'])self.rotateYObj(_obj,_transformJSON['rotateY']['toRotateAngle']);
if(_transformJSON['scale'])self.scaleObj(_obj,_transformJSON['scale']['toScale']);
if(_transformJSON['skew'])self.skewObj(_obj,_transformJSON['skew']['toXAngle'],_transformJSON['skew']['toYAngle']);
},0);
},0.1);
}else{return false;}
}

this.scaleObj=function(_obj,_scaleNum){
var _s='scale('+_scaleNum+')';
self.setObjTransform(_obj,_s);
}

this.scaleXObj=function(_obj,_scaleNum){
var _s='scaleX('+_scaleNum+')';
self.setObjTransform(_obj,_s);
}

this.scaleYObj=function(_obj,_scaleNum){
var _s='scaleY('+_scaleNum+')';
self.setObjTransform(_obj,_s);
}

this.rotateObj=function(_obj,_rotateAngle){
var _s='rotate('+_rotateAngle+'deg)';
self.setObjTransform(_obj,_s);
}

this.rotateXObj=function(_obj,_rotateAngle){
var _s='rotateX('+_rotateAngle+'deg)';
self.setObjTransform(_obj,_s);
}

this.rotateYObj=function(_obj,_rotateAngle){
var _s='rotateY('+_rotateAngle+'deg)';
self.setObjTransform(_obj,_s);
}

this.skewObj=function(_obj,_xAngle,_yAngle){
var _s='skew('+_xAngle+'deg,'+_yAngle+'deg)';
self.setObjTransform(_obj,_s);
}

this.checkBrowserKernel=function(){
var b=navigator.userAgent.toLowerCase();
if(b.indexOf('webkit')!=-1)return 'webkit';
else if(b.indexOf('firefox')!=-1)return 'moz';
else if(b.indexOf('msie')!=-1)return 'ms';
else if(b.indexOf('opera')!=-1)return 'o';
return 'none';
}

this.setObjTransform=function(_obj,_s){
if(_obj!=null){
try{
var webkit_nowTr=_obj.style.webkitTransform;
var webkit_inTr=_s.substring(0,_s.indexOf('('));
if(webkit_nowTr.indexOf(webkit_inTr)!=-1){
var webkit_matchedTr=webkit_nowTr.substring(webkit_nowTr.indexOf(webkit_inTr),1+webkit_nowTr.indexOf(')',webkit_nowTr.indexOf(webkit_inTr)));
var webkit_newTr=_obj.style.webkitTransform.split(webkit_matchedTr);
_obj.style.webkitTransform=webkit_newTr[0]+_s+webkit_newTr[1];
}else{
_obj.style.webkitTransform=_obj.style.webkitTransform+_s;
}
}catch(err){}
try{
var moz_nowTr=_obj.style.mozTransform;
var moz_inTr=_s.substring(0,_s.indexOf('('));
if(moz_nowTr.indexOf(moz_inTr)!=-1){
var moz_matchedTr=moz_nowTr.substring(moz_nowTr.indexOf(moz_inTr),1+moz_nowTr.indexOf(')',moz_nowTr.indexOf(moz_inTr)));
var moz_newTr=_obj.style.mozTransform.split(moz_matchedTr);
_obj.style.mozTransform=moz_newTr[0]+_s+moz_newTr[1];
}else{
_obj.style.mozTransform=_obj.style.mozTransform+_s;
}
}catch(err){}
try{
var ms_nowTr=_obj.style.msTransform;
var ms_inTr=_s.substring(0,_s.indexOf('('));
if(ms_nowTr.indexOf(ms_inTr)!=-1){
var ms_matchedTr=ms_nowTr.substring(ms_nowTr.indexOf(ms_inTr),1+ms_nowTr.indexOf(')',ms_nowTr.indexOf(ms_inTr)));
var ms_newTr=_obj.style.msTransform.split(ms_matchedTr);
_obj.style.msTransform=ms_newTr[0]+_s+ms_newTr[1];
}else{
_obj.style.msTransform=_obj.style.msTransform+_s;
}
}catch(err){}
try{
var o_nowTr=_obj.style.oTransform;
var o_inTr=_s.substring(0,_s.indexOf('('));
if(o_nowTr.indexOf(o_inTr)!=-1){
var o_matchedTr=o_nowTr.substring(o_nowTr.indexOf(o_inTr),1+o_nowTr.indexOf(')',o_nowTr.indexOf(o_inTr)));
var o_newTr=_obj.style.oTransform.split(o_matchedTr);
_obj.style.oTransform=o_newTr[0]+_s+o_newTr[1];
}else{
_obj.style.oTransform=_obj.style.oTransform+_s;
}
}catch(err){}
try{
var _nowTr=_obj.style.transform;
var _inTr=_s.substring(0,_s.indexOf('('));
if(_nowTr.indexOf(_inTr)!=-1){
var _matchedTr=_nowTr.substring(_nowTr.indexOf(_inTr),1+_nowTr.indexOf(')',_nowTr.indexOf(_inTr)));
var _newTr=_obj.style.transform.split(_matchedTr);
_obj.style.transform=_newTr[0]+_s+_newTr[1];
}else{
_obj.style.transform=_obj.style.transform+_s;
}
}catch(err){}
}else{return false;}
}

this.setObjTransition=function(_obj,_cmd){
if(_obj!=null){
try{
if(_obj.style.webkitTransition){
var webkit_nowTr=_obj.style.webkitTransition;
if(webkit_nowTr.indexOf(_cmd)!=-1){
var webkit_newTr=webkit_nowTr.split(_cmd);
if(webkit_newTr[0] && webkit_newTr[1])_obj.style.webkitTransition=webkit_newTr[0]+', '+_cmd+', '+webkit_newTr[1];
else if(webkit_newTr[0])_obj.style.webkitTransition=webkit_newTr[0]+', '+s;
else if(webkit_newTr[1])_obj.style.webkitTransition=_cmd+', '+webkit_newTr[1];
}else _obj.style.webkitTransition=_obj.style.webkitTransition+', '+_cmd;
}else _obj.style.webkitTransition=_cmd;
}catch(err){}
try{
if(_obj.style.msTransition){
var ms_nowTr=_obj.style.msTransition;
if(ms_nowTr.indexOf(_cmd)!=-1){
var ms_newTr=ms_nowTr.split(_cmd);
if(ms_newTr[0] && ms_newTr[1])_obj.style.msTransition=ms_newTr[0]+', '+_cmd+', '+ms_newTr[1];
else if(ms_newTr[0])_obj.style.msTransition=ms_newTr[0]+', '+s;
else if(ms_newTr[1])_obj.style.msTransition=_cmd+', '+ms_newTr[1];
}else _obj.style.msTransition=_obj.style.msTransition+', '+_cmd;
}else _obj.style.msTransition=_cmd;
}catch(err){}
try{
if(_obj.style.mozTransition){
var moz_nowTr=_obj.style.mozTransition;
if(moz_nowTr.indexOf(_cmd)!=-1){
var moz_newTr=moz_nowTr.split(_cmd);
if(moz_newTr[0] && moz_newTr[1])_obj.style.mozTransition=moz_newTr[0]+', '+_cmd+', '+moz_newTr[1];
else if(moz_newTr[0])_obj.style.mozTransition=moz_newTr[0]+', '+s;
else if(moz_newTr[1])_obj.style.mozTransition=_cmd+', '+moz_newTr[1];
}else _obj.style.mozTransition=_obj.style.mozTransition+', '+_cmd;
}else _obj.style.mozTransition=_cmd;
}catch(err){}
try{
if(_obj.style.oTransition){
var o_nowTr=_obj.style.oTransition;
if(o_nowTr.indexOf(_cmd)!=-1){
var o_newTr=o_nowTr.split(_cmd);
if(o_newTr[0] && o_newTr[1])_obj.style.oTransition=o_newTr[0]+', '+_cmd+', '+o_newTr[1];
else if(o_newTr[0])_obj.style.oTransition=o_newTr[0]+', '+s;
else if(o_newTr[1])_obj.style.oTransition=_cmd+', '+o_newTr[1];
}else _obj.style.oTransition=_obj.style.oTransition+', '+_cmd;
}else _obj.style.oTransition=_cmd;
}catch(err){}
try{
if(_obj.style.transition){
var tnowTr=_obj.style.transition;
if(tnowTr.indexOf(_cmd)!=-1){
var tnewTr=tnowTr.split(_cmd);
if(tnewTr[0] && tnewTr[1])_obj.style.transition=tnewTr[0]+', '+_cmd+', '+tnewTr[1];
else if(tnewTr[0])_obj.style.transition=tnewTr[0]+', '+s;
else if(tnewTr[1])_obj.style.transition=_cmd+', '+tnewTr[1];
}else _obj.style.transition=_obj.style.transition+', '+_cmd;
}else _obj.style.transition=_cmd;
}catch(err){}
}else{return false;}
}

}


