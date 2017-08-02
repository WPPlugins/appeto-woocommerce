<ion-view title="<?php echo $extra->name ?>" cache-view="false">
    <ion-content padding="false" ng-controller="WoocommerceProductCtrl" class="<?php echo $extra->content_classes." ".$extra->layout;?>">
<?php
        if($result["status"] != "true") {
?>
        <div class="transparent">
            <div>
                عدم دسترسی به اطلاعات محصول
            </div>
        </div>
<?php
        }
        else {
            $product = $result["response"]->product;
            $thumbnail = '';
            if(!empty($product->images)) {
                echo '<ion-slide-box class="product-thumb-slider" auto-play="true" show-pager="true">';
                foreach($product->images as $image) {
                    if($thumbnail == '') {
                        $thumbnail = $image->src;
                    }
                    echo '<ion-slide style="background: url('.$image->src.') no-repeat center center;
													  -webkit-background-size: cover;
													  -moz-background-size: cover;
													  -o-background-size: cover;
													  background-size: cover;"></ion-slide>';
                }
                echo '</ion-slide-box>';
            }
?>

            <div class="transparent woocommerce-product">
                <div>
                    <?php
                    echo '<span style="text-align: center">'.$product->title.'</span>';
                    echo '<hr class="style-two" />';
                    echo $product->description;
                    if($product->in_stock) {
                        echo ' <span class="badge badge-balanced woo">موجود</span> ';
                    }
                    else {
                        echo ' <span class="badge badge-assertive woo">ناموجود</span> ';
                    }
                    if($product->featured) {
                        echo ' <span class="badge badge-balanced woo">ویژه</span> ';
                    }
                    ?>
                </div>
                <hr class="style-two" />
                <div class="row">
                    <?php
                    if($product->reviews_allowed and $product->rating_count > 0) {
                        echo '<div class="col" ng-init="productRate=\''.(int) $product->average_rating.'\'">
                                 <ionic-ratings class="disable" ratingsobj="ratingsObjectDisable"></ionic-ratings>
                              </div>';
                    }
                    ?>

                    <div class="col">
                        <span style="color: #222222 !important; text-align: justify">
                        <i class="ion-pricetag"></i> <?php echo $product->price.' '.get_woocommerce_currency_symbol(); ?>
                            <?php
                            if($product->price != $product->regular_price) {
                                echo '<span>/</span> <span style="text-decoration: line-through">'.$product->regular_price.' '.get_woocommerce_currency_symbol().'</span>';
                            }
                            ?>
                    </span>
                    </div>
                </div>
            </div>
            <div class="transparent woocommerce-product" style="padding-bottom: 50px">
                <div>
                    <div class="list">
                        <button class="button woo-plus-btn" ng-click="quantityNegativePlus('<?php echo $product->id?>', '+')">+</button>
                        <label class="item item-input woocommerce-input" style="margin-right: 18px">
                            <!--<span class="input-label">تعداد</span>-->
                            <input type="number" id="quantity<?php echo $product->id?>" disabled="disabled" ng-init="productId='<?php echo $product->id?>'; " ng-model="quantity" ng-change="setQuantity()">
                        </label>
                        <button class="button woo-negative-btn" ng-click="quantityNegativePlus('<?php echo $product->id?>', '-')">-</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                if($product->in_stock) {
                ?>
                    <button class="button button-royal wooAddToCard button-block" ng-init="setPageChanges();" id="wooAddToCard<?php echo $product->id?>" ng-click="addToCard('<?php echo $product->id?>', '<?php echo addslashes($product->title)?>', '<?php echo $product->price?>', '<?php echo $product->regular_price?>', '<?php echo addslashes($thumbnail)?>');">
                        <i class="ion-android-cart"></i>
                        افزودن به سبد خرید
                    </button>
                <?php
                }
                else {
                    echo '<button ng-init="setPageChanges();" class="button button-assertive wooAddToCard button-block">
در حال حاضر این محصول موجود نیست.
                           </button>';
                }
                ?>

            </div>

            <?php
            if($result["comments"] != "" and isset($result["comments"]->product_reviews) and !empty($result["comments"]->product_reviews)) {
            ?>
                <div class="transparent woocommerce-product" style="padding: 10px">
                    <h3>دیدگاه ها</h3>
                    <div>
                        <?php
                        $comments = $result["comments"]->product_reviews;
                        foreach($comments as $comment) {
                            echo '  <div class="transparent woocommerce-product" >
                                    <div><i class="ion-android-person"></i>  '.$comment->reviewer_name.'
                                    <br /><i class="ion-android-calendar"></i>   '.appeto_woo_review_ago_time(strtotime($comment->created_at)).'
                                    <hr class="style-two" />'.$comment->review.'<br />
                                    <ionic-ratings class="disable" ratingsobj="commentRateObj(\''.$comment->rating.'\', \''.$comment->id.'\')"></ionic-ratings>
                                    </div>
                                    </div>
                                    <div class="clearfix row"></div>';
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>

        <?php
        }
        ?>
    </ion-content>
</ion-view>