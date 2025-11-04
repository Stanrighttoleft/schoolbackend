<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<!-- 檢查SESSION是否存在，若不存在則啟動SESSION -->

<?php require_once('Connections/./conn_db.php'); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<!-- 載入共用PHP函數庫 -->
<?php require_once('./php_lib.php'); ?>
<!doctype html>
<html lang="en">

<head>
    <!--引入網頁標頭-->
    <?php require_once("./headfile.php"); ?>
    <link href="./fancybox-2.1.7/source/jquery.fancybox.css">
</head>

<body>
    <section id="header">
        <!--引入導覽列-->
        <?php require_once("./navbar.php"); ?>
    </section>
    <section id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <!--引入sidebar分類導覽-->
                    <?php require_once("./sidebar.php"); ?>
                    <!--引入熱銷商品模組-->
                    <?php require_once("./hot.php"); ?>
                </div>
                <div class="col-md-10">
                    <!--建立類別分項-->
                    <?php require_once("./breadcrumb.php"); ?>
                    <!--引入產品詳細資訊模組-->
                    <?php require_once("./goods_content.php"); 
                    ?>
                   
                </div>
            </div>
        </div>
    </section>
    <hr>
    <section id="scontent">
        <!--服務說明-->
        <?php require_once("./scontent.php"); ?>
    </section>
    <section id="footer">
        <!--聯絡資訊-->
        <?php require_once("./footer.php"); ?>
    </section>

    <!--引入js檔-->
    <?php require_once("./jsfile.php"); ?>
    <script src="./fancybox-2.1.7/source/jquery.fancybox.js"></script>
    <script>
        $(function(){
            //定義滑鼠滑過圖片時，將檔名田入主圖的src中
            $(".card .row.mt-2 .col-md-4 a").mouseover(function(){
                var imgsrc=$(this).children("img").attr("src");
                $("showGoods").attr({"src":imgsrc});
            });
            //將子圖片放到lightbox展示
            $(".fancybox").fancybox();
        })
    </script>
  
    
</body>

</html>