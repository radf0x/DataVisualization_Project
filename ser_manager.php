<?
ob_start();
session_start();
$dsn="mysql:host=localhost;dbname=seprj";
$db=new PDO($dsn, 'root', 'root');
$db->query("set character set 'utf8'");
$db->query('set names utf8;');


function getRowsFromDB($sql,$isMultiRows){
$arr=array();
$db=$GLOBALS['db'];
$result=$db->query($sql);
$result2 = $result->fetchAll(PDO::FETCH_ASSOC);
$db=null;
if($isMultiRows==false)return $result2[0];
return $result2;
}
function getResultWithSQL($sql){
if($GLOBALS['db']->exec($sql)==1)return 'Successful.';
return 'Failed.';
}
function getColumnWithSQL($sql){
$db=$GLOBALS['db'];
$rs=$db->query($sql);
$col=$rs->fetchColumn();
$db=null;
return $col;
}





$isStaff=false;
function getIsStaff($userId){
$col=getColumnWithSQL("SELECT count(*) FROM users WHERE userId=$userId AND userRole='staff';");
if($col==1)$isStaff='true';
return $isStaff;
}
function accountLogin($userName,$userPwd){
$result=getRowsFromDB("SELECT userId,userRole FROM users WHERE userName='$userName' AND userPwd='$userPwd';",false);
if($result){
$_SESSION[userId]=$result['userId'];
$_SESSION[userRole]=$result['userRole'];
return $result['userRole'];
}
return 'Failed.';
}
function accountLogout(){
if($_SESSION[userId])session_unset(userId);
}
function selectUserInfoById($userId){
return getRowsFromDB("SELECT userId,userName,userFName,userLName,userWeight,userHeight,userRegDT,userRole FROM users WHERE userId=$userId;",false);
}
function selectUserInfo(){
return getRowsFromDB("SELECT userId,userName,userFName,userLName,userWeight,userHeight,userRegDT,userRole FROM users;",true);
}
function searchUserInfoByIdOrName($userName){
return getRowsFromDB("SELECT userId,userName,userFName,userLName FROM users WHERE userId='$userName' OR userName LIKE '%".$userName."%' OR userFName LIKE '%".$userName."%' OR userLName LIKE '%".$userName."%';",true);
}
function insertUser($userName,$userPwd,$userFName,$userLName,$userWeight,$userHeight,$userRole){
return getResultWithSQL("INSERT INTO users (userName,userPwd,userFName,userLName,userWeight,userHeight,userRegDT,userRole) VALUES('$userName','$userPwd','$userFName','$userLName','$userWeight','$userHeight',now(),'$userRole');");
}
function updateUser($userId,$userName,$userFName,$userLName,$userWeight,$userHeight,$userRole){
return getResultWithSQL("UPDATE users SET userName='$userName', userFName='$userFName', userLName='$userLName', userWeight='$userWeight', userHeight='$userHeight', userRole='$userRole' WHERE userId=$userId;");
}
function updateUserPwd($userId,$userPwd){
return getResultWithSQL("UPDATE users SET userPwd='$userPwd' WHERE userId=$userId;");
}
function deleteUser($userId){
return getResultWithSQL("DELETE FROM users WHERE userId=$userId;");
}
function getUserCount(){
return getColumnWithSQL("SELECT COUNT(*) FROM users;");
}
function getGroupCount(){
return getColumnWithSQL("SELECT COUNT(*) FROM groupInfo;");
}





function selectGroupInfoBase($sql){
return getRowsFromDB("SELECT groupId,groupDT,groupCreater FROM groupInfo".$sql.";",true);
}
function selectGroupInfo(){
return selectGroupInfoBase('');
}
function selectGroupInfoById($groupId){
$result=selectGroupInfoBase(' WHERE groupId='.$groupId);
return $result[0];
}
function selectGroupInfoByCreater($groupCreater){
return getRowsFromDB('SELECT gi.groupId, gi.groupDT, gi.groupCreater, gm.memberID FROM groupInfo gi, groupmember gm WHERE groupCreater='.$groupCreater.' AND gm.groupID=gi.groupID;',true);
}
function deleteMemberFromGroup($memberId,$groupId){
return getResultWithSQL("DELETE FROM groupmember WHERE memberId=$memberId;");
}
function deleteGroup($groupId){
$r1=getResultWithSQL("DELETE FROM groupInfo WHERE groupId=$groupId;");
$r2=getResultWithSQL("DELETE FROM groupmember WHERE groupId=$groupId;");
return 'Successful.';
}
function addMemberToGroup($memberIDArray,$groupId){
$arr=json_decode($memberIDArray);
//return $arr[0].'  '.$groupId;
$addmembertogroupsql='';
foreach($arr as $memid){
$addmembertogroupsql=$addmembertogroupsql."INSERT INTO groupmember (memberID,groupID) VALUES($memid,$groupId);";
}
return getResultWithSQL($addmembertogroupsql);
}
function addMemberToGroupWithInit($memberIDArray){
$db=$GLOBALS['db'];
$result='';
$insertgroupsql="INSERT INTO groupInfo (groupDT,groupCreater) VALUES(NOW(),$_SESSION[userId]);";
if($db->exec($insertgroupsql)==1){
$result=$result.' $insertgroupsql succ.';
$groupId=getColumnWithSQL("SELECT groupId FROM groupInfo ORDER BY groupId DESC LIMIT 0,1;");
$arr=json_decode($memberIDArray);
foreach($arr as $memid){
$addmembertogroupsql=$addmembertogroupsql."INSERT INTO groupmember (memberID,groupID) VALUES($memid,$groupId);";
$result=$result.' '.$addmembertogroupsql;
}
if($db->exec($addmembertogroupsql)==1){
$result=$result.' $addmembertogroupsql succ.';
return 'Successful.';
}
}
return $result.' Failed.';
}





function insertGoal($userId,$startDate,$endDate,$action){
return getResultWithSQL("INSERT INTO goal (userId,startDate,endDate,action) VALUES($userId,'$startDate','$endDate','$action');");
}
function selectGoalByUserId($userId){
return getRowsFromDB("SELECT goalId,startDate,endDate,action,userId FROM goal WHERE userId=$userId and endDate >= now() order by goalId desc;",true);
}
function selectGoalByGoalId($goalId){
return getRowsFromDB("SELECT goalId,startDate,endDate,action,userId FROM goal WHERE goalId=$goalId;",false);
}
function deleteGoal($goalId){
return getResultWithSQL("DELETE FROM goal WHERE goalId=$goalId;");
}








$req=$_GET;
$preq=$req[request];
$post=$_POST;
if($preq=='selectUserInfoById')echo json_encode(selectUserInfoById($post[userId]));
elseif($preq=='selectUserInfo')echo json_encode(selectUserInfo());
elseif($preq=='searchUserInfoByIdOrName')echo json_encode(searchUserInfoByIdOrName($post[userName]));
elseif($preq=='insertUser')echo insertUser($post[userName],$post[userPwd],$post[userFName],$post[userLName],$post[userWeight],$post[userHeight],$post[userRole]);
elseif($preq=='updateUser')echo updateUser($post[userId],$post[userName],$post[userFName],$post[userLName],$post[userWeight],$post[userHeight],$post[userRole]);
elseif($preq=='updateUserPwd')echo updateUserPwd($post[userId],$post[userPwd]);
elseif($preq=='deleteUser')echo deleteUser($post[userId]);
elseif($preq=='accountLogin')echo accountLogin($post[userName],$post[userPwd]);
elseif($preq=='accountLogout'){if($_SESSION[userId])session_unset(userId);echo 'Successful.';}
elseif($preq=='getUserCount')echo getUserCount();
elseif($preq=='getGroupCount')echo getGroupCount();


elseif($preq=='selectGroupInfo')echo json_encode(selectGroupInfo());
elseif($preq=='selectGroupInfoById')echo json_encode(selectGroupInfoById($post[groupId]));
elseif($preq=='selectGroupInfoByCreater')echo json_encode(selectGroupInfoByCreater($post[groupCreater]));
elseif($preq=='deleteMemberFromGroup')echo deleteMemberFromGroup($post[memId],$post[groupId]);
elseif($preq=='deleteGroup')echo deleteGroup($post[groupId]);
elseif($preq=='addMemberToGroupWithInit')echo addMemberToGroupWithInit($post[memberIdArray]);
elseif($preq=='addMemberToGroup')echo addMemberToGroup($post[memberIdArray],$post[groupId]);


elseif($preq=='insertGoal')echo insertGoal($_SESSION[userId],$post[startDate],$post[endDate],$post[action]);
elseif($preq=='selectGoalByUserId')echo json_encode(selectGoalByUserId($post[userId]));
elseif($preq=='selectGoalByGoalId')echo json_encode(selectGoalByGoalId($post[goalId]));
elseif($preq=='deleteGoal')echo deleteGoal($post[goalId]);

?>