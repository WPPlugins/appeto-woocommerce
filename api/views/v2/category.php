<ion-view title="<?php echo $extra->name ?>" cache-view="true">
    <ion-content padding="false" ng-controller="WoocommerceCategoryCtrl" class="<?php echo $extra->content_classes." woocommerce category ".$extra->layout;?> "
                 ng-init="localUrl='<?php echo site_url();?>';
                 content_classes='<?php echo $extra->content_classes;?>';
                 layout='<?php echo $extra->layout?>';
                 currency_symbol='<?php echo get_woocommerce_currency_symbol();?>';
                 category='<?php echo $extra->slug;?>';
                 "
        >
        <div class="transparent woocommerce-product" ng-show="products.length == 0" style="text-align: center">در حال دریافت اطلاعات</div>
        <?php
        $parent_id = (int) $extra->id;
        if($parent_id != 0) {
            $get_child_category = get_terms('product_cat',array('child_of' => $parent_id));
            if(!empty($get_child_category)) {
                $link = array(
                    'layout' => $extra->layout,
                    'content_classes'  => $extra->content_classes
                );
                echo '<div class="list">';
                foreach($get_child_category as $category) {
                    if($category->parent != $parent_id or $category->parent == 0) continue;
                    $link['id'] = $category->term_id;
                    $link['slug'] = $category->slug;
                    $link['name'] = $category->name;

                    $tClass = "";
                    $bClass = "no-img";
                    $img = '';
                    if($category->image != "") {
                        $tClass = 'item-thumbnail-right';
                        $bClass = "";
                        $img = '<img src="'.$category->image.'">';
                    }
                    $_link = base64_encode(json_encode($link));
                    echo '<a class="item woo-category-box '.$tClass.'" href="#/nav/woocommerce-v2/category/'.$_link.'">
                    '.$img.'
                    <h2>'.$category->name.'</h2>
                    <span class="badge badge-assertive '.$bClass.'">'.$category->count.'</span>
                  </a>';
                }
                echo '</div>';
            }
        }
        ?>

        <div class="row" ng-repeat="baseProduct in products">
            <div class="col col-50" ng-repeat="product in baseProduct.products">
                <a href="#/nav/woocommerce-v2/product/{{  product.appLink }}" style="text-decoration: none">
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
								<i class="ion-pricetag"></i> {{ product.price }} {{ currency_symbol }}
								<br ng-if="product.regular_price!=product.price && product.regular_price!=''" /><i class="ion-pricetag" ng-if="product.regular_price!=product.price && product.regular_price!=''"></i> <span ng-if="product.regular_price!=product.price && product.regular_price!=''" style="text-decoration: line-through">{{ product.regular_price }} {{ currency_symbol }}</span>
							</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <ion-infinite-scroll
            on-infinite="nextPage()"
            distance="1%">
        </ion-infinite-scroll>


    </ion-content>
</ion-view>