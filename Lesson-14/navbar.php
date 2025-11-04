
        <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="images/logo.jpg" class="img-fluid rounded-circle" alt="店商藥妝"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <?php
            //讀取後台購物車內產品數量
            $SQLstring="SELECT * FROM cart WHERE orderid is NULL AND ip='".$_SERVER['REMOTE_ADDR']."'";
            $cart_rs=$link->query($SQLstring);
            ?>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                
                <!-- 使用Php產生產品類別功能 -->
                <?php multiList01(); ?>
               
                <li class="nav-item">
                <a class="nav-link" href="./register.php">會員註冊</a>
                </li>
                <?php if(isset($_SESSION['login'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" onclick="btn_confirmLink('是否確認登出?','logout.php')">會員登出</a>
                </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">會員登入</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                <a class="nav-link" href="#">會員中心</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">最新活動</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">查訂單</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">折價券</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="cart.php">購物車<span class="badge text-bg-info"><?php echo($cart_rs) ?$cart_rs->rowCount():''; ?></span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        企業專區
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">認識企業</a></li>
                        <li><a class="dropdown-item" href="#">全台門市</a></li>
                        <li><a class="dropdown-item" href="#">供應商報</a></li>
                        <li><a class="dropdown-item" href="#">加盟專區</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">投資人專區</a></li>
                    </ul>
                </li>
                <!--  使用PHP函數方式產生產品類別功能 -->
                <?php //multiList02(); ?> 
            </ul>
<?php if(isset($_SESSION['login'])){ ?>
<ul class="navbar-nav ms-auto me-4">
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="uploads/<?php echo ($_SESSION['imgname']!='')?$_SESSION['imgname']:'avatar.svg'; ?>" width="40" height="40" class="rounded-circle" alt="">
        </a>
        <div class="dropdown-menu">

        </div>
        <div class="dropdown-menu">
            <a href="orderlist.php" class="dropdown-item">Order List</a>
            <a href="profile.php" class="dropdown-item">Edit Profile</a>
            <a href="#" class="dropdown-item" onclick="btn_confirmLink('請確定是否要登出','logout.php');">Log Out</a>
        </div>
    </li>
</ul>
<?php } ?>
            </div>
        </div>
        </nav> 
        <?php
        function multiList02()
         {
            global $link;
            //列出產品第一層資料
            $SQLstring="SELECT * FROM pyclass  WHERE level=1 ORDER BY sort";
            $pyclass01=$link->query($SQLstring);
            ?>
                <?php 
                while($pyclass01_Rows=$pyclass01->fetch()){
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $pyclass01_Rows['cname'];?>
                    </a>
                    <ul class="dropdown-menu">

                    <!-- 列出產品類別對應的第二層資料 -->
                        <?php
                        $SQLstring=sprintf("SELECT * FROM pyclass WHERE level=2 AND uplink=%d ORDER BY sort",$pyclass01_Rows['classid']);
                        $pyclass02=$link->query($SQLstring);
                        ?>
                        <?php while($pyclass02_Rows=$pyclass02->fetch()){?>
                            <li><a class="dropdown-item" href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>"><em class="fas <?php echo $pyclass02_Rows['fonticon'];?> fa-fw"></em><?php echo $pyclass02_Rows['cname'];?></a></li>
                        <?php } ?>
                        
                    </ul>
                </li>
                <?php } ?>
        <?php } ?>
        <?php 
        function multiList01(){ 
            global $link;
            //列出產品類別第一層資訊
            $SQLstring="SELECT * FROM pyclass  WHERE level=1 ORDER BY sort";
            $pyclass01=$link->query($SQLstring);
         ?>
            <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" aria-expanded="false">
                        產品資訊
                    </a>
                    <ul class="dropdown-menu">
                        <!-- PHP while迴圈建立選單 -->
                        <?php 
                            while($pyclass01_Rows=$pyclass01->fetch()){
                        ?>
                        <li class="nav-item dropend ">
                            <a class="dropdown-item dropdown-toggle" href="#">
                                <i class="fas <?php echo $pyclass01_Rows['fonticon'];?> fa-lg fa-fw"></i><?php echo $pyclass01_Rows['cname'];?>
                            </a>
                            <!-- 列出第二層資訊 -->
                            <?php
                             $SQLstring=sprintf("SELECT * FROM pyclass WHERE level=2 AND uplink=%d ORDER BY sort",$pyclass01_Rows['classid']);
                             $pyclass02=$link->query($SQLstring);
                            ?>
                            <ul class="dropdown-menu">
                                <?php while($pyclass02_Rows=$pyclass02->fetch()){?>
                                <li><a href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>" class="dropdown-item">
                                    <em class="fas <?php echo $pyclass02_Rows['fonticon'];?> fa-fw"></em><?php echo $pyclass02_Rows['cname'];?>
                                </a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php }?>
                    </ul>
                </li>
        <?php } ?>