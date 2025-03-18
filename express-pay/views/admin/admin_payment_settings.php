<div class="row navbar">
    <div class="col-md-2">
        <a href="<?php echo esc_html($url . '?page=expresspay-payment'); ?>"><?php esc_html_e('Home', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-2">
        <a href="<?php echo esc_html($url . '?page=invoices-and-payments'); ?>"><?php esc_html_e('Invoices and payemnts', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-2">
        <a href="<?php echo esc_html($url . '?page=payment-settings-list'); ?>" class="current"><?php esc_html_e('Settings', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-2">
        <a target="_blank" href="<?php echo esc_html('https://express-pay.by/extensions/wordpress/erip'); ?>"><?php esc_html_e('Help', 'wordpress_expresspay') ?></a>
    </div>
    <div class="col-md-6"></div>
</div>
<div class="back_link">
    <a href="#" onclick="window.history.back()"><?php esc_html_e('Back', 'wordpress_expresspay') ?></a>
</div>
<input type="hidden" id="ajax-url" value="<?php echo esc_html($ajax_url); ?>" />
<form class="payment_setting_save_page" id="payment_setting_save_page" method="post" action="<?php echo esc_html($url); ?>?page=payment-settings&id=<?php echo esc_html(sanitize_text_field($_GET['id'])); ?>">
    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_name">
                <?php esc_html_e('Payment method name', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="text" id="payment_setting_name" name="payment_setting_name" required placeholder="<?php esc_html_e('Enter the name of the payment method', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['Name']) ? $param['Name'] : ''); ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_type">
                <?php esc_html_e('Payment method type', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <select id="payment_setting_type" name="payment_setting_type" required>
                <option disabled value="" selected hidden><?php esc_html_e('Select the type of payment method', 'wordpress_expresspay') ?></option>
                <option value="erip" <?php echo esc_html(isset($param['Type']) && $param['Type'] == 'erip' ? 'selected' : ''); ?>><?php esc_html_e('ERIP', 'wordpress_expresspay') ?></option>
                <option value="card" <?php echo esc_html(isset($param['Type']) && $param['Type'] == 'card' ? 'selected' : ''); ?>><?php esc_html_e('Internet-acquiring', 'wordpress_expresspay') ?></option>
                <option value="epos" <?php echo esc_html(isset($param['Type']) && $param['Type'] == 'epos' ? 'selected' : ''); ?>><?php esc_html_e('E-POS', 'wordpress_expresspay') ?></option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_test_mode">
                <?php esc_html_e('Test mode', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="checkbox" id="payment_setting_test_mode" name="payment_setting_test_mode" <?php echo esc_html(isset($param['TestMode']) && $param['TestMode'] == 1 ? 'checked' : '') ?> />
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_token">
                <?php esc_html_e('API key', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="text" id="payment_setting_token" name="payment_setting_token" required placeholder="<?php esc_html_e('Enter API key', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['Token']) ? $param['Token'] : ''); ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_service_id">
                <?php esc_html_e('Service number', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="text" id="payment_setting_service_id" name="payment_setting_service_id" required placeholder="<?php esc_html_e('Enter service number', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['ServiceId']) ? $param['ServiceId'] : ''); ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_notification_url">
                <?php esc_html_e('Address for notifications', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="text" id="payment_setting_notification_url" value="<?php echo esc_html($notif_url); ?>" readonly />
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_secret_word">
                <?php esc_html_e('Secret word', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="text" id="payment_setting_secret_word" name="payment_setting_secret_word" placeholder="<?php esc_html_e('Enter secret word', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['SecretWord']) ? $param['SecretWord'] : ''); ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_use_signature_for_notification">
                <?php esc_html_e('Enable digital signature for notifications', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="checkbox" id="payment_setting_use_signature_for_notification" name="payment_setting_use_signature_for_notification" <?php echo esc_html(isset($param['UseSignatureForNotification']) && $param['UseSignatureForNotification'] == 1 ? 'checked' : '') ?> />
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_secret_word_for_notification">
                <?php esc_html_e('Secret word for notifications', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="text" id="payment_setting_secret_word_for_notification" name="payment_setting_secret_word_for_notification" placeholder="<?php esc_html_e('Enter secret word for notifications', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['SecretWordForNotification']) ? $param['SecretWordForNotification'] : ''); ?>" />
        </div>
    </div>

    <hr />


    <div id="erip_setting">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label for="payment_setting_show_qr_code">
                    <?php esc_html_e('Show QR code', 'wordpress_expresspay') ?>
                </label>
            </div>
            <div class="col-md-9 col-xs-12">
                <input type="checkbox" id="payment_setting_show_qr_code" value="1" name="payment_setting_show_qr_code" <?php echo esc_html(isset($param['ShowQrCode']) && $param['ShowQrCode'] == 1 ? 'checked' : '') ?> />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label for="payment_setting_can_change_name">
                    <?php esc_html_e('Allowed to change name', 'wordpress_expresspay') ?>
                </label>
            </div>
            <div class="col-md-9 col-xs-12">
                <input type="checkbox" id="payment_setting_can_change_name" name="payment_setting_can_change_name" <?php echo esc_html(isset($param['CanChangeName']) && $param['CanChangeName'] == 1 ? 'checked' : '') ?> />

            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label for="payment_setting_can_change_address">
                    <?php esc_html_e('Allowed to change address', 'wordpress_expresspay') ?>
                </label>
            </div>
            <div class="col-md-9 col-xs-12">
                <input type="checkbox" id="payment_setting_can_change_address" name="payment_setting_can_change_address" <?php echo esc_html(isset($param['CanChangeAddress']) && $param['CanChangeAddress'] == 1 ? 'checked' : '') ?> />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label for="payment_setting_can_change_amount">
                    <?php esc_html_e('Allowed to change amount', 'wordpress_expresspay') ?>
                </label>
            </div>
            <div class="col-md-9 col-xs-12">
                <input type="checkbox" id="payment_setting_can_change_amount" name="payment_setting_can_change_amount" <?php echo esc_html(isset($param['CanChangeAmount']) && $param['CanChangeAmount'] == 1 ? 'checked' : '') ?> />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label for="payment_setting_send_email_notification">
                    <?php esc_html_e('Send email notification to client', 'wordpress_expresspay') ?>
                </label>
            </div>
            <div class="col-md-9 col-xs-12">
                <input type="checkbox" id="payment_setting_send_email_notification" name="payment_setting_send_email_notification" <?php echo esc_html(isset($param['SendEmail']) && $param['SendEmail'] == 1 ? 'checked' : '') ?> />
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label for="payment_setting_send_sms_notification">
                    <?php esc_html_e('Send sms notification to the client', 'wordpress_expresspay') ?>
                </label>
            </div>
            <div class="col-md-9 col-xs-12">
                <input type="checkbox" id="payment_setting_send_sms_notification" name="payment_setting_send_sms_notification" <?php echo esc_html(isset($param['SendSms']) && $param['SendSms'] == 1 ? 'checked' : '') ?> />
            </div>
        </div>

        <hr />
    </div>

    <div class="row" id="erip_setting_path">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_erip_path">
                <?php esc_html_e('Path along the ERIP branch', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="text" id="payment_setting_erip_path" name="payment_setting_erip_path" placeholder="<?php esc_html_e('Enter Path along the ERIP branch', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['EripPath']) ? $param['EripPath'] : ''); ?>" />
        </div>
    </div>

    <div id="epos_setting">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label for="payment_setting_service_provider_code">
                    <?php esc_html_e('Service provider code', 'wordpress_expresspay') ?>
                </label>
            </div>
            <div class="col-md-9 col-xs-12">
                <input type="text" id="payment_setting_service_provider_code" name="payment_setting_service_provider_code" placeholder="<?php esc_html_e('Enter service provider code', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['ServiceProviderCode']) ? $param['ServiceProviderCode'] : ''); ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label for="payment_setting_service_epos_code">
                    <?php esc_html_e('E-POS service code', 'wordpress_expresspay') ?>
                </label>
            </div>
            <div class="col-md-9 col-xs-12">
                <input type="text" id="payment_setting_service_epos_code" name="payment_setting_service_epos_code" placeholder="<?php esc_html_e('Enter E-POS service code', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['ServiceEposCode']) ? $param['ServiceEposCode'] : ''); ?>" />
            </div>
        </div>
        <hr />
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_api_url">
                <?php esc_html_e('API address', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="text" id="payment_setting_api_url" name="payment_setting_api_url" required placeholder="<?php esc_html_e('Enter API address', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['ApiUrl']) ? $param['ApiUrl'] : ''); ?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <label for="payment_setting_sandbox_url">
                <?php esc_html_e('Test API address', 'wordpress_expresspay') ?>
            </label>
        </div>
        <div class="col-md-9 col-xs-12">
            <input type="text" id="payment_setting_sandbox_url" name="payment_setting_sandbox_url" required placeholder="<?php esc_html_e('Enter test API address', 'wordpress_expresspay') ?>" value="<?php echo esc_html(isset($param['SandboxUrl']) ? $param['SandboxUrl'] : ''); ?>" />
        </div>
    </div>


    <div class="row">
        <div class="col-md-offset-5 col-md-7">
            <input class="button-blue button-action" type="submit" value="<?php esc_html_e('Save', 'wordpress_expresspay') ?>">
            <input class="button-orange button-action" style="margin-left: 4px;" type="button" onclick="window.location.href='<?php echo esc_html($url . '?page=payment-settings-list'); ?>'" value="<?php esc_html_e('Cancel', 'wordpress_expresspay') ?>">
        </div>
    </div>

</form>