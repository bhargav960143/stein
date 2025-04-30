jQuery(document).ready(function ($) {
    $('#membershippaymentlist').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: TrentiumAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'trentium_membership_payment_ajax_list',
                security: TrentiumAjax.nonce
            }
        },
        order: [[12, 'desc']], // 👈 12 = "payment_date" column index (0-based)
        columns: [
            { data: 'sr_no' },
            { data: 'memership_term' },
            { data: 'memership_country' },
            { data: 'print_or_digital' },
            { data: 'membership' },
            { data: 'paypal_payer_id' },
            { data: 'paypal_tx' },
            { data: 'paypal_amount' },
            { data: 'payer_email' },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'payment_status' },
            { data: 'payment_date' }
        ]
    });
});
