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
<!-- 會員註冊畫面 -->
<div class="row">
  <div class="col-12 text-center">
    <h1>會員註冊畫面</h1>
    <p>請輸入相關資料，*為必須輸入欄位</p>
  </div>
</div>
<div class="row">
  <div class="col-8 offset-2 text-left">
    <form action="register.php" method="POST" id="reg" name="reg">
      <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="請輸入email帳號" autocomplete="off">
      </div>
      <div class="input-group mb-3">
        <input type="password" name="pw1" id="pw1" class="form-control" placeholder="請輸入密碼">
      </div>
      <div class="input-group mb-3">
        <input type="password" name="pw2" id="pw2" class="form-control" placeholder="請再次確認密碼">
      </div>
      <div class="input-group mb-3">
        <input type="text" name="cname" id="cname" class="form-control" placeholder="請輸入姓名">
      </div>
      <div class="input-group mb-3">
        <input type="text" name="tssn" id="tssn" class="form-control" placeholder="請輸入身份證字號">
      </div>
      <div class="input-group mb-3">
        <input type="text" name="birthday" id="birthday" onfocus="(this.type='date')" class="form-control" placeholder="請選擇生日">
      </div>
      <div class="input-group mb-3">
        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="請輸入手機號碼">
      </div>
      <div class="input-group mb-3">
        <select name="myCity" id="myCity" class="form-control">
          <option value="">請選擇市區</option>
          <!-- 選擇市區的PHP -->
          <?php $city="SELECT * FROM city WHERE State=0";
          $city_rs=$link->query($city);
          while ($city_rows=$city_rs->fetch()) { ?>
            <option value="<?php echo $city_rows['AutoNo']; ?>"><?php echo $city_rows['Name']; ?></option>
          <?php } ?>

        </select><br>
        <select name="myTown" id="myTown" class="form-control">
          <option value="">請選擇地區</option>
        </select>
      </div>
      <label for="address" class="form-label" id="zipcode" name="zipcode">郵遞區號：地址</label>
      <div class="input-group mb-3">
        <input type="hidden" name="myZip" id="myZip" value="">
        <input type="text" name="address" id="address" class="form-control" placeholder="請輸入後續地址">
      </div>
      <label for="fileToUpload" class="form-label">上傳照片：</label>
      <div class="input-group mb-3">
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" title="請上傳相片圖片" accept="image/x-png,image/jpeg,image/git,image/jpg">
        <p><button class="btn btn-danger" id="uploadForm" name="uploadForm">開始上傳</button></p>

        <div id="progress-div01" class="progress" role="progressbar" aria-label="Default striped example" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"
        style="width:100%; display:none;">
          <div id="progress-bar01" class="progress-bar progress-bar-striped" style="width: 0%" role="progressbar">0%
          </div>
        </div>
        <input type="hidden" name="uploadname" id="uploadname" value=""/>
        <img src="" id="showimg" name="showimg" alt="photo" style="display: none;" class="img-fluid">
      </div>
      <div class="row form-group">
        <input type="hidden" name="captcha" id="captcha" value="">
        <a href="javascript:void(0);" title="按我更新認證" onclick="getCaptcha();">
          <canvas id="can"></canvas>
        </a>
        <input type="text" name="recaptcha" id="recaptcha" class="form-control" placeholder="請輸入驗證碼">
      </div>
      <input type="hidden" name="formct1" id="formct1" value="reg">
      <div class="input-group mb-3">
        <button type="submit" class="btn btn-success btn-lg">送出</button>
      </div>
    </form>
  </div>
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
            <script src="commlib.js"></script>
</body>
<script>
  $(function(){
    //取得縣市代碼後查詢鄉鎮市的名稱
    $("#myCity").change(function(){
      var CNo=$('#myCity').val();
      if(CNo==""){
        return false;
      }
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
            $('#myZip').val("");
          }else{
            alert(data.m)
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
            $('#zipcode').html(data.Post +data.Cityname+data.Name);
          }else{
            alert(data.m);
          }
        },
        error:function(data){
          alert("系統目前無法連結到後台資料庫");
        }
      });
    });
  })
</script>
</html>
<style>
  .input-group>.form-control{
    width:100%;
  }
</style>
<script>
  // 亂數產生驗證內容
  function getCaptcha(){
    var inputTxt=document.getElementById("captcha");
    //can為canvas的ID名稱
    // 150=影像寬,50=影像高,blue是影像背景顏色
    // white=文字顏色,28px=文字大小，5=認證碼長度
    inputTxt.value=captchaCode("can",150,50,"blue","white","28px",5);
  }
  // 取得元素ID
  function getId(el){
    return document.getElementById(el);
  }
  // 圖示上傳處理
  $("#uploadForm").click(function(e){
    var fileName=$('#fileToUpload').val();
    var idxDot=fileName.lastIndexOf(".")+1;
    let extFile=fileName.substr(idxDot,fileName.length).toLowerCase();
    if(extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile=="gif"){
      $('#progress-div01').css("display","flex");
      let file1=getId("fileToUpload").files[0];
      let formdata=new FormData();
      formdata.append("file1",file1);
      let ajax=new XMLHttpRequest();
      ajax.upload.addEventListener("progress", progressHandler, false);
      ajax.addEventListener("load", completeHandler,false);
      ajax.addEventListener("error",errorHandler,false);
      ajax.addEventListener("abort",abortHandler,false);
      ajax.open("POST", "file_upload_parser.php");
      ajax.send(formdata);
      return false
    }else{
      alert('目前只支援jpg,jpeg,png,gif檔案格式上傳!');
    }
  });
  // 上傳過程顯示百分比
  function progressHandler(event){
    let percent=Math.roung((event.loaded/event.total)*100);
    $("#progress-bar01").css("width",percent+"%");
    $("#progress-bar01").html(percent+"%");
  }
  // 上傳完成處理顯示圖片
  function completeHandler(event){
    let data=JSON.parse(event.target.responseText);
    if(data.success=='true'){
      $('#uploadname').val(data.fileName);
      $('#showimg').attr({
        'src':'uploads/'+data.fileName,
        'style':'display:block;'
      });
    }else{
      alert(data.error);
    }
  }
  // Upload failed:上傳發生錯誤處理
  function errorHandler(event){
    alert("Upload Failed:上傳發生錯誤");
  }
  // Upload Aborted:上傳作業取消處理
  function abortHandler(event){
    alert("Uload Aborted:上傳作業取消");
  }
  $(function(){
    // 啟動認證碼功能
    getCaptcha();
  })
</script>
