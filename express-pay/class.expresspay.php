<?php

class ExpressPay
{
    /**
     * 
     * Получение вью из файла.
     * 
     * @param string $name Название файла вью
     * @param array  $args Аргументы для передачи на вью
     * 
     */
    public static function view($name, array $args = array())
    {
        foreach ($args as $key => $val) {
            $$key = $val;
        }

        $file = EXPRESSPAY__PLUGIN_DIR . 'views/' . $name . '.php';

        include($file);
    }

    /**
     * 
     * Подлкючение стилей и скирптов в административной части интеграции
     * 
     */
    static function plugin_admin_styles()
    {
        //CSS
        wp_enqueue_style('pluginAdminCssEp', plugins_url('css/styles.css', __FILE__), array(), get_plugin_version());
        wp_enqueue_style('pluginAdminCssBst', plugins_url('css/bootstrap.min.css', __FILE__), array(), get_plugin_version());
        wp_enqueue_style('pluginAdminCss', plugins_url('css/admin.css', __FILE__), array(), get_plugin_version());
        
        //JS
        wp_enqueue_script('pluginAdminJsJsd', plugins_url('js/popper.min.js', __FILE__));
        wp_enqueue_script('pluginAdminJsBst', plugins_url('js/bootstrap.min.js', __FILE__));
        wp_enqueue_script('pluginAdminJs', plugins_url('js/admin.js', __FILE__), array('jquery'), get_plugin_version());
    }

    /**
     * 
     * Подключение стилей и скриптов в клиентской части интеграции
     * 
     */
    static function plugin_client_styles()
    {
        //CSS
        wp_enqueue_style('pluginPaymentCss', plugins_url('css/payment.css', __FILE__), array(), get_plugin_version());

        //JS
        wp_enqueue_script('pluginPaymentJs', plugins_url('js/shortcode.js', __FILE__), array('jquery'), get_plugin_version());
    }

    /**
     * 
     * Формирование цифровой подписи
     * 
     * @param array  $signatureParams Список передаваемых параметров
     * @param string $secretWord      Секретное слово
     * @param string $method          Метод формирования цифровой подписи
     * 
     * @return string $hash           Сформированная цифровая подпись
     * 
     */
    public static function computeSignature($signatureParams, $secretWord, $method)
    {
        $normalizedParams = array_change_key_case($signatureParams, CASE_LOWER);
        $mapping = array(
            "add-invoice" => array(
                "token",
                "accountno",
                "amount",
                "currency",
                "expiration",
                "info",
                "surname",
                "firstname",
                "patronymic",
                "city",
                "street",
                "house",
                "building",
                "apartment",
                "isnameeditable",
                "isaddresseditable",
                "isamounteditable"
            ),
            "get-details-invoice" => array(
                "token",
                "id"
            ),
            "cancel-invoice" => array(
                "token",
                "id"
            ),
            "status-invoice" => array(
                "token",
                "id"
            ),
            "get-list-invoices" => array(
                "token",
                "from",
                "to",
                "accountno",
                "status"
            ),
            "get-list-payments" => array(
                "token",
                "from",
                "to",
                "accountno"
            ),
            "get-details-payment" => array(
                "token",
                "id"
            ),
            "add-card-invoice"  =>  array(
                "token",
                "accountno",
                "expiration",
                "amount",
                "currency",
                "info",
                "returnurl",
                "failurl",
                "language",
                "pageview",
                "sessiontimeoutsecs",
                "expirationdate"
            ),
            "card-invoice-form"  =>  array(
                "token",
                "cardinvoiceno"
            ),
            "status-card-invoice" => array(
                "token",
                "cardinvoiceno",
                "language"
            ),
            "reverse-card-invoice" => array(
                "token",
                "cardinvoiceno"
            ),
            "get-qr-code"          => array(
                "token",
                "invoiceid",
                "viewtype",
                "imagewidth",
                "imageheight"
            ),
            "add-web-invoice"      => array(
                "token",
                "serviceid",
                "accountno",
                "amount",
                "currency",
                "expiration",
                "info",
                "surname",
                "firstname",
                "patronymic",
                "city",
                "street",
                "house",
                "building",
                "apartment",
                "isnameeditable",
                "isaddresseditable",
                "isamounteditable",
                "emailnotification",
                "smsphone",
                "returntype",
                "returnurl",
                "failurl"
            ),
            "add-webcard-invoice" => array(
                "token",
                "serviceid",
                "accountno",
                "expiration",
                "amount",
                "currency",
                "info",
                "returnurl",
                "failurl",
                "language",
                "sessiontimeoutsecs",
                "expirationdate",
                "returntype"
            ),
            "response-web-invoice" => array(
                "token",
                "expresspayaccountnumber",
                "expresspayinvoiceno"
            ),
            "bind-card" => array(
                "token",
                "serviceid",
                "writeoffperiod",
                "amount",
                "currency",
                "info",
                "returnurl",
                "failurl",
                "language",
                "returntype"
            ),
            "notification" => array(
                "data"
            )
        );
        $apiMethod = $mapping[$method];
        $result = "";
        foreach ($apiMethod as $item) {
            $result .= $normalizedParams[$item];
        }
        $hash = strtoupper(hash_hmac('sha1', $result, $secretWord));
        return $hash;
    }

    /**
     * 
     * Обновление статуса счета
     * 
     * @param string $account_no Номер счета
     * @param int    $status     Новый статус счета
     * 
     */
    public static function updateInvoiceStatus($account_no, $status)
    {
        global $wpdb;

        $wpdb->update(
            EXPRESSPAY_TABLE_INVOICES_NAME,
            array('status' => $status),
            array('id' => $account_no),
            array('%d'),
            array('%s')
        );
    }

    /**
     * 
     * Обновление даты оплаты счета
     * 
     * @param string $account_no        Номер счета
     * @param string $dateofpayment     Дата оплаты счета
     * 
     */
    public static function updateInvoiceDateOfPayment($account_no, $dateofpayment)
    {
        global $wpdb;

        $wpdb->update(
            EXPRESSPAY_TABLE_INVOICES_NAME,
            array('dateofpayment' => $dateofpayment),
            array('id' => $account_no),
            array('%s'),
            array('%s')
        );
    }

    /**
     * 
     * Получение Qr-кода
     * 
     * @param string $token      Токен
     * @param int    $invoiceId  Номер счета в сервисе Эксрпесс Платежи
     * @param string $secretWord Секретное слово
     * 
     */
    // public static function getQrCode($token, $invoiceId, $secretWord)
    // {
    //     $request_params = array(
    //         'Token' => $token,
    //         'InvoiceId' => $invoiceId,
    //         'ViewType' => 'base64'
    //     );

    //     $request_params["Signature"] =  self::computeSignature($request_params, $secretWord, 'get-qr-code');

    //     $request_params = http_build_query($request_params);

    //     $url = 'https://api.express-pay.by/v1/qrcode/getqrcode/';
    //     $response = wp_remote_get($url . '?' . $request_params);

    //     $response = json_decode($response['body']);

    //     return $response->QrCodeBody;
    // }
    public static function getQrCode($token, $invoiceId, $secretWord)
    {
        $request_params = array(
            'Token' => $token,
            'InvoiceId' => $invoiceId,
            'ViewType' => 'base64'
        );

        $request_params["Signature"] = self::computeSignature($request_params, $secretWord, 'get-qr-code');

        $request_params = http_build_query($request_params);
        $url = 'https://api.express-pay.by/v1/qrcode/getqrcode/';
        // $url = 'https://sandbox-api.express-pay.by/v1/qrcode/getqrcode/'

        // Отправка запроса
        $response = wp_remote_get($url . '?' . $request_params);

        // Проверяем, не произошла ли ошибка
        if (is_wp_error($response)) {
            error_log('ExpressPay API Error: ' . $response->get_error_message());
            return false;
        }

        // Получаем тело ответа
        $body = wp_remote_retrieve_body($response);
        if (empty($body)) {
            error_log('ExpressPay API Error: Empty response body');
            return false;
        }

        // Декодируем JSON
        $response_data = json_decode($body);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('ExpressPay API Error: Invalid JSON - ' . json_last_error_msg());
            return false;
        }

        // Проверяем, есть ли нужные данные
        if (!isset($response_data->QrCodeBody)) {
            error_log('ExpressPay API Error: QrCodeBody is missing in response');
            return false;
        }

        return $response_data->QrCodeBody;
    }


    /**
     * 
     * Хук обработки активации плагина
     * 
     */
    static function plugin_activation()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "expresspay_options";

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        type tinytext NOT NULL,
        options text NOT NULL,
        isactive tinyint NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $invoices_table_name = EXPRESSPAY_TABLE_INVOICES_NAME;
        $sql = "CREATE TABLE $invoices_table_name(
        id int NOT NULL UNIQUE,
        amount decimal not null,
        datecreated datetime not null,
        status tinyint not null,
        dateofpayment datetime null,
        options text null,
        options_id int not null,
        PRIMARY KEY (id)
        ) $charset_collate;";

        dbDelta($sql);

        add_option('expresspay_plugin_ult', '');
    }

    /**
     * 
     * Хук обработки деактивации плагина
     * 
     */
    static function plugin_deactivation()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "expresspay_options";

        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);

        $invoices_table_name = EXPRESSPAY_TABLE_INVOICES_NAME;
        $sql = "DROP TABLE IF EXISTS $invoices_table_name";
        $wpdb->query($sql);

        delete_option('expresspay_plugin_is_active', 0);
        delete_option('expresspay_plugin_ult', '');
    }

    /**
     * 
     * Хук обработки удаления плагина
     * 
     */
    static function plugin_uninstall()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "expresspay_options";

        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);

        $invoices_table_name = EXPRESSPAY_TABLE_INVOICES_NAME;
        $sql = "DROP TABLE IF EXISTS $invoices_table_name";
        $wpdb->query($sql);

        delete_option('expresspay_plugin_is_active', 0);
        delete_option('expresspay_plugin_ult', '');
    }

    static function log_error_exception($name, $message, $e)
    {
        self::log($name, "ERROR", $message . '; EXCEPTION MESSAGE - ' . $e->getMessage() . '; EXCEPTION TRACE - ' . $e->getTraceAsString());
    }

    static function log_error($name, $message)
    {
        self::log($name, "ERROR", $message);
    }

    static function log_info($name, $message)
    {
        self::log($name, "INFO", $message);
    }

    static function log($name, $type, $message)
    {
        $log_url = wp_upload_dir();
        $log_url = $log_url['basedir'] . "/expresspay";

        if (!file_exists($log_url)) {
            $is_created = mkdir($log_url, 0777);

            if (!$is_created)
                return;
        }

        $log_url .= '/express-pay-' . date('Y.m.d') . '.log';

        file_put_contents($log_url, $type . " - IP - " . sanitize_text_field($_SERVER['REMOTE_ADDR']) . "; DATETIME - " . date("Y-m-d H:i:s") . "; USER AGENT - " . sanitize_text_field($_SERVER['HTTP_USER_AGENT']) . "; FUNCTION - " . $name . "; MESSAGE - " . $message . ';' . PHP_EOL, FILE_APPEND);
    }
}
