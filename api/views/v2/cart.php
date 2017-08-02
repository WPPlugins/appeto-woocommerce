<ion-view title="سبد خرید" cache-view="false">

    <ion-content padding="false" ng-controller="WoocommerceCartCtrl" class=" woocommerce category <?php echo $extra->layout." ".$extra->content_class?>"
                 ng-init="
                 baseShowUrl='<?php echo site_url();?>/?appeto_api=woocommerce';
                 setCartPage();
                 separator='<?php echo wc_get_price_thousand_separator();?>';
                 num_decimal='<?php echo wc_get_price_decimals();?>';
                 ">

        <div class="transparent" ng-show="orders.length <= 0">
            <div>
                سبد خرید شما خالی است.
            </div>
        </div>

        <ion-list can-swipe="listCanSwipe">
            <ion-item ng-repeat="order in orders"
                      class="item woo-category-box" ng-class="order.thumb == '' ? '' : 'item-thumbnail-right'">

                <img ng-if="order.thumb" ng-src="{{ order.thumb }}" />
                <h2 ng-bind-html="order.title"></h2>
                <p>
                    <i class="ion-pricetag"></i> {{ order.price }} <?php echo get_woocommerce_currency_symbol();?>
                    <span ng-if="order.regular_price!=order.price">/</span> <span ng-if="order.regular_price!=order.price" style="text-decoration: line-through">{{ order.regular_price }} ريال</span>
                    <img ng-if="$first" ng-src="<?php echo plugins_url()."/appeto-woocommerce/assets/img/swipe-left.gif";?>" class="swipe-help"/>
                </p>
                <span class="badge badge-assertive badge-with-swipe-help">{{ order.quantity }}</span>
                <ion-option-button class="button-positive woo"
                                   ng-click="deleteFromCart(order.id, order.title)">
                    حذف
                </ion-option-button>
                <ion-option-button class="button-info woo"
                                   ng-click="showItemFromCart(order.id, order.title, '<?php echo $extra->layout ?>', '<?php echo $extra->content_class ?>' )">
                    ویرایش
                </ion-option-button>

            </ion-item>
        </ion-list>

        <div ng-show="orders.length > 0">
            <div class="row" >
                <div class="col">
                    <p class="fullPrice">
                        جمع قیمت:
                        <span ng-bind="fullPrice"></span> <?php echo get_woocommerce_currency_symbol();?>
                    </p>
                </div>
                <div class="col">
                    <?php
                    $appeto_woo_signup_form_app = get_option('appeto_woo_signup_form_app');
                    if($appeto_woo_signup_form_app == 'yes') {
                    ?>
                        <button class="button button-royal button-block woo" ng-click="appCardToSite('<?php echo site_url();?>')">
                            مرحله بعد
                        </button>
                    <?php
                    }
                    else {
                    ?>
                    <button class="button button-royal button-block woo" ng-click="modal.show()">
                        مرحله بعد
                    </button>
                    <?php
                    }
                    ?>

                </div>
            </div>
            <hr />
            <div class="row">
                <button class="button woo button-positive button-block" ng-click="emptyCart()">
                    <i class="ion-ios-trash"></i>
                    خالی کردن سبد خرید
                </button>
            </div>
        </div>


        <script id="in-order.html" type="text/ng-template">
            <ion-modal-view>
                <ion-header-bar>
                    <div class="button button-clear wooCloseModalBtn" ng-click="modal.hide()"><span class="icon ion-close"></span></div>
                    <div class="button wooAddAccountBtn" ng-show="!newAccount"  ng-click="changeAccountMode(1)"><span class="icon ion-android-person-add"></span> <span> ساخت اکانت جدید</span></div>
                    <div class="button wooAddAccountBtn" ng-show="newAccount"  ng-click="changeAccountMode(0)"><span class="icon  ion-android-person"></span> <span> من اکانت دارم</span></div>
                </ion-header-bar>
                <ion-content delegate-handle="inOrder" class="inOrderModal">
                    <div class="transparent woocommerce-product" ng-show="!newAccount">
                        <div>
                            <div class="list">
                                <label class="item item-input woocommerce-input">
                                    <span class="input-label">ایمیل
                                        <sup>*</sup>
                                    </span>
                                    <input type="email" ng-model="registered.email">
                                </label>
                                <label class="item item-input woocommerce-input">
                                    <span class="input-label">گذرواژه
                                        <sup>*</sup>
                                    </span>
                                    <input type="password" ng-model="registered.password">
                                </label>
                                <label class="item item-input woocommerce-input">
                                    مرا به خاطر بسپار
                                    <label class="toggle toggle-assertive">
                                        <input type="checkbox" ng-model="registered.remember">
                                        <div class="track" style="margin-right: 5px">
                                            <div class="handle"></div>
                                        </div>
                                    </label>
                                </label>
                                <br />
                                <button class="button button-royal woo button-block" ng-click="createOrder();">
                                    تکمیل خرید
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="transparent woocommerce-product" ng-show="newAccount">
                        <div>
                            <div class="list">
                                <label class="item item-input woocommerce-input">
                                    <span class="input-label">نام
                                        <sup>*</sup>
                                    </span>
                                    <input type="text" ng-model="userInfo.first_name">
                                </label>
                                <label class="item item-input woocommerce-input">
                                    <span class="input-label">نام خانوادگی
                                        <sup>*</sup>
                                    </span>
                                    <input type="text" ng-model="userInfo.last_name">
                                </label>
                                <label class="item item-input woocommerce-input">
                                    <span class="input-label">ایمیل
                                        <sup>*</sup>
                                    </span>
                                    <input type="email" ng-model="userInfo.email">
                                </label>
                                <label class="item item-input woocommerce-input">
                                    <span class="input-label">گذرواژه
                                        <sup>*</sup>
                                    </span>
                                    <input type="text" ng-model="userInfo.password">
                                </label>
                                <?php
                                $appeto_woo_signup_form_mobile = get_option('appeto_woo_signup_form_mobile');
                                $appeto_woo_signup_form_company = get_option('appeto_woo_signup_form_company');
                                $appeto_woo_signup_form_state = get_option('appeto_woo_signup_form_state');
                                $appeto_woo_signup_form_city = get_option('appeto_woo_signup_form_city');
                                $appeto_woo_signup_form_address = get_option('appeto_woo_signup_form_address');
                                $appeto_woo_signup_form_address2 = get_option('appeto_woo_signup_form_address2');
                                $appeto_woo_signup_form_postalcode = get_option('appeto_woo_signup_form_postalcode');
                                $userInfoContinue = "first_name,last_name,";
                                if(!$appeto_woo_signup_form_mobile or $appeto_woo_signup_form_mobile == 'yes') {
                                    echo '<label class="item item-input woocommerce-input">
                                            <span class="input-label">تلفن
                                                <sup>*</sup>
                                            </span>
                                            <input type="text" ng-model="userInfo.phone">
                                          </label>';
                                    $userInfoContinue .= "phone,";
                                }
                                if(!$appeto_woo_signup_form_company or $appeto_woo_signup_form_company == 'yes') {
                                    echo '<label class="item item-input woocommerce-input">
                                                <span class="input-label">نام شرکت</span>
                                                <input type="text"  ng-model="userInfo.company">
                                            </label>';
                                }
                                if(!$appeto_woo_signup_form_state or $appeto_woo_signup_form_state == 'yes') {
                                    $iranStates = new WC_Countries();
                                    $states = $iranStates->get_states('IR');
                                    if(is_array($states) and !empty($states)):
                                        echo '<label class="item item-input item-select woocommerce-input">
                                                <div class="input-label">
                                                    استان
                                                </div>
                                                <select ng-model="userInfo.state"
                                                        ng-init="userInfo.state = \'TE\'">';

                                        foreach($states as $key => $value) {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }

                                        echo '    </select>
                                            </label>';
                                    endif;
                                    $userInfoContinue .= "state,";
                                }
                                if(!$appeto_woo_signup_form_city or $appeto_woo_signup_form_city == 'yes') {
                                    echo '<label class="item item-input woocommerce-input">
                                            <span class="input-label">شهر
                                                <sup>*</sup>
                                            </span>
                                            <input type="text" ng-model="userInfo.city">
                                        </label>';
                                    $userInfoContinue .= "city,";
                                }
                                if(!$appeto_woo_signup_form_address or $appeto_woo_signup_form_address == 'yes') {
                                    echo '<label class="item item-input woocommerce-input">
                                            <span class="input-label">آدرس
                                                <sup>*</sup>
                                            </span>
                                            <input type="text" ng-model="userInfo.address_1">
                                        </label>';
                                    $userInfoContinue .= "address_1,";
                                }
                                if(!$appeto_woo_signup_form_address2 or $appeto_woo_signup_form_address2 == 'yes') {
                                    echo '<label class="item item-input woocommerce-input">
                                                <span class="input-label">آدرس دوم</span>
                                                <input type="text" ng-model="userInfo.address_2">
                                            </label>';
                                }
                                if(!$appeto_woo_signup_form_postalcode or $appeto_woo_signup_form_postalcode == 'yes') {
                                    echo '<label class="item item-input woocommerce-input">
                                            <span class="input-label">کدپستی
                                                <sup>*</sup>
                                            </span>
                                            <input type="text" ng-model="userInfo.postcode">
                                        </label>';
                                    $userInfoContinue .= "postcode,";
                                }
                                ?>
                                <br />
                                <button class="button button-royal woo button-block" ng-click="createOrder();">
                                    تکمیل خرید
                                </button>


                            </div>
                        </div>
                    </div>

                </ion-content>
            </ion-modal-view>
        </script>
        <?php
        $userInfoContinue = rtrim($userInfoContinue, ",");
        echo '<span ng-init="userInfoContinue=\''.$userInfoContinue.'\'"></span>';
        ?>

    </ion-content>


</ion-view>