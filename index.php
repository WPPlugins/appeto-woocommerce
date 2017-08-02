<?php
/*
 * Plugin Name: ووکامرس برای اپتو
 * Plugin URI: https://wordpress.org/plugins/appeto-woocommerce/
 * Description: رابط بین اپلیکیشن و فروشگاه ساز ووکامرس - اپتو
 * Author: APPETO TM
 * Version: 1.3.2
 * Author URI: http://appeto.ir
 * License: تمامی حقوق این افزونه مربوط به اپتو میباشد و هرگونه کپی برداری پیگرد قانونی خواهد داشت.
 */
require_once 'api/api.php';
new appeto_AddRulesWoo();
new appeto_browserAddToCard();
function appeto_add_cors_http_header() {
    header("Access-Control-Allow-Origin: *");
}
add_action('init','appeto_add_cors_http_header');

register_activation_hook(__FILE__, "appeto_woo_active");
register_uninstall_hook(__FILE__, "appeto_woo_remove");

function appeto_woo_active() {
    $length = 10;
    $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_*!@"), 0, $length);
    $secure_key = get_option('appeto_secure_key_woo');
    if($secure_key == '') {
        update_option('appeto_secure_key_woo', $randomString);
    }
}

function appeto_woo_remove() {
    delete_option('appeto_secure_key_woo');
    /*v2*/
    delete_option('appeto_woo_signup_form_app');
    delete_option('appeto_woo_signup_form_mobile');
    delete_option('appeto_woo_signup_form_company');
    delete_option('appeto_woo_signup_form_state');
    delete_option('appeto_woo_signup_form_city');
    delete_option('appeto_woo_signup_form_address');
    delete_option('appeto_woo_signup_form_address2');
    delete_option('appeto_woo_signup_form_postalcode');
}

add_filter( 'woocommerce_general_settings', 'appeto_add_secure_key_setting' );
function appeto_add_secure_key_setting( $settings ) {
    $updated_settings = array();
    foreach ( $settings as $section ) {
        // at the bottom of the General Options section
        if ( isset( $section['id'] ) && 'general_options' == $section['id'] &&
            isset( $section['type'] ) && 'sectionend' == $section['type']
        ) {
            $secure_key = get_option('appeto_secure_key_woo');
            $updated_settings[] = array(
                'name'     => __( 'کلید امنیتی اپلیکیشن', 'wc_appeto_secure' ),
                'desc_tip' => '',
                'id'       => 'appeto_secure_key_woo',
                'type'     => 'text',
                'css'      => 'min-width:300px; direction: ltr; text-align: right;"',
                'std'      => $secure_key,  // WC < 2.0
                'default'  => $secure_key,  // WC >= 2.0
                'desc'     => __( 'این کلید را در پنل اپتو برای افزونه ووکامرس وارد کنید', 'wc_appeto_secure_desc' ),
            );
        }
        $updated_settings[] = $section;
    }
    return $updated_settings;
}

add_action( 'admin_head', 'appeto_woo_admin_js' );
function appeto_woo_admin_js(){
    if( is_admin() and isset($_GET["page"]) and $_GET["page"] == "wc-settings")
    {
?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('appeto_secure_key_woo').setAttribute('readonly', 'readonly');
        }, false);
    </script>
<?php
    }
}

function appeto_woo_review_ago_time($time_ago){
    $cur_time     = time();
    $time_elapsed     = $cur_time - $time_ago;
    $seconds     = $time_elapsed ;
    $minutes     = round($time_elapsed / 60 );
    $hours         = round($time_elapsed / 3600);
    $days         = round($time_elapsed / 86400 );
    $weeks         = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years         = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60) {
        return "$seconds ثانیه قبل";
    }
    //Minutes
    else if($minutes <=60) {
        if($minutes==1){
            return "یک ماه پیش";
        }else{
            return "$minutes دقیقه قبل";
        }
    }
    //Hours
    else if($hours <= 24) {
        if($hours==1){
            return "یک ساعت قبل";
        }else{
            return "$hours ساعت قبل";
        }
    }
    //Days
    else if($days <= 7) {
        if($days==1){
            return "دیروز";
        }else{
            return "$days روز قبل";
        }
    }
    //Weeks
    else if($weeks <= 4.3) {
        if($weeks==1){
            return "یک هفته پیش";
        }else{
            return "$weeks هفته پیش";
        }
    }
    //Months
    else if($months <=12) {
        if($months==1){
            return "یک ماه پیش";
        }else{
            return "$months ماه پیش";
        }
    }
    //Years
    else{
        if($years==1){
            return "یک سال پیش";
        }else{
            return "$years سال پیش";
        }
    }
}

/* V2 */
if( is_admin() ){
    $appeto_woo_signup_form_mobile = get_option('appeto_woo_signup_form_mobile');
    if(!$appeto_woo_signup_form_mobile || $appeto_woo_signup_form_mobile == '') {
        update_option('appeto_woo_signup_form_mobile', 'yes');
        update_option('appeto_woo_signup_form_company', 'yes');
        update_option('appeto_woo_signup_form_state', 'yes');
        update_option('appeto_woo_signup_form_city', 'yes');
        update_option('appeto_woo_signup_form_address', 'yes');
        update_option('appeto_woo_signup_form_address2', 'yes');
        update_option('appeto_woo_signup_form_postalcode', 'yes');
    }
}


require_once 'api/lib/woocommerce-settings-tab-appeto.php';
WC_Settings_Tab_Appeto::init();