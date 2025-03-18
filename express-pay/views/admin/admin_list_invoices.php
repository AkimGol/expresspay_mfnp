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
        <?php foreach ($response as $row) : ?>
            <div class="row">
                <div class="col-md-2"><?php echo esc_html($row->id); ?></div>
                <div class="col-md-2"><?php echo esc_html($row->amount . ' BYN'); ?></div>
                <div class="col-md-2"><?php echo esc_html($row->datecreated); ?></div>
                <div class="col-md-2">
                    <?php
                    switch ($row->status) {
                        case 0:
                            esc_html_e('During', 'wordpress_expresspay');
                            break;
                        case 1:
                            esc_html_e('Awaiting payment', 'wordpress_expresspay');
                            break;
                        case 2:
                            esc_html_e('Expired', 'wordpress_expresspay');
                            break;
                        case 3:
                            esc_html_e('Paid up', 'wordpress_expresspay');
                            break;
                        case 4:
                            esc_html_e('Paid in part', 'wordpress_expresspay');
                            break;
                        case 5:
                            esc_html_e('Canceled', 'wordpress_expresspay');
                            break;
                        case 6:
                            esc_html_e('Paid with a bank card', 'wordpress_expresspay');
                            break;
                    }
                    ?>
                </div>
                <div class="col-md-2"><?php echo esc_html($row->dateofpayment); ?></div>
                <hr style="color:#888888" />
            </div>
        <?php endforeach; ?>
    </div>
</div>