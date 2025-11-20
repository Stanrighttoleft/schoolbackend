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
    case '2':
      //取得購物車資訊
      $query="SELECT * FROM cart,product,product_img WHERE ip='".$_SERVER['REMOTE_ADDR']."'AND orderid IS NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
      $result=$link->query($query);
      if($result){
        $data=$result->fetchAll(PDO::FETCH_CLASS);
        $retcode=array("c"=>"1","m"=>'',"d"=>$data);
      }
      break;
    case '3':
      //將購物車變更數量寫回資料庫
      if(isset($_GET['cartid'])&& isset($_GET['qty'])){
        $cartid=$_GET['cartid'];
        $qty=$_GET['qty'];
        $query=sprintf("UPDATE cart SET qty='%d' WHERE cart.cartid=%d",$qty,$cartid);
        $result=$link->query($query);
        if($result){
          $retcode=array("c"=>"1","m"=>'謝謝您！產品數量已經更新。');
        }
      }
      break;
    case '4':
      if(isset($_GET['cartid'])){
        $cartid=$_GET['cartid'];
        $query=sprintf("DELETE FROM cart WHERE cart.cartid=%d", $cartid );
        $result=$link->query($query);
        if($result){
          $retcode=array("c"=>"1","m"=>"產品已經成功刪除。");
        }
      }
      
  }
  echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;

?>