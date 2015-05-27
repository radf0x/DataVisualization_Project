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
$result2 = $result->fetchAll();
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
$isStaff='false';
$rs=$db->query($sql);
$col=$rs->fetchColumn();
$db=null;
return $col;
}


if($_GET[request]=='sendMsg'){
$result=getResultWithSQL("INSERT INTO chatroom (msgSender, msgContent, msgSentDT) VALUES($_SESSION[userId], '$_POST[msgContent]', NOW());");
$msgId=getColumnWithSQL("SELECT max(msgId) FROM chatroom;");
echo "{state:'".$result."', msgId:".$msgId."}";
}
elseif($_GET[request]=='receiveMsg'){
echo json_encode(getRowsFromDB("SELECT msgId, msgSender, msgContent, msgSentDT FROM chatroom;",true));
}
elseif($_GET[request]=='getUID'){
echo $_SESSION[userId];
}

?>