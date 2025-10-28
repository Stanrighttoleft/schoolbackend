<?php 
// If session not start then start
(!isset($_SESSION))? session_start():"";
?>
<?php 
//bring in the connection file to connect to database
require_once('./Connections/conn_db.php');
?>
<?php require_once("php_lib.php");?>
<!-- for login function -->
<?php
// 取得要返回php頁面
if(isset($_GET['sPath'])){
  $sPath=$_GET['sPath'].".php";
}else{
  // 登入完成預設要進入首頁
  $sPath="index.php";
}
// 檢查是否完成登入驗證
if(isset($_SESSION['login'])){
  header(sprintf("location:%s",$sPath));
  //舊版採用下列方法
  // echo "<script>Window.location.href='".$sPath."';</script>
}
?>


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
                <div class="col-md-10 loginpage">
                    <!-- 引入登入模組 -->
                    <?php require_once("login_content.php"); ?>
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
  
  <!-- 登入時loading function -->
   <div id="loading" name="loading" style="display:none; position:fixed;width:100%;height:100%;top:0;left:0;background-color:rgba(255,255,255,.5);z-index:9999"><i class="fas fa-spinner fa-spin fa-5x fa-fw" style="position:absolute;top:50%;left:50%;"></i></div>
</body>
</html>
 
 <script>
  $(function(){
    $("#form1").submit(function(){
      const inputAccount=$("#inputAccount").val();
      const inputPassword=$("#inputPassword").val();
      $("#loading").show();
      // 利用$ajax函數呼叫後台的auth_user.php驗證帳號密碼
      $.ajax({
        url:'auth_user.php',
        type:'post',
        dataType:'json',
        data:{
          inputAccount:inputAccount,
          inputPassword:inputPassword,
        },
        success:function(data){
          if(data.c==true){
            alert(data.m);
            // window.location.reload();
            window.location.href="<?php echo $sPath; ?>";
          }else{
            alert(data.m);
          }
        },
        error:function(data){
          alert("系統無法連接後台資料庫");
        }
      });
    });
  });
 </script>
