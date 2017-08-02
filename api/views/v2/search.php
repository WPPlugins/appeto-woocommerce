<ion-view title="<?php echo $extra->name ?>" cache-view="true">

    <ion-content padding="false" ng-controller="WoocommerceSearchCtrl" class="<?php echo $extra->content_classes." woocommerce category ".$extra->layout;?> "
                 ng-init="localUrl='<?php echo site_url();?>';
                 q='<?php echo addslashes($extra->searchQuery);?>';
                 currency_symbol='<?php echo get_woocommerce_currency_symbol();?>';
                 "
        >
        <div class="list list-inset">
            <label class="item item-input">
                <input type="text" ng-model="searchQuery" ng-init="searchQuery='<?php echo addslashes($extra->searchQuery);?>'" />
            </label>
            <button type="button" class="button button-icon icon ion-search wooDoSearchBtn" ng-click="wooInnerSearch()"></button>
        </div>

        <div ng-show="products.length <= 0 && showNotFound">
            <div class="transparent woocommerce-product" style="text-align: center">محصولی یافت نشد.</div>
        </div>

        <div ng-show="products.length > 0 && !showNotFound">
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
        </div>

    </ion-content>
</ion-view>