<?php
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $pageAction = $_REQUEST['action'];
    switch ($pageAction) {
        case "add":
            dentalfocus_add_members();
            break;
        case "save":
            dentalfocus_save_members();
            break;
        case "edit":
            dentalfocus_edit_members();
            break;
        case "update":
            dentalfocus_update_members();
            break;
        case "delete":
            dentalfocus_delete_members();
            break;
        case "viewinfo":
            dentalfocus_view_members();
            break;
        case "export":
            dentalfocus_export_members();
            break;
        default:
            trentium_membership_members();
    }
} else {
    trentium_membership_members();
}
/*
    Create Function for display social media list
*/
function trentium_membership_members()
{
    /*
        Setup CSS And JS For Listing of socialmedia records.
    */
    wp_register_script('socialmedia-js', DENTALFOCUS_SCRIPTS . 'socialmedia.js', array('jquery'));
    wp_enqueue_style('socialmedia-css', DENTALFOCUS_CSS . 'socialmedia.css');

    ?>
    <div id="pageparentdiv" class="postbox">
    <h3 class="hndle ui-sortable-handle inside">
        SCI Membership Members List &nbsp;
        <a href="admin.php?page=tssettings&tab=members&action=add" class="button button-primary button-medium">Manually
            create a new Member registration in the MMT.</a>
        <a href="admin.php?page=tssettings&tab=members&action=add" class="button button-primary button-medium">Manually
            create a new User in the WP-User Table (with SCI number).</a>
        <a href="admin-post.php?action=export_members_df" class="button button-primary button-medium">Export
            Master Membership Table (MMT) to CSV file.</a>
        <a href="admin-post.php?action=backup_members_df" class="button button-primary button-medium">Download
            a full CSV backup file for the MMT.</a>
    </h3>
    <div class="inside"><?php
        dentalfocus_messagedisplay();
        ?>
        <table class="wp-list-table widefat fixed" id="socialmedialist">
            <thead>
            <tr>
                <th><strong>Sr No</strong></th>
                <th><strong>Username</strong></th>
                <th><strong>Email</strong></th>
                <th><strong>First Name</strong></th>
                <th><strong>Last Name</strong></th>
                <th><strong>Country</strong></th>
                <th><strong>Home Phone</strong></th>
                <th><strong>Mobile Phone</strong></th>
                <th><strong>Action</strong></th>
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
                dentalfocus_select_all_records : Function name for get all records from table : trentium_membership_users
            */
            $resData = $objDB->dentalfocus_select_all_records('trentium_membership_users');
            /*
                Check records exists or not.
                IF no then display No Record Found Message.
            */
            if (count($resData) > 0) {
                $i = 0;
                foreach ($resData as $r) {
                    ?>
                    <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $r['username']; ?></td>
                    <td><?php echo $r['customer_email']; ?></td>
                    <td><?php echo $r['customer_first_name']; ?></td>
                    <td><?php echo $r['customer_last_name']; ?></td>
                    <td><?php echo $r['customer_country']; ?></td>
                    <td><?php echo $r['customer_home_phone']; ?></td>
                    <td><?php echo $r['customer_mobile_phone']; ?></td>
                    <td style="text-align:center;">
                        <a class="button button-secondary"
                           href="admin.php?page=tssettings&tab=members&action=edit&member_no=<?php echo $r['member_no']; ?>">Edit</a>
                        <a class="button button-secondary"
                           href="admin.php?page=tssettings&tab=members&action=viewinfo&member_no=<?php echo $r['member_no']; ?>">View</a>
                        <!--<a class="button button-danger"
                           onclick="return confirm('are you sure you want to delete membership?');"
                           href="admin.php?page=tssettings&tab=members&action=delete&member_no=<?php /*echo $r['member_no']; */ ?>">Delete</a>-->
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

/*
    Create Function for add social media
*/
function dentalfocus_add_members()
{

    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("#form-socialmedia").validationEngine();
        });
    </script>
    <div id="pageparentdiv" class="postbox">
        <h3 class="hndle ui-sortable-handle inside">
            Add SCI Membership Price Settings &nbsp;
            <a href="admin.php?page=tssettings&tab=socialmedia" style="float:right;"
               class="button button-primary button-medium">Back</a>
        </h3>
        <div class="inside"><?php
            dentalfocus_messagedisplay();
            ?>
            <form name="form-socialmedia" id="form-socialmedia" method="post"
                  action="admin.php?page=tssettings&tab=socialmedia&action=save">
                <p>
                <table width="70%">
                    <tr>
                        <td><label><strong>Title :</strong></label></td>
                        <td><input type="text" name="txtTitle" id="txtTitle" class="validate[required]"/></td>
                        <td><label><strong>URL :</strong></label></td>
                        <td><input type="text" name="txtUrl" id="txtUrl" class="validate[required,custom[url]]"/></td>
                        <td align="right">
                            <input type="submit" name="addsocialmedia" id="addsocialmedia" class="button"
                                   value="Add Membership Settings">
                        </td>
                    </tr>
                </table>
                </p>
            </form>
        </div>
    </div><?php

}

/*
    Create function for save social media information
*/
function dentalfocus_save_members()
{
    if (isset($_REQUEST['addsocialmedia']) && !empty($_REQUEST['addsocialmedia'])) {
        $df_social_table = 'trentium_membership_settings';
        $title = $_REQUEST['txtTitle'];
        $url = $_REQUEST['txtUrl'];
        $arrayInsertData = array(
            'title' => htmlspecialchars($title),
            'slug' => sanitize_title($title),
            'url' => $url
        );
        $objDB = new dentalfocus_db_function();
        $objDB->dentalfocus_insert_records($df_social_table, $arrayInsertData);
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&msg=rsi");
        exit;
    } else {
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&action=add&msg=swr");
        exit;
    }
}

/*
    Create Function for edit social media
*/
function dentalfocus_edit_members()
{
    $df_social_table = 'trentium_membership_users';
    $df_social_table1 = 'trentium_membership_payments';
    if (!isset($_REQUEST['member_no']) || empty($_REQUEST['member_no'])) {
        wp_redirect("admin.php?page=tssettings&tab=members&msg=imn");
        exit;
    }
    $socialmedia_id = $_REQUEST['member_no'];
    $arrayEditData = array(
        'member_no' => intval($socialmedia_id)
    );
    $objDB = new dentalfocus_db_function();
    $resData = $objDB->dentalfocus_edit_records($df_social_table, $arrayEditData);
    $resDataPayment = NULL;
    if (isset($resData['last_payment_id']) && !empty($resData['last_payment_id'])) {
        $arrayEditData1 = array(
            'id' => $resData['last_payment_id']
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
            Edit SCI Member Details
            <a href="admin.php?page=tssettings&tab=members" style="float:right;"
               class="button button-primary button-medium">Back</a>
        </h3>
        <div class="inside"><?php
            dentalfocus_messagedisplay();
            ?>
            <form name="form-socialmedia" id="form-socialmedia" method="post"
                  action="admin.php?page=tssettings&tab=members&action=update">
                <div class="row">
                    <h1>Member selected for editing:</h1>
                    <h2 style="color: dodgerblue"><?php echo $resData['customer_last_name'] . ' ' . $resData['customer_first_name']; ?></h2>
                </div>
                <p>
                    <input type="hidden" name="member_no" value="<?php echo $resData['member_no']; ?>">
                <table width="100%">
                    <tr>
                        <td><label><strong>Member Number:</strong></label></td>
                        <td style="float: left"><input type="text" disabled readonly
                                                       value="<?php echo $resData['member_no']; ?>"></td>

                        <td><label><strong>Last Name:</strong></label></td>
                        <td style="float: left"><input type="text" name="customer_last_name" id="customer_last_name"
                                                       value="<?php echo $resData['customer_last_name']; ?>"></td>

                        <td><label><strong>First Name:</strong></label></td>
                        <td style="float: left"><input type="text" name="customer_first_name" id="customer_first_name"
                                                       value="<?php echo $resData['customer_first_name']; ?>"></td>
                    </tr>
                    <tr>
                        <td><label><strong>Address:</strong></label></td>
                        <td style="float: left"><input type="text" name="customer_address" id="customer_address"
                                                       value="<?php echo $resData['customer_address']; ?>"></td>

                        <td><label><strong>City:</strong></label></td>
                        <td style="float: left"><input type="text" name="customer_city" id="customer_city"
                                                       value="<?php echo $resData['customer_city']; ?>"></td>

                        <td><label><strong>State:</strong></label></td>
                        <td style="float: left"><input type="text" name="customer_state" id="customer_state"
                                                       value="<?php echo $resData['customer_state']; ?>"></td>
                    </tr>
                    <tr>
                        <td><label><strong>Zip:</strong></label></td>
                        <td style="float: left"><input type="text" name="customer_zip" id="customer_zip"
                                                       value="<?php echo $resData['customer_zip']; ?>"></td>

                        <td><label><strong>Country:</strong></label></td>
                        <td style="float: left"><input type="text" name="customer_country" id="customer_country"
                                                       value="<?php echo $resData['customer_country']; ?>"></td>

                        <td><label><strong>&nbsp;</strong></label></td>
                        <td style="float: left">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Email:</strong></label></td>
                        <td style="float: left"><input type="text" disabled readonly name="customer_email"
                                                       id="customer_email"
                                                       value="<?php echo $resData['customer_email']; ?>"></td>

                        <td><label><strong>Spouse:</strong></label></td>
                        <td style="float: left"><input type="text" name="customer_spouse" id="customer_spouse"
                                                       value="<?php echo $resData['customer_spouse']; ?>"></td>

                        <td><label><strong>&nbsp;</strong></label></td>
                        <td style="float: left">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><label><strong>Home Phone:</strong></label></td>
                        <td style="float: left"><input type="text" name="customer_home_phone" id="customer_home_phone"
                                                       value="<?php echo $resData['customer_home_phone']; ?>"></td>

                        <td><label><strong>Cell Phone:</strong></label></td>
                        <td style="float: left"><input type="text" name="cell_phone" id="cell_phone"
                                                       value="<?php echo $resData['cell_phone']; ?>"></td>

                        <td><label><strong>Print/Digital:</strong></label></td>
                        <td style="float: left">
                            <select name="print_or_digital" id="print_or_digital" required>
                                <option value="">Select</option>
                                <option value="Prosit" <?php if (isset($resDataPayment['print_or_digital']) && !empty($resDataPayment['print_or_digital'])) {
                                    if ($resDataPayment['print_or_digital'] == "Prosit") {
                                        echo 'selected';
                                    }
                                } ?>>Prosit
                                </option>
                                <option value="eProsit" <?php if (isset($resDataPayment['print_or_digital']) && !empty($resDataPayment['print_or_digital'])) {
                                    if ($resDataPayment['print_or_digital'] == "eProsit") {
                                        echo 'selected';
                                    }
                                } ?>>eProsit
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>SCI Chapter:</strong></label></td>
                        <td style="float: left">
                            <select name="chapter" id="chapter">
                                <option value="">Select</option>
                                <option value="THIRSTY KNIGHTS" <?php if ($resData['chapter'] == "THIRSTY KNIGHTS") {
                                    echo 'selected';
                                } ?>>THIRSTY KNIGHTS
                                </option>
                                <option value="DIE KRUGSAMMLER e. V." <?php if ($resData['chapter'] == "DIE KRUGSAMMLER e. V.") {
                                    echo 'selected';
                                } ?>>DIE KRUGSAMMLER e. V.
                                </option>
                                <option value="MEISTER STEINERS" <?php if ($resData['chapter'] == "MEISTER STEINERS") {
                                    echo 'selected';
                                } ?>>MEISTER STEINERS
                                </option>
                                <option value="SUN STEINERS" <?php if ($resData['chapter'] == "SUN STEINERS") {
                                    echo 'selected';
                                } ?>>SUN STEINERS
                                </option>
                                <option value="UPPER MIDWEST STEINOLOGISTS" <?php if ($resData['chapter'] == "UPPER MIDWEST STEINOLOGISTS") {
                                    echo 'selected';
                                } ?>>UPPER MIDWEST STEINOLOGISTS
                                </option>
                                <option value="PITTSBURGH STEIN SOCIETY" <?php if ($resData['chapter'] == "PITTSBURGH STEIN SOCIETY") {
                                    echo 'selected';
                                } ?>>PITTSBURGH STEIN SOCIETY
                                </option>
                                <option value="PACIFIC STEIN SAMMLER" <?php if ($resData['chapter'] == "PACIFIC STEIN SAMMLER") {
                                    echo 'selected';
                                } ?>>PACIFIC STEIN SAMMLER
                                </option>
                                <option value="DIE LUSTIGEN STEINJAEGER" <?php if ($resData['chapter'] == "DIE LUSTIGEN STEINJAEGER") {
                                    echo 'selected';
                                } ?>>DIE LUSTIGEN STEINJAEGER
                                </option>
                                <option value="GAMBRINUS STEIN CLUB" <?php if ($resData['chapter'] == "GAMBRINUS STEIN CLUB") {
                                    echo 'selected';
                                } ?>>GAMBRINUS STEIN CLUB
                                </option>
                                <option value="PENNSYLVANIA KEYSTEINERS" <?php if ($resData['chapter'] == "PENNSYLVANIA KEYSTEINERS") {
                                    echo 'selected';
                                } ?>>PENNSYLVANIA KEYSTEINERS
                                </option>
                                <option value="DIE GOLDEN GATE ZECHER" <?php if ($resData['chapter'] == "DIE GOLDEN GATE ZECHER") {
                                    echo 'selected';
                                } ?>>DIE GOLDEN GATE ZECHER
                                </option>
                                <option value="LONE STAR CHAPTER" <?php if ($resData['chapter'] == "LONE STAR CHAPTER") {
                                    echo 'selected';
                                } ?>>LONE STAR CHAPTER
                                </option>
                                <option value="ERSTE GRUPPE" <?php if ($resData['chapter'] == "ERSTE GRUPPE") {
                                    echo 'selected';
                                } ?>>ERSTE GRUPPE
                                </option>
                                <option value="ROCKY MOUNTAIN STEINERS" <?php if ($resData['chapter'] == "ROCKY MOUNTAIN STEINERS") {
                                    echo 'selected';
                                } ?>>ROCKY MOUNTAIN STEINERS
                                </option>
                                <option value="ALTE GERMANEN" <?php if ($resData['chapter'] == "ALTE GERMANEN") {
                                    echo 'selected';
                                } ?>>ALTE GERMANEN
                                </option>
                                <option value="NEW ENGLAND STEINERS" <?php if ($resData['chapter'] == "NEW ENGLAND STEINERS") {
                                    echo 'selected';
                                } ?>>NEW ENGLAND STEINERS
                                </option>
                                <option value="CAROLINA STEINERS" <?php if ($resData['chapter'] == "CAROLINA STEINERS") {
                                    echo 'selected';
                                } ?>>CAROLINA STEINERS
                                </option>
                                <option value="ARIZONA STEIN COLLECTORS" <?php if ($resData['chapter'] == "ARIZONA STEIN COLLECTORS") {
                                    echo 'selected';
                                } ?>>ARIZONA STEIN COLLECTORS
                                </option>
                                <option value="UPPERSTEINERS OF N.Y. STATE" <?php if ($resData['chapter'] == "UPPERSTEINERS OF N.Y. STATE") {
                                    echo 'selected';
                                } ?>>UPPERSTEINERS OF N.Y. STATE
                                </option>
                                <option value="BAYOU STEIN VEREIN" <?php if ($resData['chapter'] == "BAYOU STEIN VEREIN") {
                                    echo 'selected';
                                } ?>>BAYOU STEIN VEREIN
                                </option>
                                <option value="SAINT LOUIS GATEWAY STEINERS" <?php if ($resData['chapter'] == "SAINT LOUIS GATEWAY STEINERS") {
                                    echo 'selected';
                                } ?>>SAINT LOUIS GATEWAY STEINERS
                                </option>
                                <option value="DIE STUDENTEN PRINZ GRUPPE" <?php if ($resData['chapter'] == "DIE STUDENTEN PRINZ GRUPPE") {
                                    echo 'selected';
                                } ?>>DIE STUDENTEN PRINZ GRUPPE
                                </option>
                                <option value="DIXIE STEINERS" <?php if ($resData['chapter'] == "DIXIE STEINERS") {
                                    echo 'selected';
                                } ?>>DIXIE STEINERS
                                </option>
                                <option value="THOROUGHBRED STEIN VEREIN" <?php if ($resData['chapter'] == "THOROUGHBRED STEIN VEREIN") {
                                    echo 'selected';
                                } ?>>THOROUGHBRED STEIN VEREIN
                                </option>
                                <option value="MICHISTEINERS" <?php if ($resData['chapter'] == "MICHISTEINERS") {
                                    echo 'selected';
                                } ?>>MICHISTEINERS
                                </option>
                                <option value="THIRSTY KNIGHTS/NEW ENGLAND STEINERS" <?php if ($resData['chapter'] == "THIRSTY KNIGHTS/NEW ENGLAND STEINERS") {
                                    echo 'selected';
                                } ?>>THIRSTY KNIGHTS/NEW ENGLAND STEINERS
                                </option>
                                <option value="BURGERMEISTERS" <?php if ($resData['chapter'] == "BURGERMEISTERS") {
                                    echo 'selected';
                                } ?>>BURGERMEISTERS
                                </option>
                            </select>
                        </td>

                        <td><label><strong>Address 2:</strong></label></td>
                        <td style="float: left"><input type="text" name="local_chapter_officer"
                                                       id="local_chapter_officer"
                                                       value="<?php echo $resData['local_chapter_officer']; ?>"></td>

                        <td><label><strong>Master Steinologist:</strong></label></td>
                        <td style="float: left"><input type="text" name="master_steinologist" id="master_steinologist"
                                                       value="<?php echo $resData['master_steinologist']; ?>"></td>
                    </tr>
                    <tr>
                        <td><label><strong>First Year:</strong></label></td>
                        <td style="float: left"><input name="FirstYear" id="FirstYear" type="text"
                                                       value="<?php echo $resData['FirstYear']; ?>"></td>

                        <td><label><strong>Paid Until:</strong></label></td>
                        <td style="float: left"><input name="paid_until" id="paid_until" type="text"
                                                       value="<?php echo $resData['paid_until']; ?>"></td>

                        <td><label><strong>Date Paid:</strong></label></td>
                        <td style="float: left"><input name="paid_qtr" id="paid_qtr" type="text"
                                                       value="<?php echo $resData['paid_qtr']; ?>"></td>
                    </tr>
                    <tr>
                        <td><label><strong>Referred By:</strong></label></td>
                        <td style="float: left">
                            <input name="referred_by" id="referred_by" type="text"
                                   value="<?php echo $resData['referred_by']; ?>">
                        </td>

                        <td><label><strong>No List:</strong></label></td>
                        <td style="float: left">
                            <input name="No_list" id="No_list" type="text" value="<?php echo $resData['No_list']; ?>">
                        </td>

                        <td><label><strong>Pmt Terms:</strong></label></td>
                        <td style="float: left">
                            <input name="SubCode" id="SubCode" type="text" value="<?php echo $resData['SubCode']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Collecting Interests:</strong></label></td>
                        <td style="float: left">
                            <textarea name="collecting_interests"
                                      id="collecting_interests"><?php echo $resData['collecting_interests']; ?></textarea>
                        </td>

                        <td><label><strong>Notes:</strong></label></td>
                        <td style="float: left">
                            <textarea name="Notes" id="Notes"><?php echo $resData['Notes']; ?></textarea>
                        </td>

                        <td><label><strong>Mbr Status:</strong></label></td>
                        <td style="float: left">
                            <select name="PastMember" id="PastMember">
                                <option value="">Select</option>
                                <option value="0" <?php if ($resData['PastMember'] == 0) {
                                    echo 'selected';
                                } ?>>Current
                                </option>
                                <option value="1" <?php if ($resData['PastMember'] == 1) {
                                    echo 'selected';
                                } ?>>Past
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="left"><input type="submit" name="editmember" id="editmember" class="button"
                                                value="Update SCI Member Details"></td>
                    </tr>
                </table>
                </p>
            </form>
        </div>
    </div><?php

}

/*
    Create function for Update Membership Settings Records.
*/
function dentalfocus_update_members()
{
    /*echo '<pre>';
    print_r($_REQUEST);
    echo '</pre>';
    exit;*/
    if (isset($_REQUEST['member_no']) && !empty($_REQUEST['member_no'])) {
        $df_social_table = 'trentium_membership_users';
        $objDB = new dentalfocus_db_function();
        $arrayUpdateData = array(
            'customer_last_name' => (isset($_REQUEST['customer_last_name']) && !empty($_REQUEST['customer_last_name'])) ? $_REQUEST['customer_last_name'] : NULL,
            'customer_first_name' => (isset($_REQUEST['customer_first_name']) && !empty($_REQUEST['customer_first_name'])) ? $_REQUEST['customer_first_name'] : NULL,
            'customer_address' => (isset($_REQUEST['customer_address']) && !empty($_REQUEST['customer_address'])) ? $_REQUEST['customer_address'] : NULL,
            'customer_city' => (isset($_REQUEST['customer_city']) && !empty($_REQUEST['customer_city'])) ? $_REQUEST['customer_city'] : NULL,
            'customer_state' => (isset($_REQUEST['customer_state']) && !empty($_REQUEST['customer_state'])) ? $_REQUEST['customer_state'] : NULL,
            'customer_zip' => (isset($_REQUEST['customer_zip']) && !empty($_REQUEST['customer_zip'])) ? $_REQUEST['customer_zip'] : NULL,
            'customer_country' => (isset($_REQUEST['customer_country']) && !empty($_REQUEST['customer_country'])) ? $_REQUEST['customer_country'] : NULL,
            'customer_spouse' => (isset($_REQUEST['customer_spouse']) && !empty($_REQUEST['customer_spouse'])) ? $_REQUEST['customer_spouse'] : NULL,
            'customer_home_phone' => (isset($_REQUEST['customer_home_phone']) && !empty($_REQUEST['customer_home_phone'])) ? $_REQUEST['customer_home_phone'] : NULL,
            'cell_phone' => (isset($_REQUEST['cell_phone']) && !empty($_REQUEST['cell_phone'])) ? $_REQUEST['cell_phone'] : NULL,
            'first_class' => (isset($_REQUEST['print_or_digital']) && !empty($_REQUEST['print_or_digital'])) ? $_REQUEST['print_or_digital'] : NULL,
            'chapter' => (isset($_REQUEST['chapter']) && !empty($_REQUEST['chapter'])) ? $_REQUEST['chapter'] : NULL,
            'local_chapter_officer' => (isset($_REQUEST['local_chapter_officer']) && !empty($_REQUEST['local_chapter_officer'])) ? $_REQUEST['local_chapter_officer'] : NULL,
            'master_steinologist' => (isset($_REQUEST['master_steinologist']) && !empty($_REQUEST['master_steinologist'])) ? $_REQUEST['master_steinologist'] : NULL,
            'FirstYear' => (isset($_REQUEST['FirstYear']) && !empty($_REQUEST['FirstYear'])) ? $_REQUEST['FirstYear'] : NULL,
            'paid_until' => (isset($_REQUEST['paid_until']) && !empty($_REQUEST['paid_until'])) ? $_REQUEST['paid_until'] : NULL,
            'paid_qtr' => (isset($_REQUEST['paid_qtr']) && !empty($_REQUEST['paid_qtr'])) ? $_REQUEST['paid_qtr'] : NULL,
            'referred_by' => (isset($_REQUEST['referred_by']) && !empty($_REQUEST['referred_by'])) ? $_REQUEST['referred_by'] : NULL,
            'No_list' => (isset($_REQUEST['No_list']) && !empty($_REQUEST['No_list'])) ? $_REQUEST['No_list'] : NULL,
            'SubCode' => (isset($_REQUEST['SubCode']) && !empty($_REQUEST['SubCode'])) ? $_REQUEST['SubCode'] : NULL,
            'collecting_interests' => (isset($_REQUEST['collecting_interests']) && !empty($_REQUEST['collecting_interests'])) ? $_REQUEST['collecting_interests'] : NULL,
            'Notes' => (isset($_REQUEST['Notes']) && !empty($_REQUEST['Notes'])) ? $_REQUEST['Notes'] : NULL,
            'PastMember' => (isset($_REQUEST['PastMember'])) ? $_REQUEST['PastMember'] : 0,
        );
        $arrayConditionData = array(
            'member_no' => intval($_REQUEST['member_no'])
        );
        $objDB->dentalfocus_update_records($df_social_table, $arrayUpdateData, $arrayConditionData);
        wp_redirect("admin.php?page=tssettings&tab=members&msg=rus");
        exit;
    } else {
        wp_redirect("admin.php?page=tssettings&tab=members&msg=swr");
        exit;
    }
}

/*
    Create Function for Delete Membership Settings URL
*/
function dentalfocus_delete_members()
{
    if (isset($_REQUEST['member_no']) && !empty($_REQUEST['member_no'])) {
        $df_social_table = 'trentium_membership_users';
        $socialmedia_id = $_REQUEST['member_no'];
        $objDB = new dentalfocus_db_function();
        $arrayDeleteData = array(
            'member_no' => $socialmedia_id
        );
        $objDB->dentalfocus_delete_records($df_social_table, $arrayDeleteData);
        wp_redirect("admin.php?page=tssettings&tab=members&msg=rds");
        exit;
    } else {
        wp_redirect("admin.php?page=tssettings&tab=members&action=add&msg=swr");
        exit;
    }
}

/*
    Create Function for View How to use social Media in your page
*/
function dentalfocus_view_members()
{
    $df_social_table = 'trentium_membership_users';
    $df_social_table1 = 'trentium_membership_payments';
    if (!isset($_REQUEST['member_no']) || empty($_REQUEST['member_no'])) {
        wp_redirect("admin.php?page=tssettings&tab=members&msg=imn");
        exit;
    }
    $socialmedia_id = $_REQUEST['member_no'];
    $arrayEditData = array(
        'member_no' => intval($socialmedia_id)
    );
    $objDB = new dentalfocus_db_function();
    $resData = $objDB->dentalfocus_edit_records($df_social_table, $arrayEditData);
    $resDataPayment = NULL;
    if (isset($resData['last_payment_id']) && !empty($resData['last_payment_id'])) {
        $arrayEditData1 = array(
            'id' => $resData['last_payment_id']
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
            View SCI Member Details
            (<?php echo $resData['customer_last_name'] . ' ' . $resData['customer_first_name'] ?>)
            <a href="admin.php?page=tssettings&tab=members" style="float:right;"
               class="button button-primary button-medium">Back</a>
        </h3>
        <div class="inside"><?php
            dentalfocus_messagedisplay();
            ?>
            <p>
            <table width="100%">
                <tr>
                    <td><label><strong>Member Number:</strong></label></td>
                    <td style="float: left"><strong
                                style="color: dodgerblue"><?php echo $resData['member_no']; ?></strong></td>

                    <td><label><strong>Last Name:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_last_name']; ?></td>

                    <td><label><strong>First Name:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_first_name']; ?></td>
                </tr>
                <tr>
                    <td><label><strong>Address:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_address']; ?></td>

                    <td><label><strong>City:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_city']; ?></td>

                    <td><label><strong>State:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_state']; ?></td>
                </tr>
                <tr>
                    <td><label><strong>Zip:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_zip']; ?></td>

                    <td><label><strong>Country:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_country']; ?></td>

                    <td><label><strong>&nbsp;</strong></label></td>
                    <td style="float: left">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td><label><strong>Email:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_email']; ?></td>

                    <td><label><strong>Spouse:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_spouse']; ?></td>

                    <td><label><strong>&nbsp;</strong></label></td>
                    <td style="float: left">&nbsp;</td>
                </tr>
                <tr>
                    <td><label><strong>Home Phone:</strong></label></td>
                    <td style="float: left"><?php echo $resData['customer_home_phone']; ?></td>

                    <td><label><strong>Cell Phone:</strong></label></td>
                    <td style="float: left"><?php echo $resData['cell_phone']; ?></td>

                    <td><label><strong>Print/Digital:</strong></label></td>
                    <td style="float: left">
                        <?php echo $resDataPayment['print_or_digital']; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td><label><strong>SCI Chapter:</strong></label></td>
                    <td style="float: left">
                        <?php echo $resData['chapter']; ?>
                    </td>

                    <td><label><strong>Address 2:</strong></label></td>
                    <td style="float: left"><?php echo $resData['local_chapter_officer']; ?></td>

                    <td><label><strong>Master Steinologist:</strong></label></td>
                    <td style="float: left"><?php echo $resData['master_steinologist']; ?></td>
                </tr>
                <tr>
                    <td><label><strong>First Year:</strong></label></td>
                    <td style="float: left"><?php echo $resData['FirstYear']; ?></td>

                    <td><label><strong>Paid Until:</strong></label></td>
                    <td style="float: left"><?php echo $resData['paid_until']; ?></td>

                    <td><label><strong>Date Paid:</strong></label></td>
                    <td style="float: left"><?php echo $resData['paid_qtr']; ?></td>
                </tr>
                <tr>
                    <td><label><strong>Referred By:</strong></label></td>
                    <td style="float: left">
                        <?php echo $resData['referred_by']; ?>
                    </td>

                    <td><label><strong>No List:</strong></label></td>
                    <td style="float: left">
                        <?php echo $resData['No_list']; ?>
                    </td>

                    <td><label><strong>Pmt Terms:</strong></label></td>
                    <td style="float: left">
                        <?php echo $resData['SubCode']; ?>
                    </td>
                </tr>
                <tr>
                    <td><label><strong>Collecting Interests:</strong></label></td>
                    <td style="float: left">
                        <?php echo $resData['collecting_interests']; ?>
                    </td>

                    <td><label><strong>Notes:</strong></label></td>
                    <td style="float: left">
                        <?php echo $resData['Notes']; ?>
                    </td>

                    <td><label><strong>Mbr Status:</strong></label></td>
                    <td style="float: left">
                        <?php
                        if ($resData['PastMember'] == 0) {
                            echo 'Current';
                        } else {
                            echo 'Past';
                        }
                        ?>
                    </td>
                </tr>
                <?php
                if (isset($resDataPayment) && !empty($resDataPayment)) {
                    ?>
                    <tr>
                        <td colspan="6">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <h2>Payment Details</h2>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Memership Term:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['memership_term']; ?> Yr
                        </td>

                        <td><label><strong>Memership Country:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['memership_country']; ?>
                        </td>

                        <td><label><strong>Print/Digital:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['print_or_digital']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Memership Type:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['membership']; ?>
                        </td>

                        <td><label><strong>Paypal Payer ID:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['paypal_payer_id']; ?>
                        </td>

                        <td><label><strong>Paypal ST:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['paypal_st']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Paypal TX:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['paypal_tx']; ?>
                        </td>

                        <td><label><strong>Paypal CC:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['paypal_cc']; ?>
                        </td>

                        <td><label><strong>Paypal Amount:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['paypal_amount']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Payer Email:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['payer_email']; ?>
                        </td>

                        <td><label><strong>Payer ID:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['payer_id']; ?>
                        </td>

                        <td><label><strong>Payment Status:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['payer_status']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>First Name:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['first_name']; ?>
                        </td>

                        <td><label><strong>Last Name:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['last_name']; ?>
                        </td>

                        <td><label><strong>Address:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['address_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Street:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['address_street']; ?>
                        </td>

                        <td><label><strong>City:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['address_city']; ?>
                        </td>

                        <td><label><strong>State:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['address_state']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Country Code:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['address_country_code']; ?>
                        </td>

                        <td><label><strong>Zip:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['address_zip']; ?>
                        </td>

                        <td><label><strong>Residence Country:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['residence_country']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>TXN ID:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['txn_id']; ?>
                        </td>

                        <td><label><strong>MC Currency:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['mc_currency']; ?>
                        </td>

                        <td><label><strong>MC Fee:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['mc_fee']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>MC GROSS:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['mc_gross']; ?>
                        </td>

                        <td><label><strong>Protection Eligibility:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['protection_eligibility']; ?>
                        </td>

                        <td><label><strong>Payment Fee:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['payment_fee']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Payment Gross:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['payment_gross']; ?>
                        </td>

                        <td><label><strong>Payment Status:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['payment_status']; ?>
                        </td>

                        <td><label><strong>Payment Type:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['payment_type']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Handling Amount:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['handling_amount']; ?>
                        </td>

                        <td><label><strong>Shipping:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['shipping']; ?>
                        </td>

                        <td><label><strong>Item Name:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['item_name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Quantity:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['quantity']; ?>
                        </td>

                        <td><label><strong>Txn Type:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['txn_type']; ?>
                        </td>

                        <td><label><strong>Payment Date:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['payment_date']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label><strong>Receiver ID:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['receiver_id']; ?>
                        </td>

                        <td><label><strong>Notify Version:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['notify_version']; ?>
                        </td>

                        <td><label><strong>Verify Sign:</strong></label></td>
                        <td style="float: left">
                            <?php echo $resDataPayment['verify_sign']; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>

            </table>
            </p>
        </div>
    </div><?php
}

/*function dentalfocus_export_members(){
    ob_start();
    $objDB = new dentalfocus_db_function();
    $resData = $objDB->dentalfocus_select_all_records('trentium_membership_users');
    if(isset($resData) && !empty($resData)){
        $csv_header_row =
            "Mbr #" .
            "," . "last_name" .
            "," . "first_name" .
            "," . "spouse/partner" .
            "," . "street_address" .
            "," . "city" .
            "," . "state" .
            "," . "zip" .
            "," . "country" .
            "," . "HomePhone" .
            "," . "cell_phone" .
            "," . "email address" .
            "," . "chapter" .
            "," . "master_steinologist" .
            "," . "paid_until" .
            "," . "eProsit" .
            "," . "Date Paid" .
            "," . "NoList" .
            "," . "Pmt Terms" .
            "," . "FirstYear" .
            "," . "Mbr Status" .
            "," . "Notes" .
            "," . "ReferdBy" .
            "," . "collecting_interests" .
            "\n";

        $output = $csv_header_row;
        foreach($resData as $keyData => $valueData){
            $csv_row_content  = '"' . $valueData['member_no'] . '",';
            $csv_row_content .= '"' . $valueData['customer_last_name'] . '",';
            $csv_row_content .= '"' . $valueData['customer_first_name'] . '",';
            $csv_row_content .= '"' . $valueData['customer_spouse'] . '",';
            $csv_row_content .= '"' . $valueData['customer_address'] . '",';
            $csv_row_content .= '"' . $valueData['customer_city'] . '",';
            $csv_row_content .= '"' . $valueData['customer_state'] . '",';
            $csv_row_content .= '"' . $valueData['customer_zip'] . '",';
            $csv_row_content .= '"' . $valueData['customer_country'] . '",';
            $csv_row_content .= '"' . $valueData['customer_home_phone'] . '",';
            $csv_row_content .= '"' . $valueData['cell_phone'] . '",';
            $csv_row_content .= '"' . $valueData['customer_email'] . '",';
            $csv_row_content .= '"' . $valueData['chapter'] . '",';
            $csv_row_content .= '"' . $valueData['master_steinologist'] . '",';
            $csv_row_content .= '"' . $valueData['paid_until'] . '",';
            $csv_row_content .= '"' . $valueData['first_class'] . '",'; // AS eProsit only
            $csv_row_content .= '"' . $valueData['paid_qtr'] . '",';
            $csv_row_content .= '"' . $valueData['No_list'] . '",';
            $csv_row_content .= '"' . $valueData['SubCode'] . '",';
            $csv_row_content .= '"' . $valueData['FirstYear'] . '",';
            $csv_row_content .= '"' . $valueData['PastMember'] . '",';
            $csv_row_content .= '"' . $valueData['Notes'] . '",';
            $csv_row_content .= '"' . $valueData['referred_by'] . '",';
            $csv_row_content .= '"' . $valueData['collecting_interests'] . '",';

            $output .= $csv_row_content . "\n";
        }

        $today = date("Y-m-d");
        $filename = "MMT_all_members_sorted_" . $today . ".csv";

        header('Content-type: text/csv');

        header('Content-Disposition: attachment; filename=' . $filename);

        echo ($output);
        exit;
    }
    else {
        wp_redirect("admin.php?page=tssettings&tab=members&msg=swr");
        exit;
    }
}*/
?>