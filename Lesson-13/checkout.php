<?php 
// If session not start then start
(!isset($_SESSION))? session_start():"";
?>
<?php 
//bring in the connection file to connect to database
require_once('./Connections/conn_db.php');
?>
<?php require_once("php_lib.php");?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <!-- 引入網頁標頭 -->
     <?php require_once("headfile.php")?>
</head>
<body>
    <section id="header">
        <?php require_once("navbar.php"); ?>
    </section>
    <section id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <!-- 引入sidebar分類導覽 -->
                    <?php require_once("sidebar.php"); ?>
                    <!-- 引入熱銷商品模組 -->
                    <?php require_once("hot.php"); ?>
                </div>
                <div class="col-md-10">
                    <!-- 引入結帳模組 -->
                    <?php //require_once("checkout.php") ?>
<h3>電商藥妝：會員結帳系統</h3>
<!-- 收件人跟寄件人資訊 -->
<div class="row">
    <div class="card col" >
        <div class="card-header" style="color:#007bff;">
        <i class="fas fa-truck fa-flip-horizontal me-1"></i>配送資訊
        </div>
    <div class="card-body">
        <h5 class="card-title">收件人資訊：</h5>
        <h5 class="card-title">姓名：李小明</h5>
        <p class="card-text">電話：</p>
        <p class="card-text">地址：</p>
        <p class="card-text">郵遞區號：</p>
        <a href="#" class="btn btn-primary">選擇其他收件人</a>
    </div>
    </div>
    <div class="card col ms-3">
        <div class="card-header" style="color:#000;"><i class="fas fa-credit-card me-1">配送資訊</i> 
        </div>
        <div class="card-body">
            <h5 class="card-title">收件人資訊：</h5>
            <h5 class="card-title">姓名：李小明</h5>
            <p class="card-text">電話：</p>
            <p class="card-text">郵遞區號：</p>
            <p class="card-text">地址：</p>
            <a href="#" class="btn btn-primary">選擇其他收件人</a>
        </div>
    </div>
</div>

<div class="table-responsive-md mt-3">
  <table class="table">
    <thead>
        <tr class="text-bg-primary">
            <td width="10%">產品編號</td>
            <td width="10%">圖片</td>
            <td width="30%">名稱</td>
            <td width="15%">價格</td>
            <td width="15%">數量</td>
            <td width="20%">小計</td>
        </tr>
    </thead>
    <tbody>
        <tr class="">
            <td>1</td>
            <td><img src="product_img/zoom-front-174388.webp" alt="" class="img-fluid"> </td>
            <td>Maybelline</td>
            <td>
                <h4 class="color_e600a0 pt-1">$999</h4>
            </td>
            <td>10</td>
            <td>
                <h4 class="color_e600a0 pt-1">$999</h4>
            </td>
        </tr>
        <tr class="">
            <td>2</td>
            <td><img src="product_img/zoom-front-174388.webp" alt="" class="img-fluid"> </td>
            <td>Maybelline</td>
            <td>
                <h4 class="color_e600a0 pt-1">$999</h4>
            </td>
            <td>10</td>
            <td>
                <h4 class="color_e600a0 pt-1">$999</h4>
            </td>
        </tr>
        
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">累計：</td>
        </tr>
        <tr>
            <td colspan="7">運費：100</td>
        </tr>
        <tr>
            <td colspan="7" class="color_red">總計：</td>
        </tr>
        <tr>
            <td colspan="7"><button id="btn04" name="btn04" class="btn btn-danger"><i class="fas fa-cart-arrow-down pr-2"></i>確認結帳</button></td>
        </tr>
    </tfoot>
  </table>
</div>


                    
                </div>
            </div>
        </div>
    </section>
    <section id="scontent">
        <!-- 引入scontent服務說明模組 -->
            <?php require_once("scontent.php"); ?>
    </section>
    <section id="footer">
        <!-- 引入聯絡資訊人模組 -->
            <?php require_once("footer.php"); ?>
    </section>
        <!-- 引入javascrpt黨 -->
            <?php require_once("jsfile.php"); ?>
</body>
</html>
