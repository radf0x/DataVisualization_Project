<?
ob_start();
session_start();
include('ser_manager.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SE</title>
<link rel="stylesheet" href="settings.css"></link>
<script type="text/javascript" src="requiredapi.js"></script>
<script type="text/javascript" src="penguin_v2-2.js"></script>
<script type="text/javascript" src="processbar.js"></script>
</head>
<body topmargin="0" leftmarign="0" style="overflow:hidden;" bgcolor="black">

<img src="imgs/bg_12.png" style="position:absolute;top:0%;left:0%;width:100%;height:100%;" />

<?
if($_SESSION[userId]){
?>
<style>
.mainBoxCSS{
overflow: auto;
position: absolute;
top: 12%;
width: 80%;
height: 70%;
background-color: rgba(80,80,80,0.3);
}

a{
text-decoration:none;
}

<? if($_SESSION[userRole]!='staff'){ ?>
#GoalDiv{
left: 10%;
}
#GroupDiv{
left: 110%;
}
#HealthDiv{
left: 210%;
}
#FoodDiv{
left: 310%;
}
#CompanyDiv{
left: 410%;
}
#SettingsDiv{
left: 510%;
}
<? }else{ ?>
#GroupDiv{
left: 10%;
}
#CompanyDiv{
left: 110%;
}
#SettingsDiv{
left: 210%;
}
<? } ?>


.menuBarCSS{
position: absolute;
top: 82%;
left: 10%;
width: 80%;
height: 13%;
background-color: rgba(127,127,127,0.8);
}

.menuBTd{
background-color: rgba(200,200,200,0.5);
background-size: auto 80%;
background-repeat: no-repeat;
background-position: center center;
}

<? if($_SESSION[userRole]!='staff'){ ?>
#menuBTd1{
background-image: url('imgs/index_icon_goal.png');
}
#menuBTd1:hover{
background-image: url('imgs/index_icon_goal_b.png');
}
#menuBTd2{
background-image: url('imgs/index_icon_group.png');
}
#menuBTd2:hover{
background-image: url('imgs/index_icon_group_b.png');
}
#menuBTd3{
background-image: url('imgs/index_icon_health.png');
}
#menuBTd3:hover{
background-image: url('imgs/index_icon_health_b.png');
}
#menuBTd4{
background-image: url('imgs/index_icon_food.png');
}
#menuBTd4:hover{
background-image: url('imgs/index_icon_food_b.png');
}
#menuBTd5{
background-image: url('imgs/index_icon_company.png');
}
#menuBTd5:hover{
background-image: url('imgs/index_icon_company_b.png');
}
#menuBTd6{
background-image: url('imgs/index_icon_settings.png');
}
#menuBTd6:hover{
background-image: url('imgs/index_icon_settings_b.png');
}
<? }else{ ?>
#menuBTd1{
background-image: url('imgs/index_icon_group.png');
}
#menuBTd1:hover{
background-image: url('imgs/index_icon_group_b.png');
}
#menuBTd2{
background-image: url('imgs/index_icon_company.png');
}
#menuBTd2:hover{
background-image: url('imgs/index_icon_company_b.png');
}
#menuBTd3{
background-image: url('imgs/index_icon_settings.png');
}
#menuBTd3:hover{
background-image: url('imgs/index_icon_settings_b.png');
}
<? } ?>

td{
font-family:'HelveticaNeue-UltraLight',Helvetica,Arial,sans-serif;
color: white;
}

</style>


<? if($_SESSION[userRole]!='staff'){ ?>
<div class="mainBoxCSS" id="GoalDiv">
<center><div class="defaultFont3" style="font-size:50px;color:#4E116C;">Goal Bar Chat</div>
<a href="javascript:setGoalBox.show();" class="defaultFont1" style="color:white;font-size:25px;">Set Goal</a><br /><br />
<table id="pbarTable" border="1" cellspacing="0" cellpadding="4">
</table>
</center>
</div>
<script type="text/javascript">
processArray = [];
function getGoalProcess(){
	processArray = [];
	var dateHelper=new DateHelper();
var td=dateHelper.getTodayDateString();
ajaxj('ser_manager.php?request=selectGoalByUserId',{userId:<? echo $_SESSION[userId]; ?>},function(msg){
pbarTable.innerHTML='<tr><td>Goal</td><td colspan="2">Process</td><td>Start day</td><td>End day</td><td>Action</td></tr>';
for(var i in msg){
//var tValue=Math.random(500);
var tr=document.createElement('tr');
var td_1=document.createElement('td');
td_1.innerHTML=msg[i].action;
var td_2=document.createElement('td');
var sd=msg[i].startDate;
var ed=msg[i].endDate;
var a=dateHelper.datesComparing(td,sd);
var b=dateHelper.datesComparing(ed,sd);
var resultDay = a/b *100;
if(resultDay < 0) resultDay = 0;
if (resultDay > 100) resultDay = 100;
var td_3=document.createElement('td');
td_3.innerHTML='00%';
var prb=new ProcessBar(500,50,resultDay);
prb.createElement(td_2);
prb.setAnimation(true);
prb.setOuterColor('white');
prb.setLabelElement(td_3);
processArray.push(prb);
td_3.innerHTML=(resultDay|0)+'%';
prb.afterRandomTimeDraw(0);
var td_4=document.createElement('td');
td_4.innerHTML=sd;
var td_5=document.createElement('td');
td_5.innerHTML=ed;
var td_6=document.createElement('td');
td_6.innerHTML='<a href="javascript:deleteGoal('+msg[i].goalId+');" style="color:white;">Delete</a>';
tr.appendChild(td_1);
tr.appendChild(td_2);
tr.appendChild(td_3);
tr.appendChild(td_4);
tr.appendChild(td_5);
tr.appendChild(td_6);
pbarTable.appendChild(tr);
}
});
}

getGoalProcess();



function deleteGoal(goalId){
ajaxt('ser_manager.php?request=deleteGoal',{goalId:goalId},function(msg){
pas(msg);
getGoalProcess();
});
}
</script>


<div id="addGoalBoxDiv" style="background-color:rgba(10,10,10,0.62);">
<center>
<div class="defaultFont1" style="font-size:50px;color:white;">New Goal</div>
<br />
<form onSubmit="submitNewGoal();return false;">
<table border="1" cellpadding="4" cellspacing="0" width="65%" bordercolor="white">
<tr>
<td align="right">Start Date:</td>
<td><input id="newGoal_sd" type="date" required /></td>
</tr>
<tr>
<td align="right">End Date:</td>
<td><input id="newGoal_ed" type="date" required /></td>
</tr>
<tr>
<td align="right">Goal:</td>
<td>
<select id="newGoal_action" required>
<option>Badminton</option>
<option>Basketball</option>
<option>Bicycle</option>
<option>Football</option>
<option>Hiking</option>
<option>Hockey</option>
<option>Running</option>
<option>Swimming</option>
<option>Table Tennis</option>
<option>Tennis</option>
</select>
</td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" /></td>
</tr>
</table>
</form>
</center>
</div>




<div class="mainBoxCSS" id="FoodDiv">
<center><div class="defaultFont3" style="font-size:50px;color:#4E116C;">Food Infomation</div>
</center></div>

<? } ?>

<div class="mainBoxCSS" id="GroupDiv">
<center><div class="defaultFont3" style="font-size:50px;color:#4E116C;">
Group
<iframe id="groupIFrame" src="cli_indexchatroom.html" marginwidth="2" marginheight="2" frameborder="0" width="93%" height="85%"></iframe>
</div></center>
</div>

<? if($_SESSION[userRole]!='staff'){ ?>
<div class="mainBoxCSS" id="HealthDiv">
<center><div class="defaultFont3" style="font-size:50px;color:#4E116C;">Health</div></center>
<center>
<br />
<form id="health_1_form" onSubmit="submitHealthForm();return false;">
<table border="1" cellpadding="4" cellspacing="0" width="60%">
<tr><td>Weight</td><td><input id="health_add_weight" type="number" min="20" onMouseOver="this.focus();" onChange="submitHealthForm();" />kg</td></tr>
<tr><td>Height</td><td><input id="health_add_height" type="number" min="100" onMouseOver="this.focus();" onChange="submitHealthForm();" />cm</td></tr>
<tr><td>Age</td><td><input id="health_add_age" type="number" min="1" onMouseOver="this.focus();" onChange="submitHealthForm();" />yrs</td></tr>
<tr><td>Goal Weight</td><td><input id="health_add_gweight" type="number" min="1" onMouseOver="this.focus();" onChange="submitHealthForm();" />kg</td></tr>
</table>
<br /><br />
<div id="health_result" class="defaultFont1" style="font-size:25px;color:white;"></div>
</form>
</center>
</div>
<script type="text/javascript">
function submitHealthForm(){
createXMLHttpRequest2('ser_health.php',{w:objv('health_add_weight'),h:objv('health_add_height'),age:objv('health_add_age'),gw:objv('health_add_gweight')},'text',function(msg){
health_result.innerHTML='<div style="line-height:150%">'+msg+'</div>';
},null);
return false;
}

function refreshHealth(){
ajaxj('ser_manager.php?request=selectUserInfoById',{userId:<? echo $_SESSION[userId]; ?>},function(msg){
obj('health_add_weight').value=msg.userWeight;
obj('health_add_height').value=msg.userHeight;
obj('health_add_gweight').value=msg.userWeight;
obj('health_add_age').value=20;
submitHealthForm();
});
}
refreshHealth();
</script>
<? } ?>

<div class="mainBoxCSS" id="CompanyDiv">
<center><div class="defaultFont3" style="font-size:50px;color:#4E116C;">Company</div></center>
<br /><br />
<div class="defaultFont1" style="font-size:25px;color:white;line-height:150%">
<center><img src="c1.jpg" width="36%" style="border-width:5px;border-color:white;border-style:solid;" /></center><br /><br />
At DaveFitnessManager, our mission is to motivate millions of people to reach their goals and lead healthier lives. We offer nutrition, health, and fitness tools, support, and resources that are 100% free, while other sites like California fitness and eDiets.com charge their members for similar services.
<br /><br />
Our weight loss program teaches people to stop dieting and transition to a permanent, healthy lifestyle. Far beyond just weight loss, DaveFitnessManager helps everyone learn to eat better and exercise regularly—for life. And people who don’t want to lose weight can still join and benefit from DaveFitnessManager’s tools, resources and community features. In addition to informative articles and interactive tools, such as fitness trackers and meal plans, members can find support and encouragement from our vibrant, positive community of members and experts. We pride ourselves in offering medically accepted weight-loss and healthy lifestyle recommendations that are easy to understand and implement.
<br /><br />
All the components of our program mix in an element of fun so that our members truly do stick with their programs. In the future, with millions of members, we will  witness thousands of success stories firsthand. We’ve found that using sound nutrition and regular exercise as a “springboard” for success helps our members find greater enjoyment in life and strive for even more goals, creating their own real-life adventures!
<br /><br />
</div>
</div>


<div class="mainBoxCSS" id="SettingsDiv">
<center><div class="defaultFont3" style="font-size:50px;color:#4E116C;">Settings</div>

<? if($_SESSION[userRole]!='staff'){ ?>
<form id="memberSetForm" onSubmit="updateMemInfoForm();return false;">
<table border="1" cellpadding="10" cellspacing="0">
<tr><td>Login name</td><td><input id="set_login" type="text" required /></td></tr>
<tr><td>First name</td><td><input id="set_fname" type="text" required /></td></tr>
<tr><td>Last name</td><td><input id="set_lname" type="text" required /></td></tr>
<tr><td>Weight</td><td><input id="set_weight" type="number" min="20" required />kg</td></tr>
<tr><td>Height</td><td><input id="set_height" type="number" min="20" required />cm</td>
<tr><td align="center" colspan="2"><input type="submit" value="Update" /></td></td></tr>
</table>
</form>
<hr />
<div class="defaultFont1" style="color:white;">Set new password:</div><br />
<form id="memberSetPwd" onSubmit="updateMemPwd();return false;">
<table border="1" cellpadding="10" cellspacing="0">
<tr><td>New password</td><td><input id="set_pwd" type="password" required /></td><td align="center" colspan="2"><input type="submit" value="Update" /></td></tr>
</table>
</form>

<script type="text/javascript">
function refreshMemInfoForm(){
ajaxj('ser_manager.php?request=selectUserInfoById',{userId:<? echo $_SESSION[userId]; ?>},function(msg){
//alert(JSON.stringify(msg));
obj('set_login').value=msg.userName;
obj('set_fname').value=msg.userFName;
obj('set_lname').value=msg.userLName;
obj('set_weight').value=msg.userWeight;
obj('set_height').value=msg.userHeight;
});
}
refreshMemInfoForm();

function updateMemInfoForm(){
//$userId,$userName,$userFName,$userLName,$userWeight,$userHeight,$userRole
ajaxt('ser_manager.php?request=updateUser',{userId:<? echo $_SESSION[userId]; ?>,userName:objv('set_login'),userFName:objv('set_fname'),userLName:objv('set_lname'),userWeight:objv('set_weight'),userHeight:objv('set_height'),userRole:'member'},function(msg){
pas(msg);
refreshMemInfoForm();
refreshHealth();
});
}

function updateMemPwd(){
ajaxt('ser_manager.php?request=updateUserPwd',{userId:<? echo $_SESSION[userId]; ?>,userPwd:objv('set_pwd')},function(msg){
pas(msg);
obj('set_pwd').value = "";
});
}
</script>
<? } ?>

<? if($_SESSION[userRole]=='member'){ ?>
<script type="text/javascript">
var addGoalBoxObj=obj('addGoalBoxDiv');
document.body.removeChild(addGoalBoxObj);

var setGoalBox=new PenguinBox(document.body);
setGoalBox.hide();
setGoalBox.setLightWhenSelected(true);
setGoalBox.setMoveable(document.body);
setGoalBox.setContentObjectToBox(addGoalBoxObj);

function submitNewGoal(){
var sd=obj('newGoal_sd').value;
var ed=obj('newGoal_ed').value;
if(ed>sd){
setGoalBox.hide();
ajaxt('ser_manager.php?request=insertGoal',{startDate:sd,endDate:ed,action:obj('newGoal_action').value},function(msg){
pas(msg);
//refresh
getGoalProcess();
});
}else alert('Please input a valid date!');
}
</script>
<?
if($_SESSION[userRole]=='staff'){
?>
<br /><br />
<a href="javascript:showAddGroupBox();" style="color:white;text-decoration:none;">Group Management</a>
<br /><br />
<a href="javascript:showMemberManagerBox();" style="color:white;text-decoration:none;">Member Management</a>
<br /><br />
<div class="defaultFont1" style="color:white;font-size:38px;">

<hr />
<table width="100%" border="0">
<tr>
<td align="center" style="font-size:41px;">Now we have</td>
</tr>
<tr>
<td align="center" style="font-size:35px;"><font id="set_memCount"></font> members.</td>
</tr>
<tr>
<td align="center" style="font-size:35px;"><font id="set_groupCount"></font> groups.</td>
</tr>
</table>
<? } ?>
</div>

<script type="text/javascript">

function updateUserCount(){
ajaxt('ser_manager.php?request=getUserCount',{allow:'yes'},function(msg){
set_memCount.innerHTML=msg;
});
}
updateUserCount();

function updateGroupCount(){
ajaxt('ser_manager.php?request=getGroupCount',{allow:'yes'},function(msg){
set_groupCount.innerHTML=msg;
});
}
updateGroupCount();

var dateHelper=new DateHelper();
var addGroupBox=new PenguinBox(document.body);
addGroupBox.hide();
addGroupBox.setBackgroundColor('white');
addGroupBox.setLightWhenSelected(true);
addGroupBox.setMoveable(document.body);
addGroupBox.setContentPageToBox('cli_groupmanager.php');
var memberManagerBox=new PenguinBox(document.body);
memberManagerBox.hide();
memberManagerBox.setLightWhenSelected(true);
memberManagerBox.setBackgroundColor('white');
memberManagerBox.setMoveable(document.body);
memberManagerBox.setContentPageToBox('cli_membermanager.php');

function showAddGroupBox(){
addGroupBox.show();
}

function showMemberManagerBox(){
memberManagerBox.show();
}
</script>
<?
}else{
?>

<? } ?>
</center>
</div>





<table border="0" cellspacing="0" class="menuBarCSS" id="menuBarTable">
<tr>
<td class="menuBTd" id="menuBTd1" width="17%" align="center" valign="middle"></td>
<td class="menuBTd" id="menuBTd2" width="16%" align="center" valign="middle"></td>
<td class="menuBTd" id="menuBTd3" width="16%" align="center" valign="middle"></td>
<? if($_SESSION[userRole]!='staff'){ ?>
<td class="menuBTd" id="menuBTd4" width="16%" align="center" valign="middle"></td>
<td class="menuBTd" id="menuBTd5" width="16%" align="center" valign="middle"></td>
<td class="menuBTd" id="menuBTd6" width="16%" align="center" valign="middle"></td>
<? } ?>
</tr>
</table>


<div id="logoutLink" style="position:absolute;top:2%;right:2%;color:white;cursor:pointer;">Logout</div>



<script type="text/javascript">
var in_state=1;
var an_du=1.2;
var an_manager=new AnimationManager();

an_manager.setAnimaTionOpacity(document.body,2,0,'ease',0,1);

<? if($_SESSION[userRole]!='staff'){ ?>
var theBoxes=[obj('GoalDiv'),obj('GroupDiv'),obj('HealthDiv'),obj('FoodDiv'),obj('CompanyDiv'),obj('SettingsDiv')];
var an_left=[[10,110,210,310,410,510,610],[-90,10,110,210,310,410,510],[-180,-90,10,110,210,310,410],[-270,-180,-90,10,110,210,310],[-360,-270,-180,-90,10,110,210],[-450,-360,-270,-180,-90,10,110],[-540,-450,-360,-270,-180,-90,10]];
<? }else{ ?>
var theBoxes=[obj('GroupDiv'),obj('CompanyDiv'),obj('SettingsDiv')];
var an_left=[[10,110,210,310,410],[-90,10,110,210,310],[-180,-90,10,110,210],[-270,-180,-90,10]];
<? } ?>

for(var i=0; i<theBoxes.length; i++){
obj('menuBTd'+(1+i)).onmouseover=function(){
an_manager.setAnimationBackgroundColor(this,0.5,'ease',0,'rgba(200,200,200,0.5)','white');
}
obj('menuBTd'+(1+i)).onmouseout=function(){
an_manager.setAnimationBackgroundColor(this,0.5,'ease',0,'white','rgba(200,200,200,0.5)');
}
obj('menuBTd'+((i+1))).style.cursor='pointer';
if (i == 0 )
obj('menuBTd'+((i+1))).setAttribute("onClick","goRedraw();an_manager.setAnimationMove(theBoxes[0],an_du,0,'ease',parseInt(theBoxes[0].style.left),parseInt(theBoxes[0].style.top),an_left["+i+"][0],parseInt(theBoxes[0].style.top),'%');an_manager.setAnimationMove(theBoxes[1],an_du,0,'ease',parseInt(theBoxes[1].style.left),parseInt(theBoxes[1].style.top),an_left["+i+"][1],parseInt(theBoxes[1].style.top),'%');an_manager.setAnimationMove(theBoxes[2],an_du,0,'ease',parseInt(theBoxes[2].style.left),parseInt(theBoxes[2].style.top),an_left["+i+"][2],parseInt(theBoxes[2].style.top),'%');an_manager.setAnimationMove(theBoxes[3],an_du,0,'ease',parseInt(theBoxes[3].style.left),parseInt(theBoxes[3].style.top),an_left["+i+"][3],parseInt(theBoxes[3].style.top),'%');an_manager.setAnimationMove(theBoxes[4],an_du,0,'ease',parseInt(theBoxes[4].style.left),parseInt(theBoxes[4].style.top),an_left["+i+"][4],parseInt(theBoxes[4].style.top),'%');");
else
obj('menuBTd'+((i+1))).setAttribute("onClick","an_manager.setAnimationMove(theBoxes[0],an_du,0,'ease',parseInt(theBoxes[0].style.left),parseInt(theBoxes[0].style.top),an_left["+i+"][0],parseInt(theBoxes[0].style.top),'%');an_manager.setAnimationMove(theBoxes[1],an_du,0,'ease',parseInt(theBoxes[1].style.left),parseInt(theBoxes[1].style.top),an_left["+i+"][1],parseInt(theBoxes[1].style.top),'%');an_manager.setAnimationMove(theBoxes[2],an_du,0,'ease',parseInt(theBoxes[2].style.left),parseInt(theBoxes[2].style.top),an_left["+i+"][2],parseInt(theBoxes[2].style.top),'%');an_manager.setAnimationMove(theBoxes[3],an_du,0,'ease',parseInt(theBoxes[3].style.left),parseInt(theBoxes[3].style.top),an_left["+i+"][3],parseInt(theBoxes[3].style.top),'%');an_manager.setAnimationMove(theBoxes[4],an_du,0,'ease',parseInt(theBoxes[4].style.left),parseInt(theBoxes[4].style.top),an_left["+i+"][4],parseInt(theBoxes[4].style.top),'%');");
}

obj('logoutLink').onclick=function(){
createXMLHttpRequest2('ser_manager.php?request=accountLogout',{},'text',function(msg){
if(msg=='Successful.')location.reload();
},null);
}

function goRedraw(){
//todo
for(i = 0 ; i < processArray.length; i++){
	processArray[i].clearDraw();
	processArray[i].afterRandomTimeDraw(400);
}
}
</script>


<?
}else{
?>

<div class="defaultFont4" id="unlog_titleText" style="position:absolute;top:3%;left:5%;width:65%;font-size:80px;color:white;">Fitness Manager</div>

<div id="unlog_loginDIV" style="background-color:rgba(0%,0%,0%,0.2);border-radius:90px;position:absolute;width:50%;height:60%;top:25%;">
<table id="loginTable" style="width:90%;height:90%;">
<tr>
<td align="center" valign="">
<div class="defaultFont1 home_loginFormFont">Name:</div>
<input type="text" name="in_name" id="in_name" size="20" maxlength="25" style="background-color:rgba(255%,255%,255%,1);font-size:20pt;color:#505050;border:0px;text-decoration:none;" placeholder="Name" required autofocus onMouseOver="obj('in_name').focus();" onKeyDown="if(event.keyCode==13)loginSubmitRequest();" /><br /><br />
<div class="defaultFont1 home_loginFormFont">Password:</div><input type="password" name="in_pw" id="in_pw" size="20" maxlength="25" style="background-color:rgba(255%,255%,255%,1);font-size:20pt;color:#505050;border:0px;text-decoration:none;" placeholder="Password" required onMouseOver="obj('in_pw').focus();" onKeyDown="if(event.keyCode==13)loginSubmitRequest();" />
</td>
</tr>
<tr>
<td align="center" valign="">
<img id="logform_clearBtn" src="imgs/clearBtn_1a.png" style="cursor:pointer;" />&nbsp;&nbsp;&nbsp;
<img id="logform_submitBtn" src="imgs/submitBtn_1a.png" style="cursor:pointer;" onClick="loginSubmitRequest();" />
</td>
</tr>
</table>
</div>

<script type="text/javascript">
var positionManager=new PositionManager();
positionManager.centerObject(obj('unlog_loginDIV'),'%',true);
//positionManager.middleObject(obj('unlog_loginDIV'),'%',true);
positionManager.centerObject(obj('loginTable'),'%',true);

var animationManager=new AnimationManager();
animationManager.setAnimaTionOpacity(document.body,1,0,'ease',0,1);
animationManager.setAnimationMove(obj('unlog_titleText'),2,1.5,'ease',100,parseInt(obj('unlog_titleText').style.top),parseInt(obj('unlog_titleText').style.left),parseInt(obj('unlog_titleText').style.top),'%');
animationManager.setAnimaTionOpacity(obj('unlog_loginDIV'),3,1,'ease',0,1);
obj('logform_clearBtn').onmouseover=function(){
animationManager.setAnimationScale(obj('logform_clearBtn'),0.7,'ease',0,1,1.3);
}
obj('logform_clearBtn').onmouseout=function(){
animationManager.setAnimationScale(obj('logform_clearBtn'),0.7,'ease',0,1.3,1);
}
obj('logform_submitBtn').onmouseover=function(){
animationManager.setAnimationScale(obj('logform_submitBtn'),0.7,'ease',0,1,1.3);
}
obj('logform_submitBtn').onmouseout=function(){
animationManager.setAnimationScale(obj('logform_submitBtn'),0.7,'ease',0,1.3,1);
}

function loginSubmitRequest(){
if(objv('in_name')!='' && objv('in_pw')!=''){
ajaxt('ser_manager.php?request=accountLogin',{userName:objv('in_name'),userPwd:objv('in_pw')},function(msg){
if(msg=='staff' || msg=='member')location.reload();
else pas('Login Failed.');
});
}
}
</script>

<? } ?>

<script type="text/javascript">
var alertShowTime=2;
popAlert=new PenguinMessagePopBox();
popAlert.setShowAnimationTime(0.5);
function pas(_msg){
popAlert.showWithTime(_msg,1.2);
}
</script>
</body>
</html>