<?php 
// If session not start then start
(!isset($_SESSION))? session_start():"";
?>
<?php 
//bring in the connection file to connect to database
require_once('./Connections/conn_db.php');
?>
<?php require_once("php_lib.php");?>

<!-- force the user to logout and back to login page -->
<?php
if(!isset($_SESSION['login'])){
    $sPath="login.php?sPath=checkout";
    header(sprintf("location:%s",$sPath));
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <!-- 引入網頁標頭 -->
     <?php require_once("headfile.php")?>
</head>
<style>
    .table td,.table th{
        padding: 0.75rem;
        vertical-align: top;
        border-bottom: none;
        border-top: 1px solid #dee2e6;
    }
</style>
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

<!-- 取得收件人地址資訊 -->
<?php
$SQLstring=sprintf("SELECT * ,city.Name AS ctName, town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND setdefault='1' AND addbook.myZip=town.Post AND town.AutoNo=city.AutoNo", $_SESSION['emailid']);
$addbook_rs=$link->query($SQLstring);
if($addbook_rs && $addbook_rs->rowCount() !=0){
    $data=$addbook_rs->fetch();
    $cname=$data['cname'];
    $mobile=$data['mobile'];
    $myzip=$data['myZip'];
    $address=$data['address'];
    $ctName=$data['ctName'];
    $toName=$data['toName'];
}else{
    $cname="";
    $mobile="";
    $myzip="";
    $address="";
    $ctName="";
    $toName="";
}
?>


<h3>電商藥妝：會員：<?php echo $_SESSION['cname']; ?>結帳系統</h3>
<!-- 收件人跟寄件人資訊 -->
<div class="row">
    <div class="card col" >
        <div class="card-header" style="color:#007bff;">
        <i class="fas fa-truck fa-flip-horizontal me-1"></i>配送資訊
        </div>
    <div class="card-body">
        <h5 class="card-title">收件人資訊：</h5>
        <h5 class="card-title">姓名：<?php echo $cname; ?></h5>
        <p class="card-text">電話：<?php echo $mobile; ?></p>
        <p class="card-text">地址：<?php echo $myzip . $ctName . $toName; ?></p>
        <p class="card-text">郵遞區號：<?php echo $address; ?></p>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">選擇其他收件人</a>
    </div>
    </div>
    <div class="card col ms-3">
        <div class="card-header" style="color:#000;"><i class="fas fa-credit-card me-1">配送資訊</i> 
        </div>
        <div class="card-body">
<!-- bootstrap nav and tab component -->

<ul class="nav nav-tabs ms-3">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true" style="color:#007bff !important; font-size:14pt;">貨到付款</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" style="color:#007bff !important; font-size:14pt;" aria-selected="false" >信用卡</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false"  style="color:#007bff !important; font-size:14pt;">銀行轉帳</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="epay-tab" data-bs-toggle="tab" data-bs-target="#epay" type="button" role="tab" aria-controls="epay" aria-selected="false"  style="color:#007bff !important; font-size:14pt;">電子支付</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active ps-2" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
    <h4 class="card-title pt-3" >收件人資訊：</h4>
    <h5 class="card-title">姓名：<?php echo $cname; ?></h5>
    <p class="card-text">電話：<?php echo $mobile; ?></p>
    <p class="card-text">郵遞區號：<?php echo $myzip . $ctName. $toName; ?></p>
    <p class="card-text">地址：<?php echo $address; ?></p>
  </div>
  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
    <!-- credit card information -->
<table class="table caption-top">
    <caption>選擇付款帳號</caption>
  <thead>
    <tr>
      <th scope="col" width="5%">#</th>
      <th scope="col" width="35%">信用卡系統</th>
      <th scope="col" width="30%">發卡銀行</th>
      <th scope="col" width="30%">信用卡卡號</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><input type="radio" name="creditCard" id="creditCard[]" checked></th>
      <td><img src="./images/Visa_Inc._logo.svg" alt="visa" class="img-fluid"></td>
      <td>玉山商業銀行</td>
      <td>1234****</td>
    </tr>
    <tr>
      <th scope="row"><input type="radio" name="creditCard" id="creditCard[]" ></th>
      <td><img src="./images/MasterCard_Logo.svg" alt="visa" class="img-fluid"></td>
      <td>玉山商業銀行</td>
      <td>1234****</td>
    </tr>
    <tr>
      <th scope="row"><input type="radio" name="creditCard" id="creditCard[]" ></th>
      <td><img src="./images/UnionPay_logo.svg" alt="visa" class="img-fluid"></td>
      <td>玉山商業銀行</td>
      <td>1234****</td>
    </tr>
  </tbody>
</table>
<hr>
<button type="button" class="btn btn-outline-success">使用其他信用卡付款</button>
  </div>
  <!-- 第三頁面匯款資訊 -->
  <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
    <h4 class="card-title pt-3">ATM匯款資訊：</h4>
    <img src="images/Cathay-bk-rgb-db.svg" alt="cathay" class="img-fluid">
    <h5 class="card-title">匯款銀行：</h5>
    <h5 class="card-title">姓名：</h5>
    <p class="card-text">匯款帳號：</p>
    <p class="card-text">備註：</p>
  </div>
  <!-- 第四頁電子支付 -->
  <div class="tab-pane fade" id="epay" role="tabpanel" aria-labelledby="epay-tab" tabindex="0">

<table class="table caption-top">
    <caption>選擇電子支付方式</caption>
  <thead>
    <tr>
      <th scope="col" width="5%">#</th>
      <th scope="col" width="35%">電子支付系統</th>
      <th scope="col" width="60%">電子支付系統</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><input type="radio" name="epay[]" id="eapy[]" checked></th>
      <td><img src="./images/Apple_Pay_logo.svg" alt="applepay" class="img-fluid"></td>
      <td>Apple Pay</td>
    </tr>
    <tr>
      <th scope="row"><input type="radio" name="epay[]" id="epay[]" ></th>
      <td><img src="./images/Line_pay_logo.svg" alt="linepay" class="img-fluid"></td>
      <td>Line Pay</td>
    </tr>
    <tr>
      <th scope="row"><input type="radio" name="epay[]" id="cpay[]" ></th>
      <td><img src="./images/JKOPAY_logo.svg" alt="jkopay" class="img-fluid"></td>
      <td>JKOPAY</td>
    </tr>
  </tbody>
</table>
  </div>
</div>
<!-- the end of bootstrap nav and tab -->

        </div>
    </div>
</div>

<!-- 結帳資料查詢 -->
 <?php
 $SQLstring="SELECT * FROM cart, product, product_img WHERE ip='".$_SERVER['REMOTE_ADDR']."' AND orderid IS NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
 $cart_rs=$link->query($SQLstring);
 $ptotal=0;//設定累加的變數，初始為0;
 ?>

<div class="table-responsive-md" style="width:90%;">
  <table class="table table-hover mt-3">
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
        <!-- 開始生成結帳表格 -->
         <?php while($cart_data=$cart_rs->fetch()) {?>
        <tr class="">
            <td><?php echo $cart_data['p_id']; ?> </td>
            <td><img src="product_img/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"> </td>
            <td><?php echo $cart_data['p_name']; ?></td>
            <td>
                <h4 class="color_e600a0 pt-1"><?php echo $cart_data['p_price']; ?></h4>
            </td>
            <td><?php echo $cart_data['qty']; ?></td>
            <td>
                <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price']*$cart_data['qty']; ?></h4>
            </td>
        </tr>
        <?php $ptotal += $cart_data['p_price']*$cart_data['qty']; } ?>
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
        <tr>
            <td colspan="7"><button id="btn04" name="btn04" class="btn btn-danger"><i class="fas fa-cart-arrow-down pr-2"></i>確認結帳</button>
            <button type="button" id="btn05" name="btn05" class="btn btn-warning mr-2" onclick="window.history.go(-1);"><i class="fas fa-undo-alt pr-2"></i>回上一頁</button>
        </td>
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

<!-- bootstrap Modal -->
<!-- Modal -->
<?php
// 取得所有收件人資料
$SQLstring=sprintf("SELECT * , city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND addbook.myZip=town.Post AND town.AutoNo=city.AutoNo", $_SESSION['emailid']);
$addbook_rs=$link->query($SQLstring);
?>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">收件人資訊</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="">
            <div class="row">
                <div class="col">
                 
                    <input type="text" name="cname" class="form-control" placeholder="收件人姓名">
                </div>
                <div class="col">
                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="收件人電話">
                </div>
                <div class="col">
                   
                    <select name="myCity" id="myCity" class="form-control">
                        <option value="">請選擇市區</option>
                        <!-- 建立選擇市區的程式 -->
                        <?php $city="SELECT * FROM `city` WHERE State=0"; $city_rs=$link->query($city);
                        while($city_rows=$city_rs->fetch()) { ?>
                          <option value="<?php echo $city_rows['AutoNo']; ?>">
                            <?php echo $city_rows['Name']; ?>
                          </option>
                        <?php } ?>
                    </select><br>
                </div>
                <div class="col">
                    <select name="myTown" id="myTown" class="form-control">
                        <option value="">請選擇地區</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="hidden" name="myZip" id="myZip" value="">
                    <label for="address" id="add_label" name="add_label">郵遞區號：</label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="地址">
                </div>
            </div>
            <div class="row mt-4 justify-content-center">
                <div class="col-auto">
                    <button type="button" class="btn btn-success" id="recipient" name="recipient">新增收件人</button>
                </div>
            </div>
        </form>
        <hr>
<!-- 收件人表格 -->
<table class="table">
  <thead class="table-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">收件人</th>
        <th scope="col">電話</th>
        <th scope="col">地址</th>
    </tr>
  </thead>
  <tbody>
    <!-- 插入收件人資訊到表單中 -->
     <?php while($data=$addbook_rs->fetch()) { ?>
    <tr>
        <th scope="row"><input type="radio" name="gridRadios" id="gridRadios[]" value="<?php echo $data['addressid'] ?>" <?php echo ($data['setdefault']) ? 'checked':'';?>>
        </th>
        <td><?php echo $data['cname']; ?></td>
        <td><?php echo $data['mobile']; ?></td>
        <td><?php echo $data['myZip'].$data['ctName'].$data['toName'].$data['address']; ?></td>
    </tr>
    <?php }?>
    
  </tbody>
</table>

      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <button type="button" class="btn btn-primary">儲存變更</button>
      </div>
    </div>
  </div>
</div>
<!-- the end of bootstrap Modal -->
<!-- start of loading page -->
<div id="loading" name="loading" style="display:none; position:fixed; width:100%; height:100%; top:0; left:0; background-color:rgba(255,255,255,.5);z-index:9999;"><i class="fas fa-spinner fa-spin fa-5x fa-fw" style="position:absolute;top:50%;left:50%;"></i></div>
</body>
</html>
<script>
  $(function(){
    //取得縣市代碼後查詢鄉鎮市的名稱
    $("#myCity").change(function(){
      var CNo=$('#myCity').val();
      if(CNo==""){
        return false;
      }
      $('#myZip').val("");
      $('#add_label').html("郵遞區號：")
      $.ajax({
        // 將鄉鎮市的名稱從後台取回
        url:'Town_ajax.php',
        type:'post',
        data:{
          CNo:CNo,
        },
        success:function(data){
          if(data.c==true){
            $('#myTown').html(data.m);
            
          }else{
            alert("資料庫回傳錯誤"+data.m)
          }
        },
        error:function(data){
          alert("系統目前無法連接到後台資料庫")
        }
      })
    });
    // 取得鄉鎮代碼，查詢郵遞區號放入#myZip,#zipcode
    $("#myTown").change(function(){
      var AutoNo=$('#myTown').val();
      if(AutoNo==''){
        $('#myZip').val("");
        $('#add_label').html("");
        return false;
      }
      $.ajax({
        url:'Zip_ajax.php',
        type:'get',
        dataType:'json',
        data:{
          AutoNo:AutoNo,
        },
        success:function(data){
          if(data.c==true){
            $('#myZip').val(data.Post);
            $('#add_label').html('郵遞區號：'+data.Post +data.Cityname+data.Name);
          }else{
            alert("伺服器回傳錯誤:"+data.m);
          }
        },
        error:function(data){
          alert("系統目前無法連結到後台資料庫");
        }
      });
    });
  })
</script>
