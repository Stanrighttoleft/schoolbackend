<?php
                    //建立熱銷商品查詢
                    $SQLstring="SELECT * FROM hot,product,product_img WHERE hot.p_id=product_img.p_id AND hot.p_id=product.p_id AND product_img.sort=1 order by h_sort";
                    $hot=$link->query($SQLstring);
                    ?>
                    <div class="card text-center mt-3" style="border:none">
                        <div class="card-body">
                            <h5 class="card-title">店長推薦，熱銷商品</h5>
                        </div>
                        <?php while($data=$hot->fetch()){ ?>
                            <img src="product_img/<?php echo $data['img_file']; ?>" class="card-img-top" alt="HOT<?php echo $data['h_sort']; ?>" title="<?php echo $data['p_name']; ?>" >
                        <?php } ?>
                        <!-- <img src="product_img/-10-182065.webp" alt="" class="card-img-top">
                        <img src="product_img/-SPF50-50ml-196690.webp" alt="" class="card-img-top">
                        <img src="product_img/-Acnes-BB-30g-533727.webp" class="card-img-top" alt=""> -->
                    </div>