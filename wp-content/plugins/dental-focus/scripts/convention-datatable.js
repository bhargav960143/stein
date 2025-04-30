jQuery(document).ready(function ($) {
    $('#socialmedialist').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: TrentiumAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'trentium_convention_ajax_list',
                security: TrentiumAjax.nonce
            }
        },
        columns: [
            { data: 'sr_no' },
            { data: 'member_name' },
            { data: 'member_email' },
            { data: 'member_phone' },
            { data: 'grand_total' },
            { data: 'paid' },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});
