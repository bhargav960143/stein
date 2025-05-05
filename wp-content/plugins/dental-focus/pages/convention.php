<?php
require_once dirname(__DIR__, 1) . '/vendor/autoload.php';
use Dompdf\Dompdf;
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $pageAction = $_REQUEST['action'];
    switch ($pageAction) {
        case "delete":
            dentalfocus_delete_convention_payments();
            break;
        case "viewinfo":
            dentalfocus_view_convention_payments();
            break;
        case "download":
            dentalfocus_download_convention_payments();
            break;
        default:
            trentium_membership_convention_list_payments();
    }
} else {
    trentium_membership_convention_list_payments();
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
                <th><strong>Member Name</strong></th>
                <th><strong>Member Email</strong></th>
                <th><strong>Member Phone</strong></th>
                <th><strong>Grand Total</strong></th>
                <th><strong>Paid</strong></th>
                <th><strong>Date</strong></th>
                <th style="text-align:center;"><strong>Action</strong></th>
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
            $resData = $objDB->dentalfocus_con_all_records('trentium_con_payments');
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
                    <td><?php echo $r['member_name']; ?></td>
                    <td><?php echo $r['member_email']; ?></td>
                    <td><?php echo $r['member_phone']; ?></td>
                    <td>$<?php echo $r['grand_total']; ?></td>
                    <td><?php if(!empty($r['paypal_payer_id'])){ echo 'Yes'; } else{ echo 'No'; } ?></td>
                    <td><?php echo $r['created_at']; ?></td>
                    <td style="text-align:center;">
                        <a class="button button-secondary"
                           href="admin.php?page=tssettings&tab=convention&action=viewinfo&id=<?php echo $r['id']; ?>">View</a>
                    </td>
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
function trentium_membership_convention_list_payments()
{
    /*
        Setup CSS And JS For Listing of socialmedia records.
    */
    wp_enqueue_style('datatables-css', 'https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css');
    wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', ['jquery'], null, true);

    wp_enqueue_script('custom-convention-js', DENTALFOCUS_SCRIPTS . 'convention-datatable.js', ['jquery', 'datatables-js'], null, true);
    wp_localize_script('custom-convention-js', 'TrentiumAjax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('trentium_convention_nonce')
    ]);

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
                <th>Sr No</th>
                <th>Member Name</th>
                <th>Member Email</th>
                <th>Member Phone</th>
                <th>Grand Total</th>
                <th>Paid</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
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
$df_social_table = 'trentium_convention';
if(!isset($_REQUEST['id']) || empty($_REQUEST['id'])){
    wp_redirect("admin.php?page=tssettings&tab=convention&msg=swr");
    exit;
}
$socialmedia_id = $_REQUEST['id'];
$arrayEditData = array(
    'id' => intval($socialmedia_id)
);
$objDB = new dentalfocus_db_function();
$resData = $objDB->dentalfocus_edit_records($df_social_table,$arrayEditData);



$df_social_table = 'trentium_convention';
$df_social_table1 = 'trentium_con_payments';
if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
    wp_redirect("admin.php?page=tssettings&tab=convention&msg=imn");
    exit;
}
$socialmedia_id = $_REQUEST['id'];
$arrayEditData = array(
    'id' => intval($socialmedia_id)
);
$objDB = new dentalfocus_db_function();
$resData = $objDB->dentalfocus_edit_records($df_social_table, $arrayEditData);
$resDataPayment = NULL;
if (isset($resData['id']) && !empty($resData['id'])) {
    $arrayEditData1 = array(
        'con_id' => $resData['id']
    );
    $resDataPayment = $objDB->dentalfocus_edit_records($df_social_table1, $arrayEditData1);
}
?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("#form-socialmedia").validationEngine();
        });
    </script>
    <div id="pageparentdiv" class="postbox">
        <h3 class="hndle ui-sortable-handle inside">
            View SCI Convention Payment Details
            <a href="admin.php?page=tssettings&tab=convention" style="float:right;"
               class="button button-primary button-medium">Back</a>
            <a href="admin.php?page=tssettings&tab=convention&action=download&id=<?php echo $socialmedia_id; ?>"
               class="button button-primary" target="_blank">Download PDF</a>
        </h3>
        <div class="inside"><?php
            dentalfocus_messagedisplay();
            ?>
            <div class="row">
                <h1>Member Details:</h1>
                <h2 style="color: dodgerblue"><?php echo $resData['member_name']; ?></h2>
            </div>
            <table width="100%" border="1px" cellspacing="0" cellpadding="6">
                <tr>
                    <th colspan="2">LIST ATTENDEES</th>
                    <th>First timer?</th>
                    <th>Preferred names for badges</th>
                </tr>
                <tr>
                    <td>
                        <label><strong>MEMBER</strong> name</label>
                    </td>
                    <td>
                        <?php echo $resData['member_name']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['first_member']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['member_badge']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><strong>Spouse/Partner</strong></label>
                    </td>
                    <td>
                        <?php echo $resData['spouse_name']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['first_spouse']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['spouse_badge']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><strong>Guest 1</strong></label>
                    </td>
                    <td>
                        <?php echo $resData['guest1_name']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['first_guest1']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['guest1_badge']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><strong>Guest 2</strong></label>
                    </td>
                    <td>
                        <?php echo $resData['guest2_name']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['first_guest2']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['guest2_badge']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><strong>Special needs?</strong></label>
                    </td>
                    <td colspan="3">
                        <?php echo $resData['special_needs']; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <th colspan="4">MEMBER'S CONTACT INFORMATION</th>
                </tr>
                <tr>
                    <td>
                        <label><strong>Mailing address</strong></label><br>
                        <label><strong>address line 1</strong> <?php echo $resData['address_line1']; ?></label><br>
                        <label><strong>address line 2</strong> <?php echo $resData['address_line2']; ?></label><br>
                        <label><strong>address line 3</strong> <?php echo $resData['address_line3']; ?></label><br>
                        <label><strong>address line 4</strong> <?php echo $resData['address_line4']; ?></label><br>
                    </td>
                    <td colspan="3">
                        <table width="100%" cellpadding="5" border="1" cellspacing="0">
                            <tr>
                                <td><label><strong>SCI Nbr:</strong> </label></td>
                                <td><?php echo $resData['member_nbr']; ?></td>
                            </tr>
                            <tr>
                                <td><label><strong>phone:</strong> </label></td>
                                <td><?php echo $resData['member_phone']; ?></td>
                            </tr>
                            <tr>
                                <td><label><strong>cell:</strong> </label></td>
                                <td><?php echo $resData['member_cell']; ?></td>
                            </tr>
                            <tr>
                                <td><label><strong>email:</strong> </label></td>
                                <td><?php echo $resData['member_email']; ?></td>
                            </tr>
                            <tr>
                                <td><label><strong>chapter:</strong> </label></td>
                                <td><?php echo $resData['chapter_select']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">REGISTRATION FEES</td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>Amount</td>
                    <td>Qty</td>
                    <td>Amount</td>
                </tr>






                <tr>
                    <td >
                        Single - Includes one convention stein =================================================>
                    </td>
                    <td>$<?php echo $resData['price_single']; ?></td>
                    <td><?php echo $resData['qty_single']; ?></td>
                    <td>$<?php echo $resData['total_single']; ?></td>
                </tr>
                <tr>
                    <td >
                        Couple - Includes one convention stein ================================================>
                    </td>
                    <td>$<?php echo $resData['price_couple']; ?></td>
                    <td><?php echo $resData['qty_couple']; ?></td>
                    <td>$<?php echo $resData['total_couple']; ?></td>
                </tr>
                <tr>
                    <th colspan="4">ADDITIONAL OPTIONS AND EVENTS</th>
                </tr>
                <tr>
                    <td >
                        Monday AM August 11 – Molly’s Trolley City Tour (10:00 AM – 1:00 PM)
                    </td>
                    <td>$<?php echo $resData['price_event1']; ?></td>
                    <td><?php echo $resData['qty_event1']; ?></td>
                    <td>$<?php echo $resData['total_event1']; ?></td>
                </tr>
                <tr>
                    <td >
                        Monday PM August 11 – Walking Tour of Downtown (2:00 PM – 4:00 PM)
                    </td>
                    <td>$<?php echo $resData['price_event2']; ?></td>
                    <td><?php echo $resData['qty_event2']; ?></td>
                    <td>$<?php echo $resData['total_event2']; ?></td>
                </tr>
                <tr>
                    <td >
                        Tuesday AM August 12 – Fallingwater (8:00 AM – 4:00 PM) (Lunch included – 55 people max)
                    </td>
                    <td>$<?php echo $resData['price_event3']; ?></td>
                    <td><?php echo $resData['qty_event3']; ?></td>
                    <td>$<?php echo $resData['total_event3']; ?></td>
                </tr>
                <tr>
                    <th colspan="4" style="background-color: #0ecad4;color: black">Wednesday, August 13 - Live stein auction conducted by Fox Auctions (open to the public)</th>
                </tr>
                <tr>
                    <td >
                        Friday, August 15 - Afternoon Tea (Wyndham Grand – Sky Lounge)
                    </td>
                    <td>$<?php echo $resData['price_tea']; ?></td>
                    <td><?php echo $resData['qty_tea']; ?></td>
                    <td>$<?php echo $resData['total_tea']; ?></td>
                </tr>
                <tr>
                    <td >
                        Stein sales room - Full table - registered attendees only
                    </td>
                    <td>$<?php echo $resData['price_full_tables']; ?></td>
                    <td><?php echo $resData['qty_full_tables']; ?></td>
                    <td>$<?php echo $resData['total_full_tables']; ?></td>
                </tr>
                <tr>
                    <td >
                        Stein sales room - Half table - registered attendees only
                    </td>
                    <td>$<?php echo $resData['price_half_tables']; ?></td>
                    <td><?php echo $resData['qty_half_tables']; ?></td>
                    <td>$<?php echo $resData['total_half_tables']; ?></td>
                </tr>
                <tr>
                    <td >
                        Additional convention steins (subject to availability)
                    </td>
                    <td>$<?php echo $resData['price_steins']; ?></td>
                    <td><?php echo $resData['qty_steins']; ?></td>
                    <td>$<?php echo $resData['total_steins']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right">
                        <strong>GRAND TOTAL</strong>
                    </td>
                    <td>$<?php echo $resData['grand_total']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right">
                        The minimum required deposit is 50% of the total of all fees.  <strong>MINIMUM DEPOSIT</strong>
                    </td>
                    <td>$<?php echo $resData['minimum_deposit']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right">
                        <strong style="color:blue">IF YOU WANT TO PAY MORE THAN THE MINIMUM, ENTER AMOUNT HERE </strong>
                    </td>
                    <td>$<?php echo $resData['amount_to_pay']; ?></td>
                </tr>
                <tr>
                    <th colspan="6" style="background-color: #0ecad4;color: black">OTHER CHOICES YOU NEED TO MAKE (and don't forget to click SUBMIT below when you are done)</th>
                </tr>
                <tr>
                    <td colspan="6">
                        <table width="100%" cellpadding="5" border="1" cellspacing="0">
                            <tr>
                                <td colspan="4"><strong style="color:blue">THURSDAY evening (August 14) in the hotel - German Night - Indicate quantity for each entree choice</strong></td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_thursday_dinner']; ?></td>
                                <td>Please indicate how many of your party will attend, then enter the quantity for each entree</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_thurs_entree1']; ?></td>
                                <td>German Sausage Sampler</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_thurs_entree2']; ?></td>
                                <td>Brined Seared Pork Tenderloin</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table width="100%" cellpadding="5" border="1" cellspacing="0">
                            <tr>
                                <td colspan="4"><strong style="color:blue">SATURDAY evening dinner (August 16) in the hotel</strong></td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_saturday_dinner']; ?></td>
                                <td>Please indicate how many of your party will attend. - Indicate quantity for each entree choice.</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_sat_entree1']; ?></td>
                                <td>Seared Pierre Breast of Chicken</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_sat_entree2']; ?></td>
                                <td>Seared Salmon</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_sat_entree3']; ?></td>
                                <td>Flat Iron Steak</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_sat_entree4']; ?></td>
                                <td>Vegetarian Entrée</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div><?php
}

function dentalfocus_download_convention_payments() {
    // Clear all possible output buffers before starting
    while (ob_get_level()) {
        ob_end_clean();
    }

    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=convention-details.pdf");
    header("Cache-Control: private, max-age=0, must-revalidate");
    header("Pragma: public");

    $df_social_table = 'trentium_convention';
    if(!isset($_REQUEST['id']) || empty($_REQUEST['id'])){
        wp_redirect("admin.php?page=tssettings&tab=convention&msg=swr");
        exit;
    }
    $socialmedia_id = $_REQUEST['id'];
    $arrayEditData = array(
        'id' => intval($socialmedia_id)
    );
    $objDB = new dentalfocus_db_function();
    $resData = $objDB->dentalfocus_edit_records($df_social_table,$arrayEditData);



    $df_social_table = 'trentium_convention';
    $df_social_table1 = 'trentium_con_payments';
    if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
        wp_redirect("admin.php?page=tssettings&tab=convention&msg=imn");
        exit;
    }
    $socialmedia_id = $_REQUEST['id'];
    $arrayEditData = array(
        'id' => intval($socialmedia_id)
    );
    $objDB = new dentalfocus_db_function();
    $resData = $objDB->dentalfocus_edit_records($df_social_table, $arrayEditData);
    $resDataPayment = NULL;
    if (isset($resData['id']) && !empty($resData['id'])) {
        $arrayEditData1 = array(
            'con_id' => $resData['id']
        );
        $resDataPayment = $objDB->dentalfocus_edit_records($df_social_table1, $arrayEditData1);
    }

    // Start fresh output buffering for HTML content
    ob_start();
    ?>
    <html>
    <head>
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 10px; margin: 0;
                padding: 0;}
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #000; padding: 2px; }
            h2, h3 { text-align: center; }
            @page {
                margin: 5px 5px 5px 5px; /* You can reduce this further if needed */
                padding: 5px 5px 5px 5px;
            }
        </style>
    </head>
    <body>
    <div id="pageparentdiv" class="postbox">
        <div class="inside">
            <div class="row">
                <h1>Member Details: <span style="color: dodgerblue"><?php echo $resData['member_name']; ?></span></h1>
            </div>
            <table width="90%" border="1px" cellspacing="0" cellpadding="1">
                <tr>
                    <th colspan="2">LIST ATTENDEES</th>
                    <th>First timer?</th>
                    <th>Preferred names for badges</th>
                </tr>
                <tr>
                    <td>
                        <label><strong>MEMBER</strong> name</label>
                    </td>
                    <td>
                        <?php echo $resData['member_name']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['first_member']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['member_badge']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><strong>Spouse/Partner</strong></label>
                    </td>
                    <td>
                        <?php echo $resData['spouse_name']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['first_spouse']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['spouse_badge']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><strong>Guest 1</strong></label>
                    </td>
                    <td>
                        <?php echo $resData['guest1_name']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['first_guest1']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['guest1_badge']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><strong>Guest 2</strong></label>
                    </td>
                    <td>
                        <?php echo $resData['guest2_name']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['first_guest2']; ?>
                    </td>
                    <td style="text-script: center">
                        <?php echo $resData['guest2_badge']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><strong>Special needs?</strong></label>
                    </td>
                    <td colspan="3">
                        <?php echo $resData['special_needs']; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <th colspan="4">MEMBER'S CONTACT INFORMATION</th>
                </tr>
                <tr>
                    <td>
                        <label><strong>Mailing address</strong></label><br>
                        <label><strong>address line 1</strong> <?php echo $resData['address_line1']; ?></label><br>
                        <label><strong>address line 2</strong> <?php echo $resData['address_line2']; ?></label><br>
                        <label><strong>address line 3</strong> <?php echo $resData['address_line3']; ?></label><br>
                        <label><strong>address line 4</strong> <?php echo $resData['address_line4']; ?></label><br>
                    </td>
                    <td colspan="3">
                        <table width="93%" cellpadding="0" border="1" cellspacing="0">
                            <tr>
                                <td><label><strong>SCI Nbr:</strong> </label></td>
                                <td><?php echo $resData['member_nbr']; ?></td>
                            </tr>
                            <tr>
                                <td><label><strong>phone:</strong> </label></td>
                                <td><?php echo $resData['member_phone']; ?></td>
                            </tr>
                            <tr>
                                <td><label><strong>cell:</strong> </label></td>
                                <td><?php echo $resData['member_cell']; ?></td>
                            </tr>
                            <tr>
                                <td><label><strong>email:</strong> </label></td>
                                <td><?php echo $resData['member_email']; ?></td>
                            </tr>
                            <tr>
                                <td><label><strong>chapter:</strong> </label></td>
                                <td><?php echo $resData['chapter_select']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">REGISTRATION FEES</td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>Amount</td>
                    <td>Qty</td>
                    <td>Amount</td>
                </tr>
                <tr>
                    <td >
                        Single - Includes one convention stein =================================================>
                    </td>
                    <td>$<?php echo $resData['price_single']; ?></td>
                    <td><?php echo $resData['qty_single']; ?></td>
                    <td>$<?php echo $resData['total_single']; ?></td>
                </tr>
                <tr>
                    <td >
                        Couple - Includes one convention stein ================================================>
                    </td>
                    <td>$<?php echo $resData['price_couple']; ?></td>
                    <td><?php echo $resData['qty_couple']; ?></td>
                    <td>$<?php echo $resData['total_couple']; ?></td>
                </tr>
                <tr>
                    <th colspan="4">ADDITIONAL OPTIONS AND EVENTS</th>
                </tr>
                <tr>
                    <td >
                        Monday AM August 11 – Molly’s Trolley City Tour (10:00 AM – 1:00 PM)
                    </td>
                    <td>$<?php echo $resData['price_event1']; ?></td>
                    <td><?php echo $resData['qty_event1']; ?></td>
                    <td>$<?php echo $resData['total_event1']; ?></td>
                </tr>
                <tr>
                    <td >
                        Monday PM August 11 – Walking Tour of Downtown (2:00 PM – 4:00 PM)
                    </td>
                    <td>$<?php echo $resData['price_event2']; ?></td>
                    <td><?php echo $resData['qty_event2']; ?></td>
                    <td>$<?php echo $resData['total_event2']; ?></td>
                </tr>
                <tr>
                    <td >
                        Tuesday AM August 12 – Fallingwater (8:00 AM – 4:00 PM) (Lunch included – 55 people max)
                    </td>
                    <td>$<?php echo $resData['price_event3']; ?></td>
                    <td><?php echo $resData['qty_event3']; ?></td>
                    <td>$<?php echo $resData['total_event3']; ?></td>
                </tr>
                <tr>
                    <th colspan="4" style="background-color: #0ecad4;color: black">Wednesday, August 13 - Live stein auction conducted by Fox Auctions (open to the public)</th>
                </tr>
                <tr>
                    <td >
                        Friday, August 15 - Afternoon Tea (Wyndham Grand – Sky Lounge)
                    </td>
                    <td>$<?php echo $resData['price_tea']; ?></td>
                    <td><?php echo $resData['qty_tea']; ?></td>
                    <td>$<?php echo $resData['total_tea']; ?></td>
                </tr>
                <tr>
                    <td >
                        Stein sales room - Full table - registered attendees only
                    </td>
                    <td>$<?php echo $resData['price_full_tables']; ?></td>
                    <td><?php echo $resData['qty_full_tables']; ?></td>
                    <td>$<?php echo $resData['total_full_tables']; ?></td>
                </tr>
                <tr>
                    <td >
                        Stein sales room - Half table - registered attendees only
                    </td>
                    <td>$<?php echo $resData['price_half_tables']; ?></td>
                    <td><?php echo $resData['qty_half_tables']; ?></td>
                    <td>$<?php echo $resData['total_half_tables']; ?></td>
                </tr>
                <tr>
                    <td >
                        Additional convention steins (subject to availability)
                    </td>
                    <td>$<?php echo $resData['price_steins']; ?></td>
                    <td><?php echo $resData['qty_steins']; ?></td>
                    <td>$<?php echo $resData['total_steins']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right">
                        <strong>GRAND TOTAL</strong>
                    </td>
                    <td>$<?php echo $resData['grand_total']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right">
                        The minimum required deposit is 50% of the total of all fees.  <strong>MINIMUM DEPOSIT</strong>
                    </td>
                    <td>$<?php echo $resData['minimum_deposit']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right">
                        <strong style="color:blue">IF YOU WANT TO PAY MORE THAN THE MINIMUM, ENTER AMOUNT HERE </strong>
                    </td>
                    <td>$<?php echo $resData['amount_to_pay']; ?></td>
                </tr>
                <tr>
                    <th colspan="6" style="background-color: #0ecad4;color: black">OTHER CHOICES YOU NEED TO MAKE (and don't forget to click SUBMIT below when you are done)</th>
                </tr>
                <tr>
                    <td colspan="6">
                        <table width="93%" cellpadding="0" border="1" cellspacing="0">
                            <tr>
                                <td colspan="4"><strong style="color:blue">THURSDAY evening (August 14) in the hotel - German Night - Indicate quantity for each entree choice</strong></td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_thursday_dinner']; ?></td>
                                <td>Please indicate how many of your party will attend, then enter the quantity for each entree</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_thurs_entree1']; ?></td>
                                <td>German Sausage Sampler</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_thurs_entree2']; ?></td>
                                <td>Brined Seared Pork Tenderloin</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table width="93%" cellpadding="0" border="1" cellspacing="0">
                            <tr>
                                <td colspan="4"><strong style="color:blue">SATURDAY evening dinner (August 16) in the hotel</strong></td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_saturday_dinner']; ?></td>
                                <td>Please indicate how many of your party will attend. - Indicate quantity for each entree choice.</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_sat_entree1']; ?></td>
                                <td>Seared Pierre Breast of Chicken</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_sat_entree2']; ?></td>
                                <td>Seared Salmon</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_sat_entree3']; ?></td>
                                <td>Flat Iron Steak</td>
                            </tr>
                            <tr>
                                <td><?php echo $resData['qty_sat_entree4']; ?></td>
                                <td>Vegetarian Entrée</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    </body>
    </html>
    <?php
    $html = ob_get_clean();

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    echo $dompdf->output();
}

?>