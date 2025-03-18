<div class="expresspay-payment" id="expresspay-payment">
    <div class="expresspay-payment-header">
        <div class="logo">
            <img src="<?php echo esc_html(plugins_url('admin/img/logo.png', __FILE__)); ?>" alt="exspress-pay.by" title="express-pay.by">
        </div>
    </div>
    <div class="row error_panel">
        <p></p>
    </div>
    <input type="hidden" id="ajax-url" value="<?php echo esc_html($ajax_url); ?>" />

    <div class="info_step" id="info_step">
        <?php foreach ($response as $row) : ?>
            <?php $options = json_decode($row->options); ?>
            <div class="payment-method" data-id="<?php echo esc_html($row->id); ?>" data-type="<?php echo esc_html($row->type); ?>" data-name="<?php echo esc_html($row->name); ?>">
                <input type="radio" name="payment_method_radio" value="<?php echo esc_html($row->type); ?>" class="payment-radio">
                <div class="payment-icon">
                    <img src="<?php echo esc_url(plugins_url('views/admin/icons/' . esc_html($row->type) . '.png', dirname(__FILE__))); ?>" alt="icon">
                </div>
                <div class="payment-name">
                    <?php echo esc_html($row->name); ?>
                </div>
            </div>
        <?php endforeach; ?>
        <input type="hidden" id="selected-payment-method-type" name="payment_method" value="">
        <input type="hidden" id="selected-payment-method-name" name="payment_method_name" value="">
        
        <div class="row">
            <div class="label">
                <label for="expresspay-payment-sum"><?php esc_html_e('Amount', 'wordpress_expresspay') ?></label>
            </div>
            <div class="field">
                <div class="amount-buttons">
                    <button type="button" class="amount-btn" data-value="5">5 BYN</button>
                    <button type="button" class="amount-btn" data-value="10">10 BYN</button>
                    <button type="button" class="amount-btn" data-value="20">20 BYN</button>
                    <button type="button" class="amount-btn" data-value="50">50 BYN</button>
                </div>
                <input type="text" id="expresspay-payment-sum" placeholder="<?php esc_html_e('Enter amount', 'wordpress_expresspay') ?>" />
            </div>
        </div>

        <div class="row">
            <div class="label">
                <label><?php esc_html_e('Payment type', 'wordpress_expresspay') ?></label>
            </div>
            <div class="field">
                <div class="button-group">
                    <button type="button" id="btn-once" class="payment-btn active" value="false">
                        <?php echo 'Единоразово' ?>
                    </button>
                    <button type="button" id="btn-recurring" class="payment-btn" value="true">
                        <?php echo 'Ежемесячно' ?>
                    </button>
                </div>
                <input type="hidden" id="expresspay-payment-recurrency" name="recurrency" value="false">
            </div>
        </div>

        <div class="fio-section" id='fio-section'>
            <div class="row">
                <div class="label">
                    <label for="expresspay-payment-last-name"><?php esc_html_e('Surname', 'wordpress_expresspay') ?></label>
                </div>
                <div class="field">
                    <input type="text" id="expresspay-payment-last-name" placeholder="<?php esc_html_e('Enter surname', 'wordpress_expresspay') ?>" />
                </div>
            </div>
            <div class="row">
                <div class="label">
                    <label for="expresspay-payment-name"><?php esc_html_e('Name', 'wordpress_expresspay') ?></label>
                </div>
                <div class="field">
                    <input type="text" id="expresspay-payment-name" placeholder="<?php esc_html_e('Enter name', 'wordpress_expresspay') ?>" />
                </div>
            </div>
        </div>

        <div class="row" id="expresspay-payment-email-container">
            <div class="label">
                <label for="expresspay-payment-email"><?php esc_html_e('E-mail', 'wordpress_expresspay') ?></label>
            </div>
            <div class="field">
                <input type="text" id="expresspay-payment-email" placeholder="<?php esc_html_e('Enter e-mail', 'wordpress_expresspay') ?>" />
            </div>
        </div>

        <div class="row" id="expresspay-payment-phone-container">
            <div class="label">
                <label for="expresspay-payment-phone"><?php esc_html_e('Mobile number', 'wordpress_expresspay') ?></label>
            </div>
            <div class="field">
                <input type="text" id="expresspay-payment-phone" placeholder="<?php esc_html_e('Enter mobile number', 'wordpress_expresspay') ?>" />
            </div>
        </div>

        <div class="row expresspay-agreement">
            <input type="checkbox" id="expresspay-agreement" />
            <label for="expresspay-agreement">
                <?php echo 'Я согласен с условиями '; ?>
                <a href="https://mfnp.by/wp-content/uploads/2025/02/%D0%9F%D1%83%D0%B1%D0%BB%D0%B8%D1%87%D0%BD%D0%B0%D1%8F_%D0%BE%D1%84%D0%B5%D1%80%D1%82%D0%B0_%D0%A4%D0%BE%D0%BD%D0%B4_%D0%9D%D0%9E%D0%92%D0%AB%D0%99_%D0%9F%D0%9E%D0%9B%D0%9E%D0%A6%D0%9A.pdf" class="expresspay-agreement-link" target="_blank">
                    <?php echo 'публичной оферты'; ?>
                </a> 
            </label>
        </div>

        <form class="expresspay-payment-form" method="POST" id="expresspay-payment-form">
            <input type="hidden" name="ServiceId" id="expresspay-payment-service-id" value="" />
            <input type="hidden" name="WriteOffPeriod" id="expresspay-payment-write-off-period" value="" />
            <input type="hidden" name="AccountNo" id="expresspay-payment-account-no" value="" />
            <input type="hidden" name="Amount" id="expresspay-payment-amount" value="" />
            <input type="hidden" name="Currency" id="expresspay-payment-currency" value="" />
            <input type="hidden" name="Info" id="expresspay-payment-info" value="Безвозмездное пожертвование" />
            <input type="hidden" name="Surname" id="expresspay-payment-surname" value="" />
            <input type="hidden" name="FirstName" id="expresspay-payment-first-name" value="" />
            <input type="hidden" name="Patronymic" id="expresspay-payment-patronymic" value="" />
            <input type="hidden" name="IsNameEditable" id="expresspay-payment-is-name-editable" value="" />
            <input type="hidden" name="IsAddressEditable" id="expresspay-payment-is-address-editable" value="" />
            <input type="hidden" name="IsAmountEditable" id="expresspay-payment-is-amount-editable" value="" />
            <input type="hidden" name="EmailNotification" id="expresspay-payment-email-notification" value="" />
            <input type="hidden" name="ReturnType" id="expresspay-payment-return-type" value="redirect" />
            <input type="hidden" name="ReturnUrl" id="expresspay-payment-return-url" value="" />
            <input type="hidden" name="FailUrl" id="expresspay-payment-fail-url" value="" />
            <input type="hidden" name="SmsPhone" id="expresspay-payment-sms-phone" value="" />
            <input type="hidden" name="Signature" id="expresspay-payment-signature" value="" />
        </form>

        <div class="row">
            <button class="confirm_btn" id="btn_info_step"><?php esc_html_e('Pay', 'wordpress_expresspay') ?></button>
        </div>
    </div>
    
    <div class="response_step" id="response_step">
        <div class="row">
            <p id="service_response_message"></p>
            <p id="response_message"></p>
        </div>
        <div class="row">
            <button class="btn confirm_btn" id="replay_btn"><?php esc_html_e('Repeat', 'wordpress_expresspay') ?></button>
        </div>
    </div>
</div>