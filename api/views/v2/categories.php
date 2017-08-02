<ion-view title="<?php echo $extra->name ?>" cache-view="true">

    <div class="shopTitle <?php echo $extra->layout;?>">
        <div class="tabs">
            <a class="tab-item" href="#/nav/<?php echo $extra->slug;?>">
                همه محصولات
            </a>
            <a class="tab-item active">
                دسته‌ها
            </a>
        </div>
    </div>

    <ion-content padding="false" ng-controller="WoocommerceCategoriesCtrl" class="<?php echo $extra->content_classes." ".$extra->layout;?> woocommerce"
        ng-init="localUrl='<?php echo $site_url;?>';
        layout='<?php echo $extra->layout?>';
        content_classes='<?php echo $extra->content_classes?>';
        load_categories();"
        >

        <div class="transparent woocommerce-product" ng-show="categories.length <= 0" style="text-align: center">{{ loadingText }}</div>

        <div class="list" ng-show="categories.length > 0">
            <a ng-repeat="category in categories" class="item woo-category-box" ng-class="category.image != '' ? 'item-thumbnail-right' : ''" href="#/nav/woocommerce-v2/category/{{ category.applink }}">
                <img ng-src="{{ category.image }}" ng-if="category.image != ''" />
                <h2>{{ category.name }}</h2>
                <span class="badge badge-assertive" ng-class="category.image != '' ? '' : 'no-img'">{{ category.count }}</span>
            </a>
        </div>

    </ion-content>

</ion-view>