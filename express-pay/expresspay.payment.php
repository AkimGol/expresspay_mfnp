<?php
/*
Plugin Name: ExpressPay Payment Module
Plugin URI: https://express-pay.by/cms-extensions/wordpress
Description: Place the plugin shortcode at any of your pages and start to accept payments in WordPress instantly
Version: 1.1.9
Author: LLC «TriIncom»
Author URI: https://express-pay.by
Text Domain: wordpress_expresspay
Domain Path: /languages
*/

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

global $wpdb;

define('EXPRESSPAY_SCRIPT_DEBUG', false);
define('EXPRESSPAY__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('EXPRESSPAY_TABLE_PAYMENT_METHOD_NAME', $wpdb->prefix . "expresspay_options");
define('EXPRESSPAY_TABLE_INVOICES_NAME', $wpdb->prefix . "expresspay_invoices");

require_once(EXPRESSPAY__PLUGIN_DIR . 'src/class.expresspay.payment.php');
require_once(EXPRESSPAY__PLUGIN_DIR . 'src/class.expresspay.home.php');
require_once(EXPRESSPAY__PLUGIN_DIR . 'class.expresspay.php');
require_once(EXPRESSPAY__PLUGIN_DIR . 'src/class.payment.settings.list.php');
require_once(EXPRESSPAY__PLUGIN_DIR . 'src/class.payment.settings.php');
require_once(EXPRESSPAY__PLUGIN_DIR . 'src/class.invoices.php');

function get_plugin_version() {
    if (EXPRESSPAY_SCRIPT_DEBUG) { return time(); }
    $plugin = get_file_data(__FILE__, ['Version' => 'Version'], 'plugin');
    return $plugin['Version'];
}

register_activation_hook(__FILE__, array('ExpressPay', 'plugin_activation'));
register_deactivation_hook(__FILE__, array('ExpressPay', 'plugin_deactivation'));
register_uninstall_hook(__FILE__, array('ExpressPay', 'plugin_uninstall'));

load_plugin_textdomain("wordpress_expresspay", false, dirname(plugin_basename(__FILE__)) . '/languages');

// Хук добавления меню в администртивной части Wordpress
add_action('admin_menu', 'add_expresspay_plugin_menu');

// Добавление шорткода
add_shortcode('expresspay_payment', array('ExpressPayPayment', 'payment_callback'));

// Хук получения уведомления о платеже
add_action('wp_ajax_receive_notification', array('ExpressPayPayment', 'receive_notification')); // For logged in users
add_action('wp_ajax_nopriv_receive_notification', array('ExpressPayPayment', 'receive_notification')); // For anonymous users

// Хук получения данных для формы
add_action('wp_ajax_get_form_gata', array('ExpressPayPayment', 'get_form_gata')); // For logged in users
add_action('wp_ajax_nopriv_get_form_gata', array('ExpressPayPayment', 'get_form_gata')); // For anonymous users

// Хук ответа при выставлении счета
add_action('wp_ajax_check_invoice', array('ExpressPayPayment', 'check_invoice')); // For logged in users
add_action('wp_ajax_nopriv_check_invoice', array('ExpressPayPayment', 'check_invoice')); // For anonymous users

//Хук для тестовых настроек
add_action('wp_ajax_get_test_mode_params', array('ExpressPayPaymentSettings', 'get_test_mode_params')); // For logged in users
add_action('wp_ajax_nopriv_get_test_mode_params', array('ExpressPayPaymentSettings', 'get_test_mode_params')); // For anonymous users

add_action('wp_ajax_payment_options', array('ExpressPayPaymentSettingsList', 'payment_setting_options')); // For logged in users

/**
 * Создание меню в администртивной части Wordpress
*/
function add_expresspay_plugin_menu()
{
    add_menu_page(
        __('Express Payments', 'wordpress_expresspay'),
        __('Express Payments', 'wordpress_expresspay'),
        'administrator',
        'expresspay-payment',
        NULL,
        'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAASxSURBVEhL7ZVbbFRFGMfnci7bs92z293tbXt16Y0mGIRYBLQCT4DogyRclGL6oPiiNaFJ9WnbxFtCoiYak4qhSb0l2wcTCCZEVCIGQiSGItsogqUtLdgLu93t2T23OePMdmmpsbVRfOv/5Zz5Zub7nZnvP3PAila0ovslmHv+a1FKYV9fH4ppSuFgMuXOhbMKelxmvTV++9ChQ1YuNKf/BObQ97/vr75qqs8OJozmGduuJnQ+pwsjzSfh87vr/J/j2Jlze/bsIbmu5YMjPT0uYEr5fxCCAHCDUENjxaQJ6oczcOe0bj9lU+oG90ABhLl36uQJ6NcNpflt6PSxb7q6uhweXQCORCJCIry5dsI0FbdalK8GC9fdSOreiYyNFBEVKAJaO2OQvAybKiCgIgDLTIeKbOkCy0QxhNMYwQHDpgkJgSqL0kaGYB9KHTY/tqMYH3ilueEyZ7HgQmFRchWGG8tkf/CxG0mj9I5OvH5ZWCMjtC1hkOK0Q70UAL/l0AoGVdgUka9OQmisIZD3xnaf1fJgfGDfvrC7pdQtneJQDtdMuvqyhvd3d18UOWfRreb16+zszPb7azbk30FOcCJNUNIAQC4uUm5S71tpi+zgUEoBqVTF3jXwt8Ov7doVzyZg6vjqyqMXpmmUUFjKEwbyhJ8f0QafeLVl581FwUvpveNnK7+1gp/FdXtztpYMvL5E+aQB6x8lUok5AwVCFXUnh2bentJJGW+zgdfqJ65sP9q2//o/gnuYqcYcxTNiGFASvbCopvYBKnu2/TCSaksTpyg3jDvYlDFMseSsErOikG8x8doU4GybgcMM3MvBkWhU8sqlteMZXRlNmNTCshmqDq++lbEqR2dMqMq4yCMKDycM26VZBIgQ+dnmlhkOlWeNs3wtAHccv1ipufwvjmdMN6G0Jm1Sj04chW1ggI0M2ICKrNyYrYPvKZ4/JvNCrH4FihhHgE7nQn8vCIf9w/2tH7+8dzCbhB+jW6EQrM0LFkwBtzrBHAT9+XJ5VW3TtXgmMJIyQYEsFssYNE1liItxvKYDVrGiCXy+AKG9tVJ9J6TfOjY9eWeuxn8VxNjBowOjbW1txrLNFYl8J6jl4+qYZQiFa9YXnhuHH8R18vhdV1er0odPBiY79m7alMlNWVLLqlF3d7coh+NeDtVYW5UVqViRzNlevoMAMz88cxWUv9R76tKC+/pIb6/7za8v1e3+4qcdz737pS8XXvwcH/lxZMsvk0bT9YQOJQH5Ay68NmU63qRuA4SgIkBQYxDqurfmEoZxF4ZRt4h+FxACtzULsIHlFqEbTeIElZmpgydf2HKWj10U/PqJc2WjaVAznjZgRVVVnW7SdUMptmKLIJ8sNtiOU5q2CWKeCzj8Bpv7AHZTUejwljN7sNgrZbcrTKjaxNMnn996JhvMdi1D0WgUx2IxyE3YWLLKP6lD3zQQcVnVqo0XxlIH2GXyEAHUs+BHwcSahC1+RkIwVmJMHf70YPMFHl82eCkdPX2+eFgONSUNsj1lktqkOWtsj4SBW8RDcS19KoTNfmWyf6SrtVXnffcFfFf8WPp8vnxdlufyCppmtre3p7n5c6EVrej/FAB/Ah02CyrcnNLxAAAAAElFTkSuQmCC'
    );

    $home_page = add_submenu_page(
        'expresspay-payment',
        __('Home', 'wordpress_expresspay'),
        __('Home', 'wordpress_expresspay'),
        'administrator',
        'expresspay-payment',
        array('ExpressPayHome', 'get_default_option_page')
    );

    $invoice_page = add_submenu_page(
        'expresspay-payment',
        __('Invoices and payemnts', 'wordpress_expresspay'),
        __('Invoices and payemnts', 'wordpress_expresspay'),
        'administrator',
        'invoices-and-payments',
        array('ExpressPayInvoicesAndPayemnts', 'get_invoices_page')
    );

    $pay_settings_list_page = add_submenu_page(
        'expresspay-payment',
        __('Settings', 'wordpress_expresspay'),
        __('Settings', 'wordpress_expresspay'),
        'administrator',
        'payment-settings-list',
        array('ExpressPayPaymentSettingsList', 'get_payment_setting_list_page')
    );

    $payment_settings_page = add_submenu_page(
        NULL,
        __('Settings', 'wordpress_expresspay'),
        __('Settings', 'wordpress_expresspay'),
        'administrator',
        'payment-settings',
        array('ExpressPayPaymentSettings', 'get_payment_setting_page')
    );

    // Хуки подключения стилей и скриптов для страниц интеграции
    add_action('load-' . $home_page, array('ExpressPay', 'plugin_admin_styles'));
    add_action('load-' . $pay_settings_list_page, array('ExpressPay', 'plugin_admin_styles'));
    add_action('load-' . $payment_settings_page, array('ExpressPay', 'plugin_admin_styles'));
    add_action('load-' . $invoice_page, array('ExpressPay', 'plugin_admin_styles'));
}
