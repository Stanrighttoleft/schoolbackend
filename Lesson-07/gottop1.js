
    $(function(){
      //使用jquery將image的標籤程式插入到body中
      $("body").append("<img id='goTopButton' style='display:none; z-index:5; cursor:point;' title='back to top' >");
      var img="./starrail/firefly1.png", //宣告變數設定圖檔名稱
          locate=0.8, //出現在螢幕高度
          right=10, //距離右邊px值
          opacity=0.5,
          speed=800,
          $button=$("#goTopButton");
          $button.attr("src",img);

          function goTopMove(){
             if ($button.hasClass("fly-away")) return;
            
            //從網頁取得與頂端的距離

            var scrollH=$(document).scrollTop(),
            winH=$(window).height(),
          
          css={"top":winH*locate+"px","position":"fixed","right":right,"opacity":opacity, "transform":"scale(0.7)"};

          if(scrollH>50){
            $button.css(css);
            $button.fadeIn("slow");
          }else{
            // abc={"transform":"none","transition":"none" };
            // $button.css(abc);
            
            $button.fadeOut("slow")
          }
        };

        $(window).on({
          scroll:function(){goTopMove();},
          // resize:function(){goTopMove();}
        })
        $button.on("animationend",()=> {
          // Reset for reuse
          $button.removeClass("fly-away").hide();
        });
        $button.on({
          mouseover:function(){$button.css("opacity",1);},
          mouseout:function(){
            
            $button.css("opacity",opacity);},
          click:()=>{
            // css={"transform":"translateY(-9000%)", "opacity":"0" ,"transition":"transform 0.5s ease-in-out 0s, opacity 1s ease  "}
            // $button.css(css);
            $button.addClass("fly-away");

            $("html,body").animate({scrollTop:0},speed);
          }
        });
    });
