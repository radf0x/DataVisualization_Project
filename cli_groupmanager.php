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

td{
color: white;
}
</style>
</head>
<body topmargin="0" leftmarign="0" style="overflow:hidden;background-color:black;">


<div class="subBox" id="manageGroupSubBox" style="">
<center>
<div class="defaultFont1 boxTextWhite" style="font-size:40px;">Manage Group</div>
<br /><br />
<table id="manageGroup_createrGroupTable" width="85%" border="1" bordercolor="white" cellspacing="0" cellpadding="6"></table>
</center>
</div>
<script type="text/javascript">
function refresh_mg_createrGroupTable(){
obj('manageGroup_createrGroupTable').innerHTML='<tr class="tableTrCSS1"><td class="defaultFont1 boxTextWhite" width="30%" align="center" valign="middle">Group ID</td><td width="33%" class="defaultFont1 boxTextWhite" align="center" valign="middle">Members</td><td width="*" class="defaultFont1 boxTextWhite" align="center" valign="middle" colspan="2">Actions</td></tr>';
ajaxj('ser_manager.php?request=selectGroupInfoByCreater',{groupCreater:userId},function(msg){
if(msg){
var gList=[];
for(var i in msg){
var isPush=true;
for(var g in gList){
if(gList[g].groupId==msg[i].groupId){
isPush=false;
gList[g].groupMembers.push(msg[i].memberID);
}
}
if(isPush==true)gList.push({groupId:msg[i].groupId, groupMembers:[msg[i].memberID]});
}
for(var i in gList){
var memList='';
for(var m in gList[i].groupMembers){
memList+=gList[i].groupMembers[m]+'&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:deleteMemberFromGroup('+gList[i].groupMembers[m]+','+gList[i].groupId+');">Delete</a><br />';
}
obj('manageGroup_createrGroupTable').innerHTML=obj('manageGroup_createrGroupTable').innerHTML+'<tr class="tableTrCSS1"><td class="defaultFont1 boxTextWhite" align="center" valign="middle">'+gList[i].groupId+'</td><td class="defaultFont1 boxTextWhite" align="center" valign="middle">'+memList+'</td><td class="defaultFont1 boxTextWhite" align="center" valign="middle"><a href="javascript:deleteGroup('+gList[i].groupId+');">Delete Group</a></td><td class="defaultFont1 boxTextWhite" align="center" valign="middle"><a href="javascript:addMemberToGroup('+gList[i].groupId+');">Add Member</a></td></tr>';
}
parent.updateGroupCount();
}
});
}
refresh_mg_createrGroupTable();
</script>


<div class="subBox" id="addGroupSubBox" style="display:none;">
<center>
<div class="defaultFont1 boxTextWhite" style="font-size:40px;">Add Group</div>
<br />
<div class="defaultFont1 boxTextWhite">
<div id="add_creategdes">To create a new group:</div>
</br/>
Search Member:<input type="text" placeholder="ID or name" onKeyDown="if(event.keyCode==13)add_searchMember(this.value);" onMouseOver="this.focus();" />
<br />
<table id="add_showSearchMemberTable" border="1" cellspacing="0" cellpadding="4" style="border-color:silver;"></table>
</div>
</center>
</div>


<div class="bottomBar">
<table border="0" width="100%" height="100%" cellspacing="0">
<tr>
<td class="bottomBarButton defaultFont1" width="50%" align="center" valign="middle" style="font-size:18px;color:white;" onclick="toSubBox('manageGroupSubBox');">Manage Group</td>
<td class="bottomBarButton defaultFont1" width="50%" align="center" valign="middle" style="font-size:18px;color:white;" onclick="toSubBox('addGroupSubBox');obj('add_creategdes').innerHTML='To create a new group:';">Add Group</td>
</tr>
</table>
</div>


<script type="text/javascript">
var addedMemberToGroupArr=[];
var needAddToGroupId=-1;

var boxesList=[obj('manageGroupSubBox'),obj('addGroupSubBox')]
function toSubBox(_box){
for(var i in boxesList){
obj(_box).style.display='';
if(boxesList[i]!=obj(_box))boxesList[i].style.display='none';
}
}

var an_manager=new AnimationManager();

function deleteMemberFromGroup(_memId,_groupId){
ajaxt('ser_manager.php?request=deleteMemberFromGroup',{memId:_memId,groupId:_groupId},function(msg){
if(msg=='Successful.'){
refresh_mg_createrGroupTable();
}
});
}

function deleteGroup(_groupId){
ajaxt('ser_manager.php?request=deleteGroup',{groupId:_groupId},function(msg){
if(msg=='Successful.'){
refresh_mg_createrGroupTable();
}
});
}

function addMemberToGroup(_groupId){
needAddToGroupId=_groupId;
addedMemberToGroupArr=[];
obj('add_creategdes').innerHTML='To add member to an exist group:';
toSubBox('addGroupSubBox');
parent.pas(_groupId);
}

function addMemberToGroupWithInit(memberId,theObj){
addedMemberToGroupArr.push(memberId);
//alert(JSON.stringify(addedMemberToGroupArr));
}

function reallyaddMemberToGroup(){
if(obj('add_creategdes').innerHTML=='To create a new group:'){
ajaxt('ser_manager.php?request=addMemberToGroupWithInit',{memberIdArray:JSON.stringify(addedMemberToGroupArr)},function(msg){
addedMemberToGroupArr=[];
refresh_mg_createrGroupTable();
parent.pas(msg);
});
}else if(obj('add_creategdes').innerHTML=='To add member to an exist group:'){
ajaxt('ser_manager.php?request=addMemberToGroup',{memberIdArray:JSON.stringify(addedMemberToGroupArr),groupId:needAddToGroupId},function(msg){
addedMemberToGroupArr=[];
refresh_mg_createrGroupTable();
parent.pas(msg);
});
}
}

function add_searchMember(_search){
ajaxj('ser_manager.php?request=searchUserInfoByIdOrName',{userName:_search},function(msg){
//alert(JSON.stringify(msg));
obj('add_showSearchMemberTable').innerHTML='<tr><td align="center" valign="middle">Member</td><td align="center" valign="middle">Action</td></tr>';
if(msg.length>0 && msg){
for(var i in msg){
var tr=document.createElement('tr');
tr.innerHTML='<td align="center" valign="middle">'+msg[i].userName+'</td><td align="center" valign="middle"><a href="javascript:addMemberToGroupWithInit('+msg[i].userId+');">Add To Group</a></td>';
obj('add_showSearchMemberTable').appendChild(tr);
}
obj('add_showSearchMemberTable').innerHTML+='<td align="center" valign="middle" colspan="2"><input type="button" value="Submit" onClick="reallyaddMemberToGroup();" /></td>';
}
});
}

</script>
</body>
</html>