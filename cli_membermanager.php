<?
ob_start();
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SE</title>
<link rel="stylesheet" href="settings.css"></link>
<script type="text/javascript" src="requiredapi.js"></script>
<script type="text/javascript">
var userId=<? echo $_SESSION[userId]; ?>;
var an_manager=new AnimationManager();
</script>
<style>
.subBox{
position: absolute;
width: 100%;
height: 97%;
overflow: auto;
top: 0%;
left: 0%;
}

.bottomBar{
position: fixed;
bottom: 0px;
left: 0px;
width: 100%;
height: 13%;
}

a:link{
color: white;
text-decoration: none;
}
a:visited{
color: white;
text-decoration: none;
}
a:hover{
color: white;
text-decoration: none;
}

#showmoretable{
border-style: dashed;
border-width: 1px;
border-color: white;
}
.shmttd{
border-right-style: dashed;
border-right-width: 1px;
border-right-color: white;
border-bottom-style: dashed;
border-bottom-width: 1px;
border-bottom-color: white;
}

td{
color:white;
font-family:'HelveticaNeue-UltraLight',Helvetica,Arial,sans-serif;
}
</style>
</head>
<body topmargin="0" leftmarign="0" style="overflow:hidden;background-color:black;">


<div class="subBox" id="manageMemberSubBox" style="">
<center>
<div class="defaultFont1 boxTextWhite" style="font-size:40px;">Manage Member</div>
<br /><br />
<table id="manageGroup_showMemberTable" width="85%" border="1" bordercolor="white" cellspacing="0" cellpadding="6"></table>
</center>
</div>
<div class="subBox" id="shdetailMemberSubBox" style="background-color:black;display:none;">
&nbsp;<a class="defaultFont1" href="javascript:unviewMember();">Back</a>
<br /><br />
<center>
<div class="defaultFont4" style="color:white;font-size:40px;">More detail:</div>
<table id="showmoretable" border="1" cellspacing="0" border="white" width="75%" cellpadding="6"></table>
<input id="toEditMemBtn" type="button" value="Edit" />
<br /><br /><br /><br />
</center>
</div>
<div class="subBox" id="editMemberSubBox" style="background-color:black;display:none;overflow:auto;">
&nbsp;<a class="defaultFont1" href="javascript:editMemberSubBox.style.display='none';unviewMember();refresh_mg_createrGroupTable();">Back</a>
<br /><br />
<center>
<div class="defaultFont4" style="color:white;font-size:40px;">Edit Member:</div>
<table id="showedittable" border="1" cellspacing="0" border="white" width="75%" cellpadding="6">
<tr class="tableTrCSS1"><td width="30%" align="right">ID:</td><td id="editmem_userId" width="*"></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Name:</td><td width="*"><input id="editmem_userName" type="text" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">First Name:</td><td width="*"><input id="editmem_userFName" type="text" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Last Name:</td><td width="*"><input id="editmem_userLName" type="text" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Weight:</td><td width="*"><input id="editmem_userWeight" type="number" min="0" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Height:</td><td width="*"><input id="editmem_userHeight" type="number" min="0" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Register Date:</td><td width="*"><input id="editmem_userRegDT" type="text" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Role:</td><td width="*"><input id="editmem_userRole" type="text" onMouseOver="this.focus();" required /></td></tr>
</table>
<input type="button" value="Edit" onClick="updateMember();" />
<br /><br /><br /><br />
</center>
</div>

<script type="text/javascript">
var receivedMsg=null;

function refresh_mg_createrGroupTable(){
obj('manageGroup_showMemberTable').innerHTML='<tr class="tableTrCSS1"><td class="defaultFont1 boxTextWhite" width="30%" align="center" valign="middle">Member Name</td><td width="33%" class="defaultFont1 boxTextWhite" align="center" valign="middle">Member Role</td><td width="*" class="defaultFont1 boxTextWhite" align="center" valign="middle">Actions</td></tr>';
ajaxj('ser_manager.php?request=selectUserInfo',{allow:'true'},function(msg){
if(msg){
receivedMsg=msg;
for(var i in msg){
obj('manageGroup_showMemberTable').innerHTML=obj('manageGroup_showMemberTable').innerHTML+'<tr class="tableTrCSS1"><td class="defaultFont1 boxTextWhite" width="30%" align="center" valign="middle">'+msg[i].userName+'</td><td width="33%" class="defaultFont1 boxTextWhite" align="center" valign="middle">'+msg[i].userRole+'</td><td width="*" class="defaultFont1 boxTextWhite" align="center" valign="middle"><a href="javascript:viewMember('+msg[i].userId+');">View More</a></td></tr>';
}
parent.updateUserCount();
}
});
}
refresh_mg_createrGroupTable();
</script>


<div class="subBox" id="addMemberSubBox" style="display:none;">
<center>
<div class="defaultFont1 boxTextWhite" style="font-size:40px;">Add Member</div>
<br /><br />
<form onSubmit="insertMember();return false;">
<table id="showaddtable" border="1" cellspacing="0" border="white" width="75%" cellpadding="6">
<tr class="tableTrCSS1"><td width="30%" align="right">Name:</td><td width="*"><input id="addmem_userName" type="text" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">First Name:</td><td width="*"><input id="addmem_userFName" type="text" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Last Name:</td><td width="*"><input id="addmem_userLName" type="text" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Weight:</td><td width="*"><input id="addmem_userWeight" type="number" min="0" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Height:</td><td width="*"><input id="addmem_userHeight" type="number" min="0" onMouseOver="this.focus();" required /></td></tr>
<tr class="tableTrCSS1"><td width="30%" align="right">Role:</td><td width="*"><input id="addmem_userRole" type="text" onMouseOver="this.focus();" required /></td></tr>
</table>
<input type="submit" />
</form>
<br /><br /><br /><br />
</center>
</div>
<script type="text/javascript">
function insertMember(){
ajaxt('ser_manager.php?request=insertUser',{userName:objv('addmem_userName'),userPwd:12345,userFName:objv('addmem_userFName'),userLName:objv('addmem_userLName'),userWeight:objv('addmem_userWeight'),userHeight:objv('addmem_userHeight'),userRole:objv('addmem_userRole')},function(msg){
parent.pas(msg);
toSubBox('manageMemberSubBox');
refresh_mg_createrGroupTable();
});
}
</script>


<div class="bottomBar">
<table border="0" width="100%" height="100%" cellspacing="0">
<tr>
<td class="bottomBarButton defaultFont1" id="bottomBarButton_1" width="50%" align="center" valign="middle" style="font-size:18px;color:white;" onclick="toSubBox('manageMemberSubBox');">Manage Member</td>
<td class="bottomBarButton defaultFont1" id="bottomBarButton_2" width="50%" align="center" valign="middle" style="font-size:18px;color:white;" onclick="toSubBox('addMemberSubBox');">Add Member</td>
</tr>
</table>
</div>


<script type="text/javascript">

var boxesList=[obj('manageMemberSubBox'),obj('addMemberSubBox')]
function toSubBox(_box){
for(var i in boxesList){
obj(_box).style.display='';
if(boxesList[i]!=obj(_box))boxesList[i].style.display='none';
}
}

function viewMember(_userId){
shdetailMemberSubBox.style.display='';
an_manager.setAnimaTionOpacity(shdetailMemberSubBox,1,0,'ease',0,1);
refreshshowmoretable(_userId);
}

function unviewMember(){
an_manager.setAnimaTionOpacity(shdetailMemberSubBox,1,0,'ease',1,0);
setTimeout("shdetailMemberSubBox.style.display='none';",1000);
}

function refreshshowmoretable(_userId){
for(var i in receivedMsg){
if(receivedMsg[i].userId==_userId){
var tr_id='<tr class="tableTrCSS1"><td width="30%" align="right">ID:</td><td width="*">'+receivedMsg[i].userId+'</td></tr>';
var tr_name='<tr class="tableTrCSS1"><td width="30%" align="right">Name:</td><td width="*">'+receivedMsg[i].userName+'</td></tr>';
var tr_fName='<tr class="tableTrCSS1"><td width="30%" align="right">First Name:</td><td width="*">'+receivedMsg[i].userFName+'</td></tr>';
var tr_lName='<tr class="tableTrCSS1"><td width="30%" align="right">Last Name:</td><td width="*">'+receivedMsg[i].userLName+'</td></tr>';
var tr_weight='<tr class="tableTrCSS1"><td width="30%" align="right">Weight:</td><td width="*">'+receivedMsg[i].userWeight+'</td></tr>';
var tr_height='<tr class="tableTrCSS1"><td width="30%" align="right">Height:</td><td width="*">'+receivedMsg[i].userHeight+'</td></tr>';
var tr_regDT='<tr class="tableTrCSS1"><td width="30%" align="right">Register Date:</td><td width="*">'+receivedMsg[i].userRegDT+'</td></tr>';
var tr_role='<tr class="tableTrCSS1"><td width="30%" align="right">Role:</td><td width="*">'+receivedMsg[i].userRole+'</td></tr>';
obj('showmoretable').innerHTML=tr_id+tr_name+tr_fName+tr_lName+tr_weight+tr_height+tr_regDT+tr_role;
obj('toEditMemBtn').onclick=function(){
refreshshowedittable(_userId);
}
}
}
}

function refreshshowedittable(_userId){
for(var i in receivedMsg){
if(receivedMsg[i].userId==_userId){
obj('editMemberSubBox').style.display='';
obj('editmem_userId').innerHTML=receivedMsg[i].userId;
obj('editmem_userName').value=receivedMsg[i].userName;
obj('editmem_userFName').value=receivedMsg[i].userFName;
obj('editmem_userLName').value=receivedMsg[i].userLName;
obj('editmem_userWeight').value=receivedMsg[i].userWeight;
obj('editmem_userHeight').value=receivedMsg[i].userHeight;
obj('editmem_userRegDT').value=receivedMsg[i].userRegDT;
obj('editmem_userRole').value=receivedMsg[i].userRole;
}
}
}

function updateMember(){
ajaxt('ser_manager.php?request=updateUser',{userId:obj('editmem_userId').innerHTML,userName:objv('editmem_userName'),userFName:objv('editmem_userFName'),userLName:objv('editmem_userLName'),userWeight:objv('editmem_userWeight'),userHeight:objv('editmem_userHeight'),userRegDT:objv('editmem_userRegDT'),userRole:objv('editmem_userRole')},function(msg){
parent.pas(msg);
});
}

</script>
</body>
</html>