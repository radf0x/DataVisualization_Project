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
td{
color:white;
}
</style>
</head>
<body topmargin="0" leftmarign="0" style="overflow:hidden;background-color:black;">

<center>
<div class="defaultFont1 boxTextWhite" style="font-size:40px;">Change Password</div>
<br /><br />
<form onSubmit="submitForm();return false;">
<table>
<tr><td align="right">New Password:</td><td><input id="p1" type="password" required /></td></tr>
<tr><td align="right">New Password (Again):</td><td><input id="p2" type="password" required /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" /></td></tr>
</table>
</form>
</center>
<script type="text/javascript">
function submitForm(){
if(obj('p1').value==obj('p2').value){
ajaxt('ser_manager.php?request=updateUserPwd',{userId:userId,userPwd:obj('p1').value},function(msg){
parent.pas(msg);
});
}else parent.pas('Passwords must be same!');
}
</script>
</body>
</html>