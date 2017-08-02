<ion-view title="<?php echo $extra->name ?>" cache-view="true">

    <ion-content padding="false" ng-controller="WoocommerceSearchCtrl" class="<?php echo $extra->content_classes." woocommerce category ".$extra->layout;?> "
                 ng-init="baseShowUrl='<?php echo site_url();?>/?appeto_api=woocommerce'; ck='<?php echo $ck;?>'; cs='<?php echo $cs;?>'"
        >
        <div class="list list-inset">
            <label class="item item-input">
                <input type="text" ng-model="searchQuery" ng-init="searchQuery='<?php echo addslashes($args2["filter[q]"]);?>'" />
            </label>
            <button type="button" class="button button-icon icon ion-search wooDoSearchBtn" ng-click="wooInnerSearch()"></button>
        </div>
        <div id="lastWooSearchView">
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
            $products = $result["response"]->products;
            if(empty($products)) {
                echo '<div class="transparent woocommerce-product" style="text-align: center">محصولی یافت نشد.</div>';
            }
            else {
                $i = 0;
                $end = false;
                foreach($products as $product) {
                    if($i == 0) {
                        echo '<div class="row">';
                        $end = false;
                    }

                    $img = '';
                    $price = '';
                    if(!empty($product->images)) {
                        $img = '<div class="imageBox" style="background: url(\''.$product->images[0]->src.'\') no-repeat center center;
                                                                  -webkit-background-size: cover;
                                                                  -moz-background-size: cover;
                                                                  -o-background-size: cover;
                                                                  background-size: cover;">
                                        <p style="visibility: hidden">&nbsp;</p>
                                    </div>';
                    }
                    if($product->price != $product->regular_price) {
                        $price = '<span>/</span> <span style="text-decoration: line-through">'.$product->regular_price.' ريال</span>';
                    }

                    echo '
                        <div class="col col-50">
                            <a href="#/nav/woocommerce/'.$product->id.'/{}/products-get/'.$ck.'/'.$cs.'/product/{\'name\':\''.$product->title.'\', \'layout\':\''.$extra->layout.'\', \'content_classes\':\''.$extra->content_classes.'\', \'slug\':\''.$extra->slug.'\'}" style="text-decoration: none">
                                <div class="card product">
                                    '.$img.'
                                    <div class="item item-body" style="background-color: #ffffff;">
                                        <h3 class="garage-title" style="color: #222222 !important;">
                                            '.$product->title.'
                                        </h3>
                                        <span style="color: #222222 !important; text-align: justify">
                                            <i class="ion-pricetag"></i> '.$product->price.' '.get_woocommerce_currency_symbol().'
                                            '.$price.'
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    ';
                    if($i == 1) {
                        echo '</div>';
                        $i = -1;
                        $end = true;
                    }
                    $i++;
                }
                if(!$end) {
                    echo '</div>';
                }
            }
        }
        ?>
        </div>

        <div ng-show="products.length <= 0 && showNotFound">
            <div class="transparent woocommerce-product" style="text-align: center">محصولی یافت نشد.</div>
        </div>

        <div ng-show="products.length > 0 && !showNotFound">
            <div class="row" ng-repeat="baseProduct in products">
                <div class="col col-50" ng-repeat="product in baseProduct.products">
                    <a href="#/nav/woocommerce/{{ product.id }}/{}/products-get/<?php echo $ck;?>/<?php echo $cs;?>/product/{'name':'{{  product.title }}', 'layout':'<?php echo $extra->layout ?>', 'content_classes':'<?php echo $extra->content_classes ?>', 'slug':'<?php echo $extra->slug ?>'}" style="text-decoration: none">
                        <div class="card product">
                            <div class="imageBox" ng-if="product.images[0].src" style="background: url('{{ product.images[0].src }}') no-repeat center center;
													  -webkit-background-size: cover;
													  -moz-background-size: cover;
													  -o-background-size: cover;
													  background-size: cover;">
                                <p style="visibility: hidden">&nbsp;</p>
                            </div>
                            <div class="item item-body" style="background-color: #ffffff;">
                                <h3 class="garage-title" style="color: #222222 !important;">
                                    {{ product.title }}
                                </h3>
							<span style="color: #222222 !important; text-align: justify">
								<i class="ion-pricetag"></i> {{ product.price }} <?php echo get_woocommerce_currency_symbol();?>
								<span ng-if="product.regular_price!=product.price">/</span> <span ng-if="product.regular_price!=product.price" style="text-decoration: line-through">{{ product.regular_price }} <?php echo get_woocommerce_currency_symbol();?></span>
							</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </ion-content>
</ion-view>