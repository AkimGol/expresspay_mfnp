<style>
    i.icon,
    a.icon {
        background-image: url("<?php echo esc_html(plugins_url('img/icons_grid15x.png', __FILE__)); ?>") !important;
        background-position: 0 0;
        background-repeat: no-repeat;
        height: 22px;
        width: 24px;
        display: inline-block;
        cursor: pointer;
        position: relative;
        margin-right: 10px;
    }
</style>
<div class="row navbar">
    <div class="col-md-2">
        <a href="<?php echo esc_html('?page=expresspay-payment'); ?>"><?php esc_html_e('Home', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-2">
        <a href="<?php echo esc_html($url . '?page=invoices-and-payments'); ?>"><?php esc_html_e('Invoices and payemnts', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-2">
        <a href="#" class="current"><?php esc_html_e('Settings', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-2">
        <a target="_blank" href="<?php echo esc_html('https://express-pay.by/extensions/wordpress/erip'); ?>"><?php esc_html_e('Help', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-6"></div>
</div>
<div class="back_link">
    <a href="#" onclick="window.history.back()"><?php esc_html_e('Back', 'wordpress_expresspay') ?></a>
</div>
<div class="add_pay_method_link">
    <a href="<?php echo esc_html($url . '?page=payment-settings&id=0'); ?>"><?php esc_html_e('Add a payment method', 'wordpress_expresspay') ?></a>
</div>
<div class="row">
    <div class="header-table col-md-12">
        <div class="col-md-3"><?php esc_html_e('Name', 'wordpress_expresspay') ?></div>
        <div class="col-md-3"><?php esc_html_e('Type of', 'wordpress_expresspay') ?></div>
        <div class="col-md-2"><?php esc_html_e('Status', 'wordpress_expresspay') ?></div>
        <div class="col-md-4"><?php esc_html_e('Options', 'wordpress_expresspay') ?></div>
    </div>
    <div class="content col-md-12" style="text-align: center;">
        <?php foreach ($response as $row) : ?>
            <div class="table-row">
                <div class="col-md-3"><?php echo esc_html($row->name); ?></div>
                <div class="col-md-3"><?php 
                switch ($row->type):
                    case 'erip':
                        esc_html_e('ERIP', 'wordpress_expresspay');
                    break;
                    case 'card':
                        esc_html_e('Internet-acquiring', 'wordpress_expresspay');
                    break;
                    case 'epos';
                        esc_html_e('E-POS', 'wordpress_expresspay');
                    break;
                    endswitch; ?></div>
                <div class="col-md-2">
                    <?php if ($row->isactive == 1) : ?>
                        <p class="active"><?php esc_html_e('Active', 'wordpress_expresspay') ?></p>
                    <?php else : ?>
                        <p class="diactive"><?php esc_html_e('Disable', 'wordpress_expresspay') ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <a class="icon icon_edit" title="<?php esc_html_e('Edit', 'wordpress_expresspay') ?>" href="?page=payment-settings&id=<?php echo esc_html($row->id); ?>"></a>
                    <?php if ($row->isactive == 1) :?>
                        <a class="icon icon_stop" onclick="paymentMethodOptions('payment_setting_off', <?php echo esc_html($row->id); ?>)" title="<?php esc_html_e('Disable', 'wordpress_expresspay') ?>"></a>
                    <?php else : ?>
                        <a class="icon icon_on"  onclick="paymentMethodOptions('payment_setting_on', <?php echo esc_html($row->id); ?>)" title="<?php esc_html_e('Enable', 'wordpress_expresspay') ?>"></a>
                    <?php endif; ?>
                    <a class="icon icon_delete"  onclick="paymentMethodOptions('payment_setting_delete', <?php echo esc_html($row->id); ?>)" title="<?php esc_html_e('Delete', 'wordpress_expresspay') ?>"></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>