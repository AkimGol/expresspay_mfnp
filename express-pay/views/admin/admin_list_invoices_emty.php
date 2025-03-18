<div class="row navbar">
    <div class="col-md-2">
        <a href="<?php echo esc_html($url . '?page=expresspay-payment'); ?>"><?php esc_html_e('Home', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-2">
        <a href="#" class="current"><?php esc_html_e('Invoices and payemnts', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-2">
        <a href="<?php echo esc_html($url . '?page=payment-settings-list'); ?>"><?php esc_html_e('Settings', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-2">
        <a target="_blank" href="<?php echo esc_html('https://express-pay.by/extensions/wordpress/erip'); ?>"><?php esc_html_e('Help', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-6"></div>
</div>
<div class="back_link">
    <a href="#" onclick="window.history.back()"><?php esc_html_e('Back', 'wordpress_expresspay') ?></a>
</div>
<div class="row">
    <div class="header-table col-md-12">
        <div class="col-md-2"><?php esc_html_e('Account number', 'wordpress_expresspay') ?></div>
        <div class="col-md-2"><?php esc_html_e('Amount', 'wordpress_expresspay') ?></div>
        <div class="col-md-2"><?php esc_html_e('Date of creation', 'wordpress_expresspay') ?></div>
        <div class="col-md-2"><?php esc_html_e('Status', 'wordpress_expresspay') ?></div>
        <div class="col-md-2"><?php esc_html_e('Payment date', 'wordpress_expresspay') ?></div>
    </div>
    <div class="content col-md-12" style="text-align: center;">
        <div class="table-row">
            <div class="col-md-12 text-empty-table">
                <p class="text-center"><?php esc_html_e('Account list is empty', 'wordpress_expresspay') ?></p>
            </div>
        </div>
    </div>
</div>