<style>
    .home-page .wrap-menu ul li a:before {
        display: inline-block;
        content: '';
        width: 63px;
        height: 62px;
        background: url("<?php echo esc_html(plugins_url('img/client_icons_main.png', __FILE__)); ?>") 0 0 no-repeat;
        display: inline-block;
        margin: 0 22px 0 0
    }
</style>
<div class="container">
    <div class="row header">
        <div class="col-md-4">
            <img src="<?php echo esc_html(plugins_url('img/logo.png', __FILE__)); ?>" alt="exspress-pay.by" title="express-pay.by" width="216" height="55">
        </div>
        <div class="col-md-8">
            <h2 class="text-center"><?php esc_html_e('Service «Express Payments»', 'wordpress_expresspay') ?></h2>
        </div>
    </div>
    <div class="row navbar">
        <div class="col-md-2">
            <a href="#" class="current"><?php esc_html_e('Home', 'wordpress_expresspay') ?></a>
        </div>
        <div class="col-md-2">
            <a href="<?php echo esc_html($url . '?page=invoices-and-payments'); ?>"><?php esc_html_e('Invoices and payemnts', 'wordpress_expresspay') ?></a>
        </div>
        <div class="col-md-2">
            <a href="<?php echo esc_html($url . '?page=payment-settings-list'); ?>"><?php esc_html_e('Settings', 'wordpress_expresspay') ?></a>
        </div>
        <div class="col-md-2">
            <a target="_blank" href="<?php echo esc_html('https://express-pay.by/extensions/wordpress/erip'); ?>"><?php esc_html_e('Help', 'wordpress_expresspay') ?></a>
        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="home-page">
        <div class="wrap-menu">
            <ul>
                <li class="menu_2"><a href="<?php echo esc_html($url . '?page=invoices-and-payments'); ?>">
                        <div class="text"><?php esc_html_e('Invoices and', 'wordpress_expresspay') ?> <br /> <?php esc_html_e('payemnts', 'wordpress_expresspay') ?></div>
                    </a></li>
                <li class="menu_3"><a href="<?php echo esc_html($url . '?page=payment-settings-list'); ?>">
                        <div class="text"> <?php esc_html_e('Settings', 'wordpress_expresspay') ?> </div>
                    </a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container footer">
    <div class="wrap-lm" style="display: block;  float: none; margin: 0;">
        <p style="text-align:center;"> <?php esc_html_e('© All rights reserved | LLC «TriIncom»,', 'wordpress_expresspay') ?> <?php echo esc_html(date("Y")); ?> | <a href="https://express-pay.by/" target="_blank">express-pay.by</a></p>
    </div>
</div>