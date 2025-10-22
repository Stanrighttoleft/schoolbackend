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
                    <!-- 引入廣告輪播模組 -->
                     <?php require_once("carousel.php"); ?>
                    <hr>
                    <!-- 引入product藥妝商品模組 -->
                     <?php require_once("product_list.php"); ?>
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
