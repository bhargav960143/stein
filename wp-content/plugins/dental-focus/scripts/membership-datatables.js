jQuery(document).ready(function ($) {
    $('#membershiplist').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: TrentiumAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'trentium_membership_ajax_list',
                security: TrentiumAjax.nonce
            }
        },
        columns: [
            { data: 'member_no' },
            { data: 'username' },
            { data: 'customer_email' },
            { data: 'customer_first_name' },
            { data: 'customer_last_name' },
            { data: 'customer_country' },
            { data: 'customer_home_phone' },
            { data: 'customer_mobile_phone' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});
