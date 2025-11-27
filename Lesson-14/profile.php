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
    $sPath="login.php?sPath=profile";
    header(sprintf("location:%s",$sPath));
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
<!-- 引入網頁標頭 -->
<?php require_once("headfile.php")?>
</head>
<!-- 錯誤或成功驗證的CSS -->
<style>
span.error-tips,span.error-tips::before{
  font-family:"Font Awesome 5 Free";
  color: red;
  font-weight: 900;
  content: "\f0c4";
}
span.valid-tips,span.valid-tips::before{
  font-family: "Font Awesome 5 Free";
  color: greenyellow;
  font-weight: 900;
  content: "\f00c";
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
                  <!-- 會員資料修改頁面 -->
                   <?php require_once("profile_content.php"); ?>






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
        <!-- 引入javascrpt-->
            <?php require_once("jsfile.php"); ?>
            <script src="commlib.js"></script>
        <!-- 引入jquery驗證程式 -->
            <script src="./jquery.validate.js"></script>
            <script src="https://unpkg.com/vue@3"></script>
            <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- vue的部分 -->
<script>
  const Vue3=Vue.createApp({
    data(){
      return{
        emailid:<?php echo $_SESSION['emailid'] ?>, //取得會員emailid
        member:[],
        captcha:'', //存認證碼變數
        readonly:true,
        PWOld:'',  //密碼更改存舊密碼變數
        PWNew1:'', //密碼更改求新密碼變數
        PWNew2:'', //密碼更改存新密碼變數2
      }
    },
    methods:{
      
      editMember() {
        this.readonly = false;
      },
      async savePW(){
        let valid=$('#changePW').valid();
        if(valid){
          await axios.get('reqchangePW.php',{
            params:{
              emailid:this.member.emailid,
              PWNew1:MD5(this.PWNew1),
            }
          })
          .then((res)=>{
            let data=res.data;
            if(data.c==true){
              $('#changePW').validate().resetForm();
              this.PWOld='';
              this.PWNew1='';
              this.PWNew2='';
              $('#mClose').click();
              alert(data.m)
            }
          })
          .catch(function(error){
            alert(error);
          })
        }

      },

      async saveMember() {
        let valid=$('#reg').valid(); //呼叫資料驗證函數
        if(valid){
          let imgfile=$('#uploadname').val();
          if(imgfile !=''){
            this.member.imgname=imgfile;
          }
          await axios.get('reqMember.php',{
            params:{
              birthday:this.member.birthday,
              cname:this.member.cname,
              emailid:this.member.emailid,
              imgname:this.member.imgname,
              tssn:this.member.tssn,
            }
          })
          .then((res)=>{
            let data=res.data;
            if(data.c==true){
              alert(data.m);
              location.reload();
            }
          })
          .catch(function(error){
            alert(error);
          });
        }
      },
      // 亂數產生驗證內容
      getCaptcha(){
        
        //can為canvas的ID名稱
        // 150=影像寬,50=影像高,blue是影像背景顏色
        // white=文字顏色,28px=文字大小，5=認證碼長度
        this.captcha=captchaCode("can",150,50,"blue","white","28px",5);
       },
    
      // 使用第三方AJAX的API，取得使用者資料
      async getMemberInfo(){
        await axios.get('memberinfo.php',{
          params:{
            emailid:this.emailid,
          }
        })
        .then((res)=>{
          let data=res.data;
          if(data.c==true){
            this.member=data.d[0]; //將後端使用者資料存入this.member陣列
          }else{
            alert(data.m)
          }
        })
        .catch(function(error){
          alert("系統目前無法連線到資料庫後台");
        });
      },
    },
    mounted(){
      this.getCaptcha();
      this.getMemberInfo();
    }
  });
  Vue3.mount('#modify');
  $(function(){
    // 自訂身分證格式驗證
    jQuery.validator.addMethod("tssn",function(value,element,param){
      var tssn=/^[a-zA-Z]{1}[1-2]{1}[0-9]{8}$/;
      return this.optional(element) || (tssn.test(value));
    });
    // 驗證form #reg表單
    $('#reg').validate({
      onfocusout:false,
      rules:{
        cname:{
          required:true,
        },
        tssn:{
          required:false,
          tssn:true,
        },
        birthday:{
          required:true,
        },
        recaptcha:{
          required:true,
          selfCheck:'#captcha',
        },
      },
      messages:{
        cname:{
          required:'使用者名稱不得為空白',
        },
        tssn:{
          required:'身份證ID不得為空白',
          tssn:'身份證ID格式有誤',
        },
        birthday:{
          required:'生日不得為空白',
        },
        recaptcha:{
          required:'驗證碼不得為空白！',
          selfCheck:'驗證碼需相同！',
        },
      },
    });
    // 驗證changePW變更密碼表單
    $('#changePW').validate({
      rules:{
        PWOld:{
          required:true,
          remote:'checkPW.php?emailid=<?php echo $_SESSION['emailid']; ?>',
        },
        PWNew1:{
          required:true,
          maxlength:20,
          minlength:4,
        },
        PWNew2:{
          required:true,
          equalTo:'#PWNew1'
        },
      },
      messages:{
        PWOld:{
          required:'會員密碼不得空白！！',
          remote:'原始密碼有誤，需重新輸入',
        },
        PWNew1:{
          required:'密碼不得為空白！！',
          maxlength:'密碼最大長度為20位(4-20位英文字母和數字的組合)',
          minlength:'密碼最小長度為4位(4-20位英文字母和數字的組合)',
        },
        PWNew2:{
          required:'確認密碼不得為空白！！',
          equalTo:'兩次輸入的密碼必須要一致！',
        },
      },
      
    })

  })
</script>
</body>

</html>
<style>
  .input-group>.form-control{
    width:100%;
  }
</style>
<script>
  
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
    let percent=Math.round((event.loaded/event.total)*100);
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
  
  //自訂認證碼驗證，開放小寫通過。
  jQuery.validator.addMethod("selfCheck", function(value,element,param){
    var captchaData=$(param).val();
    return ((value.toUpperCase() ===captchaData.toUpperCase())? true:false);
  })

 
  
</script>
