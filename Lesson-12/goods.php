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
                    <?php //require_once("./goods_content.php"); 
                    ?>
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <?php
                                //取得產品圖片檔名資料
                                $SQLstring = sprintf("SELECT * FROM product_img WHERE product_img.p_id=%d ORDER BY sort", $_GET['p_id']);
                                $img_rs = $link->query($SQLstring);
                                $imgList = $img_rs->fetch();
                                ?>
                                <img id="showGoods" name="showGoods"
                                    src="./product_img/<?php echo $imgList['img_file']; ?>"
                                    class="img-fluid rounded-start"
                                    alt="<?php echo $data['p_name']; ?>"
                                    title="<?php echo $data['p_name']; ?>">

                                <div class="row mt-2">
                                    <?php do { ?>
                                        <div class="col-md-4">
                                            <a href="./product_img/<?php echo $imgList['img_file']; ?>"
                                                rel="group" class="fancybox"
                                                title="<?php echo $data['p_name']; ?>">
                                                <img src="./product_img/<?php echo $imgList['img_file']; ?>"
                                                    class="img-fluid"
                                                    alt="<?php echo $data['p_name']; ?>"
                                                    title="<?php echo $data['p_name']; ?>">
                                            </a>
                                        </div>
                                    <?php } while ($imgList = $img_rs->fetch()); ?>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data['p_name']; ?></h5>
                                    <p class="card-text"><?php echo $data['p_intro']; ?></p>
                                    <h4 class="color_e600a0"><?php echo $data['p_price']; ?></h4>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text color-success" id="inputGroup-sizing-lg">數量</span>
                                                <input type="number" id="qty" name="qty" value="1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button name="button01" id="button01" type="button"
                                                class="btn btn-success btn-lg color-success" onclick="addcart(<?php echo $data['p_id'];?>);">
                                                加入購物車
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $data['p_content']; ?>
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
    <script>
        //將產品p_id加入購物車
        function addcart(p_id){
            var qty=$('#qty').val();
            if(qty<=0){
                alert("產品數量不得為0或為負數，請再次修改數量！");
                return(false);
            }
            if(qty==undefined){
                qty=1;

            }else if(qty>=50){
                alert("由於採購限制，產品數量將限制在50以下！");
                return (false);
            }
            //利用jquery $.ajax函數呼叫後台的addcart.php
            $.ajax({
                url:'addcart.php',
                type:'get',
                dataType:'json',
                data:{p_id: p_id, qty:qty,},
                success:function(data){
                    if(data.c==true){
                        alert(data.m);
                        window.location.reload();
                    }else{
                        alert(data.m);
                    }
                },
                error:function(data){
                    alert("系統目前無法連接到後台資料庫。")
                }
            })
        }
    </script>
</body>

</html>