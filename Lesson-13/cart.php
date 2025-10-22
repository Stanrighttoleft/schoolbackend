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
                    <!-- 購物車內容模組 -->
                     <?php //require_once("cart_content.php"); ?>

                    <?php
                    //建立購物車資料查詢
                    $SQLstring="SELECT * FROM cart, product, product_img WHERE ip='".$_SERVER['REMOTE_ADDR']."' AND orderid IS NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
                    $cart_rs=$link->query($SQLstring);
                    $ptotal=0;//設定累加變數，初始=0

                    ?>

                     <h3>電傷藥妝：購物車</h3>
                     <button id="btn01" name="btn01" class="btn btn-primary">繼續購物</button>
                     <button id="btn02" name="btn02" class="btn btn-info">回上一頁</button>
                     <button id="btn03" name="btn03" class="btn btn-success">清空購物車</button>
                     <button id="btn04" name="btn04" class="btn btn-warning">前往結帳</button>
                     <!-- 響應式table物件 -->
                    <div class="table-responsive-md">
                        <table class="table table-hover mt-3">
                            <thead>
                                <tr class="table-warning">
                                    <td width="10%">產品編號</td>
                                    <td width="10%">圖片</td>
                                    <td width="25%">名稱</td>
                                    <td width="15%">價格</td>
                                    <td width="10%">數量</td>
                                    <td width="15%">小計</td>
                                    <td width="15%">下次再買</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($cart_data=$cart_rs->fetch()){ ?>
                                <tr>
                                    <td><?php echo $cart_data['p_id']; ?></td>
                                    <td><img src="product_img/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"></td>
                                    <td><?php echo $cart_data['p_name']; ?></td>
                                    <td><h4 class="color_e600a0 pt-1"><?php echo $cart_data['p_price']; ?></h4></td>
                                    <td style="min-width:100px">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="qty[]" name="qty[]" value="<?php echo $cart_data['qty']; ?>" min="1" max="49" cartid="<?php echo $cart_data['cartid']; ?>" required>
                                        </div>
                                    </td>
                                    <td><?php echo $cart_data['p_price'] * $cart_data['qty']; ?></td>
                                    <td><button type="button" id="btn[]" name="btn[]" class="btn btn-danger" onclick="btn_confirmLink('確定刪除本資料?','shopcart_del.php?mode=1&cartid=<?php echo $cart_data['cartid']; ?>');">取消</button></td>
                                </tr>
                                    <?php $ptotal+=$cart_data['p_price']* $cart_data['qty']; } ?>
                                <tr>
                                    
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">累計：<?php echo $ptotal; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="7">運費：100</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="color_red">總計：<?php echo $ptotal+100; ?></td>
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
            <script>
                //跳出確定訊對話框
                function btn_confirmLink(message,url){
                    if(message=="" || url=="" ){
                        return false;
                    }
                    if(confirm(message)){
                        window.location=url;
                    }
                    return false;
                }
            </script>
</body>
</html>
