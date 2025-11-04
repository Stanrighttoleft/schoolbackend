<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json;charset=utf-8');

require_once('Connections/conn_db.php');
if(isset($_GET['p_id']) && isset($_GET['qty'])){
    $p_id=$_GET['p_id'];//取得產品編號
    $qty=$_GET['qty'];//取得產品數量
    $u_ip=$_SERVER['REMOTE_ADDR'];//從伺服器取得使用者ip
    //查詢是否有相同的產品編號
    $query="SELECT * FROM cart WHERE p_id=".$p_id." AND ip='". $_SERVER['REMOTE_ADDR']."'AND orderid IS NULL";
    $result=$link->query($query);
    if($result){
        if($result->rowCount()==0){
            //若無相同產品編號，請直接新增商品標號和數量加入購物車
            $query="INSERT INTO cart (p_id, qty, ip) VALUES (".$p_id.",".$qty.",'".$u_ip."');";
        }else{
            $cart_data=$result->fetch();
            if($cart_data['qty']+$qty>49){
                $qty=49; //設定產品數量上限49件
            }else{
                $qty=$qty+$cart_data['qty'];
            }
            $query="UPDATE cart SET qty='".$qty."' WHERE cart.cartid=".$cart_data['cartid'];
        }
        $result=$link->query($query);
        $retcode=array("c"=>"1","m" =>'謝謝您!產品已加入購物車中。');
    }else{
        $retcode=array("c"=>"0","m" =>'抱歉！資料無法寫入後台資料庫，請聯絡管理人員。');
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
?>