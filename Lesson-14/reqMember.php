<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8');

require_once('Connections/conn_db.php');
if(isset($_GET['emailid']) && $_GET['emailid']!=''){
  $emailid=$_GET['emailid'];
  $birthday=$_GET['birthday'];
  $cname=$_GET['cname'];
  $imgname=$_GET['imgname'];
  $tssn=$_GET['tssn'];
  $query=sprintf("UPDATE member SET cname='%s', birthday='%s',imgname='%s', tssn='%s' WHERE member.emailid='%d'",$cname,$birthday,$imgname,$tssn, $emailid);
  $result=$link->query($query);
  if($result){
    (!isset($_SESSION)) ? session_start() :"";
    $_SESSION['cname']=$cname;
    $_SESSION['imgname']=$imgname;
    $retcode=array("c"=>"1","m"=>'謝謝您！會員資料已經更新。');

  }else{
    $retcode=array("c"=>"0","m"=>"抱歉！資料無法寫入後台資料庫，請聯絡管理人員");
  }
  echo json_encode($retcode,JSON_UNESCAPED_UNICODE);
}

?>