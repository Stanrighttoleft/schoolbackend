<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-Type: application/json;charset=utf-8'); //return json string

//不分頁的資料查詢，所有資料全部回傳
require_once('conn_db.php');
if (isset($_GET['mode']) && $_GET['mode'] != '') {
    $mode = $_GET['mode'];
    switch ($mode) {
        case 'memberCount':
            $email=$_GET['email'];
            $firstSQL = sprintf("SELECT count(email) as emailCount FROM member WHERE email='%s'",$email);
            break;    
        case 'adGroupData':
            $firstSQL = sprintf("SELECT * FROM ad_group WHERE 1 ORDER BY update_date DESC");
            break;
        case 'adGroupCount':
            $gpname=$_GET['gpname'];
            $firstSQL = sprintf("SELECT count(gpname) as gpNameCount FROM ad_group WHERE gpname='%s'",$gpname);
            break;   
        case 'adUserCount':
            $adlogin=$_GET['adlogin'];
            $firstSQL = sprintf("SELECT count(adlogin) as adLoginCount FROM ad_user WHERE adlogin='%s'",$adlogin);
            break;    
        case 'pyclass01':
            $firstSQL = sprintf("SELECT * FROM pyclass WHERE pyclass.level=1 ORDER BY sort");
            break;
        case 'pyclass02':
            $classid=$_GET['classid'];
            $firstSQL = sprintf("SELECT * FROM pyclass WHERE pyclass.level=2 AND uplink=%d ORDER BY sort",$classid);
            break;
        case 'product':
            $keyWord=$_GET['keyWord'];
            $firstSQL = sprintf("SELECT product.*,product_img.img_file FROM product,product_img WHERE product.p_id=product_img.p_id AND product_img.sort=1 AND (product.p_name LIKE '%s' OR product.p_id LIKE '%s')","%".$keyWord."%","%".$keyWord."%");
            break;    
        case 'product_img':
            $p_id=$_GET['p_id'];
            $firstSQL = sprintf("SELECT product_img.img_file FROM product_img WHERE p_id='%d' ORDER BY sort",$p_id);
            break;    
        case 'CartP_idCount':
            $p_id=$_GET['p_id'];
            $firstSQL = sprintf("SELECT count(p_id) as P_idCount FROM cart WHERE p_id='%d'",$p_id);
            break;    
    }
    // echo "<h1>$firstSQL</h1>";
    $result = $link->query($firstSQL);
    if ($result) {
        //建立回傳陣列
        $retcode = array("code" => "200", "data" => $result->fetchAll(PDO::FETCH_ASSOC), "message" => "success", "status" => "OK");
    } else {
        $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
