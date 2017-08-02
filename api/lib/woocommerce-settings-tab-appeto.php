<?php
/**
 * Plugin Name: WooCommerce Settings Tab Demo
 * Plugin URI: https://gist.github.com/BFTrick/b5e3afa6f4f83ba2e54a
 * Description: A plugin demonstrating how to add a WooCommerce settings tab.
 * Author: Patrick Rauland
 * Author URI: http://speakinginbytes.com/
 * Version: 1.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
class WC_Settings_Tab_Appeto {
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_appeto', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_appeto', __CLASS__ . '::update_settings' );
    }


    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_appeto'] = "اپلیکیشن";
        return $settings_tabs;
    }
    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }
    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }
    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {
        $settings = array(
            'section_title' => array(
                'name'     => "تنظیمات فرم ثبت نام خریدار در ووکامرس از اپلیکیشن - اپتو",
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_appeto_section_title'
            ),
            'showForm' => array(
                'name' => "این فرم را نمایش نده و کاربر را از اپ به صفحه سبد خرید ببر",
                'type' => 'checkbox',
                'desc' => "در صورت فعال کردن این گزینه برای خرید از کاربر اطلاعاتی از اپ دریافت نمیشود و برای پر کردن اطلاعات مستقیم از اپ به سایت منتقل میشود، این کار برای کپن های تخفیف، پست و فرمهای ثبت نام خاص مناسب است.",
                'id'   => 'appeto_woo_signup_form_app'
            ),
            'mobile' => array(
                'name' => "نمایش فیلد تلفن",
                'type' => 'checkbox',
                'desc' => "",
                'id'   => 'appeto_woo_signup_form_mobile'
            ),
            'company' => array(
                'name' => "نمایش فیلد نام شرکت",
                'type' => 'checkbox',
                'desc' => "",
                'id'   => 'appeto_woo_signup_form_company'
            ),
            'state' => array(
                'name' => "نمایش فیلد انتخاب استان",
                'type' => 'checkbox',
                'desc' => "",
                'id'   => 'appeto_woo_signup_form_state'
            ),
            'city' => array(
                'name' => "نمایش فیلد شهر",
                'type' => 'checkbox',
                'desc' => "",
                'id'   => 'appeto_woo_signup_form_city'
            ),
            'address' => array(
                'name' => "نمایش فیلد آدرس",
                'type' => 'checkbox',
                'desc' => "",
                'id'   => 'appeto_woo_signup_form_address'
            ),
            'address2' => array(
                'name' => "نمایش فیلد آدرس دوم",
                'type' => 'checkbox',
                'desc' => "",
                'id'   => 'appeto_woo_signup_form_address2'
            ),
            'postalcode' => array(
                'name' => "نمایش فیلد کدپستی",
                'type' => 'checkbox',
                'desc' => "",
                'id'   => 'appeto_woo_signup_form_postalcode'
            ),
            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'wc_settings_tab_appeto_section_end'
            )
        );
        return apply_filters( 'wc_settings_tab_appeto_settings', $settings );
    }
}
