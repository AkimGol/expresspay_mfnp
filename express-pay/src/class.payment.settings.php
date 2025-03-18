<?php

class ExpressPayPaymentSettings
{
    /**
     * 
     * Рендеринг страницы добавление/редактирования метода оплаты.
     * 
     */
    static function get_payment_setting_page()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            self::save_settings();
        }

        ExpressPay::view('admin/admin_header', array('header' => __('Settings', 'wordpress_expresspay')));

        $id = $_GET['id'];

        if ($id == 0) {
            $param = array(
                'ApiUrl' => 'https://api.express-pay.by/v1/',
                'SandboxUrl' => 'https://sandbox-api.express-pay.by/v1/',
            );
        } else {
            global $wpdb;

            $table_name = $wpdb->prefix . "expresspay_options";

            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $type_id);
            $response = $wpdb->get_row($query);
            
            $param = json_decode($response->options, true);
        }

        $url = get_option('expresspay_plugin_ult');

        ExpressPay::view('admin/admin_payment_settings', array(
            'param' => $param,
            'notif_url' => $id == 0 ? __('To receive, add a payment method', 'wordpress_expresspay') : admin_url('admin-ajax.php') . '?action=receive_notification&type_id=' . $id,
            'url' => $url,
            'ajax_url' => admin_url('admin-ajax.php')
        ));

        ExpressPay::view('admin/admin_footer');
    }

    /**
     * 
     * Добавление/изменение насроек метода оплаты в БД.
     * 
     */
    static function save_settings()
    {

        $url = get_option('expresspay_plugin_ult');

        $params = array(
            'Name' => sanitize_text_field($_REQUEST['payment_setting_name']),
            'Type' => sanitize_text_field($_REQUEST['payment_setting_type']),
            'Token' => sanitize_text_field($_REQUEST['payment_setting_token']),
            'ServiceId' => sanitize_text_field($_REQUEST['payment_setting_service_id']),
            'SecretWord' => sanitize_text_field($_REQUEST['payment_setting_secret_word']),
            'SecretWordForNotification' => sanitize_text_field($_REQUEST['payment_setting_secret_word_for_notification']),
            'ApiUrl' => sanitize_text_field($_REQUEST['payment_setting_api_url']),
            'SandboxUrl' => sanitize_text_field($_REQUEST['payment_setting_sandbox_url']),
            'EripPath' => sanitize_text_field($_REQUEST['payment_setting_erip_path']),
        );

        if (isset($_REQUEST['payment_setting_test_mode']))
            $params['TestMode'] = sanitize_text_field($_REQUEST['payment_setting_test_mode']) ? 1 : 0;

        if (isset($_REQUEST['payment_setting_use_signature_for_notification']))
            $params['UseSignatureForNotification'] = sanitize_text_field($_REQUEST['payment_setting_use_signature_for_notification']) ? 1 : 0;

        switch ($params['Type']) {
            case 'erip':
                if (isset($_REQUEST['payment_setting_show_qr_code']))
                    $params['ShowQrCode'] = sanitize_text_field($_REQUEST['payment_setting_show_qr_code']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_name']))
                    $params['CanChangeName'] = sanitize_text_field($_REQUEST['payment_setting_can_change_name']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_address']))
                    $params['CanChangeAddress'] = sanitize_text_field($_REQUEST['payment_setting_can_change_address']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_amount']))
                    $params['CanChangeAmount'] = sanitize_text_field($_REQUEST['payment_setting_can_change_amount']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_send_email_notification']))
                    $params['SendEmail'] = sanitize_text_field($_REQUEST['payment_setting_send_email_notification']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_send_sms_notification']))
                    $params['SendSms'] = sanitize_text_field($_REQUEST['payment_setting_send_sms_notification']) ? 1 : 0;

                break;
            case 'card':
                break;
            case 'epos':

                if (isset($_REQUEST['payment_setting_show_qr_code']))
                    $params['ShowQrCode'] = sanitize_text_field($_REQUEST['payment_setting_show_qr_code']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_name']))
                    $params['CanChangeName'] = sanitize_text_field($_REQUEST['payment_setting_can_change_name']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_address']))
                    $params['CanChangeAddress'] = sanitize_text_field($_REQUEST['payment_setting_can_change_address']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_amount']))
                    $params['CanChangeAmount'] = sanitize_text_field($_REQUEST['payment_setting_can_change_amount']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_send_email_notification']))
                    $params['SendEmail'] = sanitize_text_field($_REQUEST['payment_setting_send_email_notification']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_send_sms_notification']))
                    $params['SendSms'] = sanitize_text_field($_REQUEST['payment_setting_send_sms_notification']) ? 1 : 0;

                $params['ServiceProviderCode'] = sanitize_text_field($_REQUEST['payment_setting_service_provider_code']);
                $params['ServiceEposCode'] = sanitize_text_field($_REQUEST['payment_setting_service_epos_code']);
                break;
        }
        global $wpdb;

        $table_name = $wpdb->prefix . "expresspay_options";

        $json = json_encode($params);

        $id = sanitize_text_field($_REQUEST['id']);

        if ($id == 0) {
            $wpdb->insert(
                $table_name,
                array('name' => $params['Name'], 'type' => $params['Type'], 'options' => $json, 'isactive' => 1),
                array('%s', '%s', '%s', '%d')
            );
        } else {
            $wpdb->update(
                $table_name,
                array('name' => $params['Name'], 'type' => $params['Type'], 'options' => $json),
                array('id' => $id),
                array('%s', '%s', '%s'),
                array('%d')
            );
        }
?>
        <script>
            window.location.href = '<?php echo esc_html($url); ?>?page=payment-settings-list';
        </script>
<?php
    }

    /**
     * 
     * Получение и парсинг тестовых настроек.
     * 
     */
    static function get_test_mode_params()
    {
        $json = file_get_contents(plugins_url('config/test_settings.json', __FILE__));

        echo $json;

        wp_die();
    }
}
