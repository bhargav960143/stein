<?php
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $pageAction = $_REQUEST['action'];
    switch ($pageAction) {
        case "delete":
            dentalfocus_delete_convention_payments();
            break;
        case "viewinfo":
            dentalfocus_view_convention_payments();
            break;
        default:
            trentium_membership_convention_payments();
    }
} else {
    trentium_membership_convention_payments();
}
/*
    Create Function for display social media list
*/
function trentium_membership_convention_payments()
{
    /*
        Setup CSS And JS For Listing of socialmedia records.
    */
    wp_register_script('socialmedia-js', DENTALFOCUS_SCRIPTS . 'socialmedia.js', array('jquery'));
    wp_enqueue_style('socialmedia-css', DENTALFOCUS_CSS . 'socialmedia.css');

    ?>
    <div id="pageparentdiv" class="postbox">
    <h3 class="hndle ui-sortable-handle inside">
        Convention Payment List &nbsp;
    </h3>
    <div class="inside"><?php
        dentalfocus_messagedisplay();
        ?>
        <table class="wp-list-table widefat fixed" id="socialmedialist">
            <thead>
            <tr>
                <th><strong>Sr No</strong></th>
                <th><strong>Term</strong></th>
                <th><strong>Country</strong></th>
                <th><strong>Print/Digital</strong></th>
                <th><strong>Membership</strong></th>
                <th><strong>Payer ID</strong></th>
                <th><strong>Transaction ID</strong></th>
                <th><strong>Amount</strong></th>
                <th><strong>Email</strong></th>
                <th><strong>First Name</strong></th>
                <th><strong>Last Name</strong></th>
                <th><strong>Status</strong></th>
                <th><strong>Date</strong></th>
            </tr>
            </thead>
            <tbody>
            <?php
            /*
                Write Custom Query in wordpress
                Create socialmedia object for get all records from social media
            */
            $objDB = new dentalfocus_db_function();
            /*
                dentalfocus_select_all_records : Function name for get all records from table : trentium_membership_payments
            */
            $resData = $objDB->dentalfocus_select_all_records('trentium_membership_payments');
            /*
                Check records exists or not.
                IF no then display No Record Found Message.
            */
            if (count($resData) > 0) {
                $i = 0;
                foreach ($resData as $r) {
                    /*print '<pre>';
                    print_r($r);
                    print '</pre>';
                    exit;*/
                    ?>
                    <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $r['memership_term']; ?> Yr</td>
                    <td><?php echo $r['memership_country']; ?></td>
                    <td><?php echo $r['print_or_digital']; ?></td>
                    <td><?php echo $r['membership']; ?></td>
                    <td><?php echo $r['paypal_payer_id']; ?></td>
                    <td><?php echo $r['paypal_tx']; ?></td>
                    <td>$<?php echo $r['paypal_amount']; ?></td>
                    <td><?php echo $r['payer_email']; ?></td>
                    <td><?php echo $r['first_name']; ?></td>
                    <td><?php echo $r['last_name']; ?></td>
                    <td><?php echo $r['payment_status']; ?></td>
                    <td><?php echo $r['payment_date']; ?></td>
                    </tr><?php
                }

            } else {
                ?>
                <tr>
                    <td colspan="5">No Record Found!</td>
                <tr><?php
            }
            ?></tbody>
        </table>
    </div>
    </div><?php
}

/*
    Create Function for Delete Membership Settings URL
*/
function dentalfocus_delete_convention_payments()
{
    if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
        $df_social_table = 'trentium_membership_settings';
        $socialmedia_id = $_REQUEST['id'];
        $objDB = new dentalfocus_db_function();
        $arrayDeleteData = array(
            'id' => $socialmedia_id
        );
        $objDB->dentalfocus_delete_records($df_social_table, $arrayDeleteData);
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&msg=rds");
        exit;
    } else {
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&action=add&msg=swr");
        exit;
    }
}

/*
    Create Function for View How to use social Media in your page
*/
function dentalfocus_view_convention_payments()
{
    ?>
    <div class="wrap">
        <div id="pageparentdiv" class="postbox">
            <h3 class="hndle ui-sortable-handle inside">
                How to use membership sortcode?
                <a href="admin.php?page=tssettings&tab=socialmedia" style="float:right;"
                   class="button button-primary button-medium">Back</a>
            </h3>
            <div class="inside">
                <div id="message2" class="updated notice below-h2">
                    <h2>How to use?</h2>
                    <br/>
                    <p>
                        If you want to display membership form, you can use our sortcode directly.<br/><br/>
                        How to use in template?<br/><br/>
                        <strong><code>&lt;?php echo do_shortcode("[ts-membership]");
                                ?&gt;&nbsp;</code></strong><br/><br/>
                        How to use wordpress page?<br/><br/>
                        <strong><code>[ts_membership]</code></strong>
                    </p>
                </div>
            </div>
        </div>
    </div><?php
}

?>


