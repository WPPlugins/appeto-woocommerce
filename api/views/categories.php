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

    <ion-content padding="false" ng-controller="WoocommerceCategoriesCtrl" class="<?php echo $extra->content_classes." ".$extra->layout;?> woocommerce">

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
    $categories = $result["response"]->product_categories;
    if(empty($categories)) {
        echo '<div class="transparent woocommerce-product" style="text-align: center">دسته ای یافت نشد.</div>';
    }
    else {
        echo '<div class="list">';
        foreach($categories as $category) {
            $tClass = "";
            $bClass = "no-img";
            $img = '';
            if($category->image != "") {
                $tClass = 'item-thumbnail-right';
                $bClass = "";
                $img = '<img src="'.$category->image.'">';
            }
            echo '<a class="item woo-category-box '.$tClass.'" href="#/nav/woocommerce/null/{\'page\':1,\'filter[limit]\':\'20\',\'filter[category]\':\''.$category->slug.'\'}/products-get/'.$ck.'/'.$cs.'/category/{\'name\':\''.$category->name.'\', \'layout\':\''.$extra->layout.'\', \'content_classes\':\''.$extra->content_classes.'\', \'slug\':\''.$extra->slug.'\'}">
                    '.$img.'
                    <h2>'.$category->name.'</h2>
                    <span class="badge badge-assertive '.$bClass.'">'.$category->count.'</span>
                  </a>';
        }
        echo '</div>';
    }
}
?>

    </ion-content>
</ion-view>