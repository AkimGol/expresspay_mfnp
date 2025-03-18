<?php

class ExpressPayHome
{
    /**
     * Рендеринг домашней страницы интеграции
     */
    static function get_default_option_page()
    {
        ExpressPay::view(
            'admin/home_options',
            array(
                'url' => get_option('expresspay_plugin_ult')
            )
        );
    }
}
