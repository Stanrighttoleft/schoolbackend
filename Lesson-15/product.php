<?php 
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8'); //return json string

require_once('./Connections/conn_db.php');
$retcode=array("c"=>"0","m"=>"抱歉！資料無法寫入後台資料庫，請聯絡管理人員。");
if(isset($_GET['mode'])){
  switch($_GET['mode']){
    case '1':
      $query="SELECT *, product_img.img_file FROM product,product_img WHERE product.p_id=product_img.p_id AND product_img.sort=1 LIMIT 0,12";
      $result=$link->query($query);
      if($result){
        $data=$result->fetchAll();
        $retcode=array("c"=>"1","m"=>'',"d"=>$data);
      }
      break;
  }
  echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;

?>