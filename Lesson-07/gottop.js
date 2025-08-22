
    $(function(){
      //使用jquery將image的標籤程式插入到body中
      $("body").append("<img id='goTopButton' style='display:none; z-index:5; cursor:point;' title='back to top' >");
      var img="up-arrow.png", //宣告變數設定圖檔名稱
          locate=0.5, //出現在螢幕高度
          right=1000, //距離右邊px值
          opacity=0.6,
          speed=800,
          $button=$("#goTopButton");
          $button.attr("src",img);

          function goTopMove(){
            //從網頁取得與頂端的距離
            var scrollH=$(document).scrollTop(),
            winH=$(window).height(),
          
          css={"top":winH*locate+"px","position":"fixed","right":right,"opacity":opacity};

          if(scrollH>20){
            $button.css(css);
            $button.fadeIn("slow");
          }else{
            abc={"transform":"none", };
            $button.css(abc);
            
            $button.fadeOut("slow")
          }
        };

        $(window).on({
          scroll:function(){goTopMove();},
          resize:function(){goTopMove();}
        })
        $button.on({
          mouseover:function(){$button.css("opacity",1);},
          mouseout:function(){
            
            $button.css("opacity",opacity);},
          click:function(){
            css={"transform":"rotate(360deg)","transition":"transform 1s ease 0s"}
            $button.css(css);
            $("html,body").animate({scrollTop:0},speed);
          }
        });
    });
