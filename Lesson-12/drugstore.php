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
                    <?php
                        $level1Open="";
                        $level2Open="";
                        if(isset($_GET['level']) && isset($_GET['classid'])){
                            //選擇第一層類別
                            $SQLstring=sprintf("SELECT * FROM pyclass WHERE level=%d AND classid=%d",$_GET['level'],$_GET['classid']);
                            $classid_rs=$link->query($SQLstring);
                            $data=$classid_rs->fetch();
                            $level1Cname=$data['cname'];
                            $level1Open='<li class="breadcrumb-item active" aria-current="page">'.$level1Cname.'</li>';
                        }elseif(isset($_GET['classid'])){
                            //選擇第二層類別
                            $SQLstring=sprintf("SELECT * FROM pyclass where level=2 and classid=%d", $_GET['classid']);
                            $classid_rs=$link->query($SQLstring);
                            $data=$classid_rs->fetch();
                            $level2Cname=$data['cname'];
                            $level2Uplink=$data['uplink'];
                            $level2Open='<li class="breadcrumb-item active" aria-current="page">'.$level2Cname.'</li>';
                            //需加處理上一層
                            $SQLstring=sprintf("SELECT * FROM pyclass where level=1 and classid=%d", $level2Uplink);
                            $classid_rs=$link->query($SQLstring);
                            $data=$classid_rs->fetch();
                            $level1Cname=$data['cname'];
                            $level1=$data['cname'];
                            $level1Open='<li class="breadcrumb-item"><a href="drugstore.php?classid='.$level2Uplink.'&level='.$level1.'">'.$level1Cname.'</a></li>';
                        }
                    ?>
                    <!-- breadcrunch元件 -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
                            <?php echo $level1Open.$level2Open; ?>
                        </ol>
                    </nav>
                   
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
