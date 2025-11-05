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
                    <?php require_once("chkout_content.php") ?>
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
                 
                    <input type="text" name="cname" id="cname" class="form-control" placeholder="收件人姓名">
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
  // 新增收件人程式
  $('#recipient').click(function(){
    var validate=0,
    msg="";
    var cname=$("#cname").val();
    var mobile=$("#mobile").val();
    var myZip=$("#myZip").val();
    var address=$("#address").val();
    if(cname==""){
      msg=msg+"收件人不得為空白！;\n";
      validate=1;
    }
    if(mobile==""){
      msg=msg+"電話不得為空白！;\n";
      validate=1;
    }
    var checkphone=/^[0]{1}[9]{1}[0-9]{8}$/;
    if(checkphone.test(mobile)==false){
      msg=msg+"電話格式有誤！;\n";
      validate=1;
    }
    if(myZip==""){
      msg=msg+"郵遞區號不得為空白！；\n";
      validate=1;
    }
    if(address==""){
      msg=msg+"地址不得為空白！;\n";
      validate=1;
    }
    if(validate){
      alert(msg);
      return false
    }
    $.ajax({
      url:'addbook.php',
      type:'post',
      dataType:'json',
      data:{
        cname:cname,
        mobile:mobile,
        myZip:myZip,
        address:address,
      },
      success:function(data){
        if(data.c==true){
          alert(data.m);
          window.location.reload();
        }else{
          alert("資料庫回應錯誤："+data.m);
        }
      },
      error:function(data){
        alert("系統無法與資料庫建立連線，請聯絡管理員")
      }
    });
  });
  // 更新收件人處理程序
  $('input[name=gridRadios]').change(function(){
    var addressid=$(this).val();
    $.ajax({
      url:'changeaddr.php',
      type:'post',
      dataType:'json',
      data:{
        addressid:addressid,
      },
      success:function(data){
        if(data.c==true){
          alert(data.m);
          window.location.reload();
        }else{
          alert("伺服器傳回錯誤："+data.m)
        }
      },
      error:function(data){
        alert("ajax傳送錯誤")
      }
    })
  })

  //系統進行結帳處理
  $('#btn04').click(function(){
    let msg="系統將進行結帳處理，請確認產品金額與收件人是否正確！";
    if(!confirm(msg)) return false;
    $("#loading").show();
    var addressid=$('input[name=gridRadios]:checked').val();
    $.ajax({
      url:'addorder.php',
      type:'post',
      dataType:'json',
      data:{
        addressid:addressid,
      },
      success:function(data){
        if(data.c==true){
          alert(data.m);
          window.location.href="index.php";
        }else{
          alert("資料庫回傳錯誤："+data.m);
        }
      },
      error:function(data){
        alert("ajax請求錯誤");
      }
    });
  });
</script>
