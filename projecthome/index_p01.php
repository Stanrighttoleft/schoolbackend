<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project01</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./website_p01.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
  </head>
  <body class="position-relative">
    <div class="position-fixed carticon rounded-circle bg-white shadow" style="top:20%; right:20%; width:100px; height:100px; z-index:5;" >
      <img src="./images/assets/carticon.png" style="width: 100%; height:auto;" alt="">
    </div>
    <!-- Floating chat/contact box -->
    <div class="floating-box">
      <div class="chat-toggle" id="chatToggle">
        <i class="fa-solid fa-comments me-1"></i><span style="font-size: 1em;">聯絡我們</span>
      </div>
      <div class="chat-panel shadow-lg" id="chatPanel">
        <h5 class="mb-3 text-center">聯絡我們</h5>
        <div class="d-flex flex-column align-items-center">
          <a href="https://line.me/ti/p/xxxx" target="_blank" class="btn btn-success mb-2 w-75">
            <i class="fa-brands fa-line me-2"></i> LINE
          </a>
          <a href="https://facebook.com/xxxx" target="_blank" class="btn btn-primary mb-2 w-75">
            <i class="fa-brands fa-facebook me-2"></i> Facebook
          </a>
          <a href="mailto:info@yourmail.com" class="btn btn-warning text-dark w-75">
            <i class="fa-solid fa-envelope me-2"></i> Email
          </a>
        </div>
      </div>
    </div>
    

    <div class="wrapper container-fluid">
      <section id="header" style="position: sticky;top:0; z-index:3;" >
        <div class="top d-flex bg-warning"> 
          <div class="topleft ms-auto w-60 d-flex justify-content-end" style="width: 50%;">
            <img src="./images/assets/facebook.png" class="mx-3" alt="" style="height: 30px;"> 粉絲團 
            <img src="images/assets/like.png" alt="" style="height: 30px;" class="mx-3">
          </div> 
        
          <div class="topright  d-flex justify-content-end w-40" style="width:50%;">
            <img src="" alt="">

            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <i class="fa-solid fa-magnifying-glass mx-3 " style="font-size: 30px;"></i>
                <i class="fa-solid fa-user ms-3" style="font-size: 30px;"></i>
                <i class="fa-solid fa-cart-shopping mx-3" style="font-size: 30px;"></i>
                
          </div></div>
  
        <nav class="navbar navbar-expand-lg bg-warning sticky-top" >
          
          
          <div class="container-fluid ms-auto">
            <a class="navbar-brand" href="#"><img src="./images/assets/logov122.png" style="width: 80px;" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#" style="font-size: 20px; font-weight:600;">瞭解澳洲</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" style="font-size: 20px; font-weight:600;">澳洲時事</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 20px; font-weight:600;">
                    澳洲代購
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 20px; font-weight:600;">
                    澳洲直購
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link " style="font-size: 20px; font-weight:600;">關於我們</a>
                </li>
              </ul>
              
              </form>
            </div>
          </div>
        </nav>      
      </section>
      <section id="banner" class="position-relative overflow-hidden"  style="width: 100%; height: 600px;">
        <img src="./images/assets/rabbit.png" alt="" class="position-absolute" style="top:30%; left:45%; z-index:2">
        <img src="./images/assets/fun.png" alt="" class="position-absolute" style="left:50%; top:20%;">
        <img src="./images/assets/grass1.png" alt="" class="position-absolute" style="bottom:0%;  ">
        <img src="./images/assets/grass1.png" alt="" class="position-absolute" style="bottom:0%; left:50%  ">
       
      </section>
      <section id="productview" class="p-5 pt-1">
        <div class="w-100 d-flex justify-content-center mb-3" style="font-size: 20px;">優惠商品</div>
        <div class="scrollwrapper position-relative">

        <!-- navigation -->
             <i class="fa-solid fa-chevron-left position-absolute" style="color:#ffd43b; font-size:100px; top:30%; z-index:2; cursor:pointer;" alt=""></i>
             <i class="fa-solid fa-chevron-right position-absolute" style="color:#ffd43b; font-size:100px; top:30%; right:0%; z-index:2; cursor:pointer;" alt=""></i>
          <div class="product-row overflow-hidden d-flex flex-nowrap">
            
            <!-- product cards -->
            <div class="card p-1 m-2 mx-5 flex-shrink-0" style="width: 18rem;">
              <div class="text-center">
                <img src="./images/products/small/m1.png" class="card-img-top" alt="..."
                style="width: 150px;">
              </div>
              <div class="card-body">
                <h5 class="card-title">澳洲益生菌B420-60顆入</h5>
                <p class="card-text">早買早好多吃多健康</p>
                <p class="card-text">NT:800</p>
                <div class="d-flex "><button href="#" class="btn btn-primary me-1">放入購物車</button>
                <button href="#" class="btn btn-success">直接購買</button>
              </div>
              </div>
            </div>            
            <div class="card p-1 m-2 mx-5 flex-shrink-0" style="width: 18rem;">
              <div class="text-center">
                <img src="./images/products/small/m1.png" class="card-img-top" alt="..."
                style="width: 150px;">
              </div>
              <div class="card-body">
                <h5 class="card-title">澳洲益生菌B420-60顆入</h5>
                <p class="card-text">早買早好多吃多健康</p>
                <p class="card-text">NT:800</p>
                <div class="d-flex "><button href="#" class="btn btn-primary me-1 ">放入購物車</button>
                <button href="#" class="btn btn-success">直接購買</button>
              </div>
              </div>
            </div>            
            <div class="card p-1 m-2 mx-5 flex-shrink-0" style="width: 18rem;">
              <div class="text-center">
                <img src="./images/products/small/m1.png" class="card-img-top" alt="..."
                style="width: 150px;">
              </div>
              <div class="card-body">
                <h5 class="card-title">澳洲益生菌B420-60顆入</h5>
                <p class="card-text">早買早好多吃多健康</p>
                <p class="card-text">NT:800</p>
                <div class="d-flex "><button href="#" class="btn btn-primary me-1">放入購物車</button>
                <button href="#" class="btn btn-success">直接購買</button>
              </div>
              </div>
            </div>            
            <div class="card p-1 m-2 mx-5 flex-shrink-0" style="width: 18rem;">
              <div class="text-center">
                <img src="./images/products/small/m1.png" class="card-img-top" alt="..."
                style="width: 150px;">
              </div>
              <div class="card-body">
                <h5 class="card-title">澳洲益生菌B420-60顆入</h5>
                <p class="card-text">早買早好多吃多健康</p>
                <p class="card-text">NT:800</p>
                <div class="d-flex "><button href="#" class="btn btn-primary me-1">放入購物車</button>
                <button href="#" class="btn btn-success">直接購買</button>
              </div>
              </div>
            </div>            
            <div class="card p-1 m-2 mx-5 flex-shrink-0" style="width: 18rem;">
              <div class="text-center">
                <img src="./images/products/small/m1.png" class="card-img-top" alt="..."
                style="width: 150px;">
              </div>
              <div class="card-body">
                <h5 class="card-title">澳洲益生菌B420-60顆入</h5>
                <p class="card-text">早買早好多吃多健康</p>
                <p class="card-text">NT:800</p>
                <div class="d-flex "><button href="#" class="btn btn-primary me-1">放入購物車</button>
                <button href="#" class="btn btn-success">直接購買</button>
              </div>
              </div>
            </div>            
            <div class="card p-1 m-2 mx-5 flex-shrink-0" style="width: 18rem;">
              <div class="text-center">
                <img src="./images/products/small/m1.png" class="card-img-top" alt="..."
                style="width: 150px;">
              </div>
              <div class="card-body">
                <h5 class="card-title">澳洲益生菌B420-60顆入</h5>
                <p class="card-text">早買早好多吃多健康</p>
                <p class="card-text">NT:800</p>
                <div class="d-flex "><button href="#" class="btn btn-primary me-1">放入購物車</button>
                <button href="#" class="btn btn-success">直接購買</button>
              </div>
              </div>
            </div>            
            <div class="card p-1 m-2 mx-5 flex-shrink-0" style="width: 18rem;">
              <div class="text-center">
                <img src="./images/products/small/m1.png" class="card-img-top" alt="..."
                style="width: 150px;">
              </div>
              <div class="card-body">
                <h5 class="card-title">澳洲益生菌B420-60顆入</h5>
                <p class="card-text">早買早好多吃多健康</p>
                <p class="card-text">NT:800</p>
                <div class="d-flex "><button href="#" class="btn btn-primary me-1">放入購物車</button>
                <button href="#" class="btn btn-success">直接購買</button>
              </div>
              </div>
            </div>            
            <div class="card p-1 m-2 mx-5 flex-shrink-0" style="width: 18rem;">
              <div class="text-center">
                <img src="./images/products/small/m1.png" class="card-img-top" alt="..."
                style="width: 150px;">
              </div>
              <div class="card-body">
                <h5 class="card-title">澳洲益生菌B420-60顆入</h5>
                <p class="card-text">早買早好多吃多健康</p>
                <p class="card-text">NT:800</p>
                <div class="d-flex "><button href="#" class="btn btn-primary me-1">放入購物車</button>
                <button href="#" class="btn btn-success">直接購買</button>
              </div>
              </div>
            </div>            
            <div class="card p-1 m-2 mx-5 flex-shrink-0" style="width: 18rem;">
              <div class="text-center">
                <img src="./images/products/small/m1.png" class="card-img-top" alt="..."
                style="width: 150px;">
              </div>
              <div class="card-body">
                <h5 class="card-title">澳洲益生菌B420-60顆入</h5>
                <p class="card-text">早買早好多吃多健康</p>
                <p class="card-text">NT:800</p>
                <div class="d-flex "><button href="#" class="btn btn-primary me-1">放入購物車</button>
                <button href="#" class="btn btn-success">直接購買</button>
              </div>
              </div>
            </div>            
          </div>
        </div>
        <div class="w-100 d-flex justify-content-center mt-3" style="font-size: 20px;">瞭解更多</div>
      </section>
      <section id="news">
       <div class="row">
        <div class="col-md-10">
          <div class="row">
            <div class="col-md-12 d-flex justify-content-center" style="font-size: 20px; font-weight:800">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;澳洲時事
            </div>
            <div class="col-md-12 d-flex">
              <div class="col-md-2" style="font-size: 16px;  border-bottom: dotted 1px black;">BBC</div>
              <div class="col-md-7" style="font-size: 16px;  border-bottom: dotted 1px black; ">澳洲總理脫光光遊街</div>
              <div class="col-md-3" style="font-size: 16px;  border-bottom: dotted 1px black; ">日期：04/12/2025</div>
            </div>
            <div class="col-md-12 d-flex">
              <div class="col-md-2" style="font-size: 16px;  border-bottom: dotted 1px black;">ABC</div>
              <div class="col-md-7" style="font-size: 16px;  border-bottom: dotted 1px black;">移民改革2025重磅消息</div>
              <div class="col-md-3" style="font-size: 16px;  border-bottom: dotted 1px black;">日期：05/12/2025</div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <img src="./images/assets/pen.gif" class="img-fluid" alt="" style="max-width:100%; height:auto;">
        </div>
       </div> 
      </section>
      <section id="aboutus" class="bg-warning">
        <div class="row">
          <div class="col-md-4">
            <img src="./images/assets/shipment1.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-4">
            <img src="./images/assets/aboutus.svg" class="img-fluid" alt="" style="height:600px;">
          </div>
          <div class="col-md-4 d-flex flex-column justify-content-center align-items-center">
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi earum inventore sit repudiandae placeat amet esse, impedit autem ratione deserunt maiores eius officiis at sunt eveniet sequi. Ducimus, beatae laboriosam?</p>
            <button class="btn btn-warning">關於我們</button>
          </div>
        </div>
      </section>
      <section id="procedure">
        <div>
          <img src="./images/assets/orderprocess.png" class="img-fluid" style="width: 100%;" alt="">
        </div>
        
      </section>
      <section id="footer" >
        <div class="row bg-success position-relative text-white footertop" style="height:400px;">
        
          <div class="col-md-4">

            <img src="./images/qrcode.jpg" style="width: 200px;" class="mt-5 mb-5" alt="">
            <br>
             掃我到客服

          </div>
          <div class="col-md-4">
            <img src="./images/assets/logov122.png" class="mt-5" style="width: 300px;" alt="">
          </div>
          <div class="col-md-4 mt-5">
            公司名稱：澳打國際
            <br>
            公司電話：
            <br>
            公司住址：
            <br>
            copyright：all right reserved
          </div>
        </div>

        
      </section>
      
    </div>
    
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- jquery version of scroll item list -->
  <!-- <script>
$(document).ready(function() {
  const $row = $(".product-row");
  const scrollAmount = 400; // Adjust this to how far each click scrolls

  $(".fa-chevron-left").on("click", function() {
    $row.animate({
      scrollLeft: $row.scrollLeft() - scrollAmount
    }, 400); // 400ms smooth scroll
  });

  $(".fa-chevron-right").on("click", function() {
    $row.animate({
      scrollLeft: $row.scrollLeft() + scrollAmount
    }, 400);
  });
});
</script> -->
<script>

  //product view
document.addEventListener("DOMContentLoaded", () => {
  const row = document.querySelector(".product-row");
  const scrollAmount = 400;

  document.querySelector(".fa-chevron-left").addEventListener("click", () => {
    row.scrollBy({ left: -scrollAmount, behavior: "smooth" });
  });

  document.querySelector(".fa-chevron-right").addEventListener("click", () => {
    row.scrollBy({ left: scrollAmount, behavior: "smooth" });
  });
});
// chating box
document.getElementById("chatToggle").addEventListener("click", function() {
  const panel = document.getElementById("chatPanel");
  panel.style.display = panel.style.display === "block" ? "none" : "block";
});
</script>


</body>
</html>