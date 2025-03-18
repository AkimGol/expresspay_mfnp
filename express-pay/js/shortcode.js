jQuery(document).ready(function () {
    let expressPayAccountNumber = GetParameterValues('ExpressPayAccountNumber');
    console.log(expressPayAccountNumber);
    let type_id = GetParameterValues('type_id');
    console.log(type_id);
    let expressPayInvoiceNo = GetParameterValues('ExpressPayInvoiceNo');
    console.log(expressPayInvoiceNo);
    let signature = GetParameterValues('Signature');
    console.log(signature);
    let result = GetParameterValues('result');
    console.log(result);

    if (result == true) {
        checkInvoice(signature, expressPayAccountNumber, expressPayInvoiceNo, type_id);
    } else if (result == false) {
        checkInvoice(signature, expressPayAccountNumber, expressPayInvoiceNo, type_id);
    }

    jQuery('#expresspay-payment-submit-btn').click(function () {
        //getFormData();
    });

    jQuery('.payment-method').on('click', function () { 
        console.log('Выбрано:', jQuery(this).attr('data-id'));

        jQuery('.payment-method').removeClass('active');
        jQuery(this).addClass('active');

        let selectedPaymentMethod = jQuery(this).attr('data-id');
        let selectedPaymentMethodType = jQuery(this).attr('data-type');
        let selectedPaymentMethodName = jQuery(this).attr('data-name');

        jQuery('#selected-payment-method-type').val(selectedPaymentMethod);
        jQuery('#selected-payment-method-name').val(selectedPaymentMethodName);

        jQuery(this).find('.payment-radio').prop('checked', true);

        if (selectedPaymentMethodType !== 'card') {
            jQuery('#btn-once').addClass("active");
            jQuery('#btn-recurring').removeClass('active').prop('disabled', true);
            jQuery('#expresspay-payment-recurrency').val("false");
        } else {
            jQuery("#btn-recurring").prop('disabled', false);
        }
    });
    

    jQuery('.amount-btn').on('click', function() {
        let amount = jQuery(this).data('value'); 

        jQuery('#expresspay-payment-sum').val(amount);

        jQuery('.amount-btn').removeClass('active');
        jQuery(this).addClass('active');
    });

    jQuery('.button-group .payment-btn').click(function () {
        if (jQuery(this).prop("disabled")) return;

        jQuery('.button-group .payment-btn').removeClass('active');
        jQuery(this).addClass('active');

        jQuery('#expresspay-payment-recurrency').val(jQuery(this).val());
    });
    
    jQuery('#btn_info_step').click(function () {
        let type = jQuery('#selected-payment-method-type').val();
        let sum = jQuery('#expresspay-payment-sum').val();
        let agreementChecked = jQuery('#expresspay-agreement').is(':checked');
        let phone = jQuery('#expresspay-payment-phone').val().trim();
        let email = jQuery('#expresspay-payment-email').val().trim();
        
        if (type == undefined || isNaN(sum) || sum < 0.01) {
            return;
        }

        if (!agreementChecked) {
            return;
        }

        // if (!validatePhone(phone)) {
        //     alert("Введите корректный номер телефона в формате +375XXXXXXXXX.");
        //     return;
        // }

        // if (!validateEmail(email)) {
        //     alert("Введите корректный email.");
        //     return;
        // }

        getFormData();
    });
    
    function validatePhone(phone) {
        const phonePattern = /^\+375\d{9}$/;
        return phonePattern.test(phone);
    }

    function validateEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(email);
    }

    jQuery('#replay_btn').click(function () {
        let url = window.location.href;

        let expressPayAccountNumber = GetParameterValues('ExpressPayAccountNumber');
        let expressPayInvoiceNo = GetParameterValues('ExpressPayInvoiceNo');
        let signature = GetParameterValues('Signature');
        let type_id = GetParameterValues('type_id');

        url = url.substring(0, url.indexOf('type_id') - 1);

        window.location.href = url;
    });

    function getFormData() {
        console.log("getFormData start");

        
        let type_id = jQuery('#selected-payment-method-type').val();
        let amount = jQuery('#expresspay-payment-sum').val();

        let recurrency = jQuery('#expresspay-payment-recurrency').val();
        console.log(recurrency);

        let last_name = jQuery('#expresspay-payment-last-name').val();
        let first_name = jQuery('#expresspay-payment-name').val();
        let patronymic = jQuery('#expresspay-payment-secondname').val();
        let info = jQuery('#expresspay-payment-purpose').val();
        let email = jQuery('#expresspay-payment-email').val();
        let phone = jQuery('#expresspay-payment-phone').val();

        let url = jQuery('#ajax-url').val();

        jQuery(function ($) {
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    action: 'get_form_gata',
                    type_id: type_id,
                    amount: amount,
                    recurrency: recurrency,
                    last_name: last_name,
                    first_name: first_name,
                    patronymic: patronymic,
                    info: info,
                    email: email,
                    phone: phone,
                    url: window.location.href
                },
                success: function (response) {
                //     jQuery('#service_message').css('visibility', 'hidden');
                //     jQuery('#expresspay-payment-submit-btn').css('visibility', 'visible');
                    response = $.parseJSON(response);
                    console.log(response);

                    setFormValue(response);
                    
                    jQuery('#expresspay-payment-form').submit();
                }
            });
        });

        console.log("getFormData end");
    }

    function setFormValue(options) {
        console.log("setFormValue start");

        jQuery('#expresspay-payment-form').attr('action', options.Action);
        jQuery('#expresspay-payment-service-id').val(options.ServiceId);
        jQuery('#expresspay-payment-account-no').val(options.AccountNo);
        jQuery('#expresspay-payment-write-off-period').val(options.WriteOffPeriod);
        jQuery('#expresspay-payment-amount').val(options.Amount);
        jQuery('#expresspay-payment-currency').val(options.Currency);
        jQuery('#expresspay-payment-info').val(options.Info);
        jQuery('#expresspay-payment-surname').val(options.Surname);
        jQuery('#expresspay-payment-first-name').val(options.FirstName);
        jQuery('#expresspay-payment-patronymic').val(options.Patronymic);
        jQuery('#expresspay-payment-is-name-editable').val(options.IsNameEditable);
        jQuery('#expresspay-payment-is-address-editable').val(options.IsAddressEditable);
        jQuery('#expresspay-payment-is-amount-editable').val(options.IsAmountEditable);
        jQuery('#expresspay-payment-email-notification').val(options.EmailNotification);
        jQuery('#expresspay-payment-sms-phone').val(options.SmsPhone);
        jQuery('#expresspay-payment-signature').val(options.Signature);
        jQuery('#expresspay-payment-return-url').val(options.ReturnUrl);
        jQuery('#expresspay-payment-fail-url').val(options.FailUrl);

        console.log("setFormValue end");
    }

    function GetParameterValues(param) {
        var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < url.length; i++) {
            var urlparam = url[i].split('=');
            if (urlparam[0] == param) {
                return urlparam[1];
            }
        }
    }

    function checkInvoice(signature, account_no, invoice_no, type_id) {
        console.log("checkInvoice start");
        let url = jQuery('#ajax-url').val();
    
        jQuery('#info_step').hide(800);
        jQuery('#response_step').show(350);
        jQuery('#replay_btn').hide(800);
    
        jQuery(function ($) {
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    action: 'check_invoice',
                    type_id: type_id,
                    signature: signature,
                    account_no: account_no,
                    invoice_no: invoice_no
                },
                success: function (data) {
                    try {
                        data = $.parseJSON(data);
                        console.log(data);
    
                        if (data.status === "success") {
                            jQuery('#service_response_message').hide(800);
                            jQuery('#response_message').removeClass('fail').addClass('success');
                            jQuery('#replay_btn').show(800).html('Продолжить');
                        } else {
                            jQuery('#service_response_message').hide(800);
                            jQuery('#response_message').removeClass('success').addClass('fail');
                            jQuery('#replay_btn').show(800).html('Повторить');
                        }
                        jQuery('#response_message').html(data.message || 'Неизвестная ошибка.');
                    } catch (e) {
                        console.error("Ошибка обработки ответа:", e);
                        jQuery('#response_message').removeClass('success').addClass('fail');
                        jQuery('#replay_btn').show(800).html('Повторить');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Ошибка запроса:", status, error);
                    jQuery('#response_message').removeClass('success').addClass('fail');
                    jQuery('#response_message').html('Ошибка соединения с сервером. Проверьте подключение и попробуйте снова.');
                    jQuery('#replay_btn').show(800).html('Повторить');
                }
            });
        });
    
        console.log("checkInvoice end");
    }
    
});