<?php
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    $pageAction = $_REQUEST['action'];
    switch ($pageAction) {
        case "add":
            dentalfocus_add_social_media();
            break;
        case "save":
            dentalfocus_save_social_media();
            break;
        case "edit":
            dentalfocus_edit_social_media();
            break;
        case "update":
            dentalfocus_update_social_media();
            break;
        case "delete":
            dentalfocus_delete_social_media();
            break;
        case "viewinfo":
            dentalfocus_view_social_media();
            break;
        default:
            trentium_membership_settings();
    }
}
else{
    trentium_membership_settings();
}
/*
    Create Function for display social media list
*/
function trentium_membership_settings(){
    /*
        Setup CSS And JS For Listing of socialmedia records.
    */
    wp_register_script('socialmedia-js', DENTALFOCUS_SCRIPTS . 'socialmedia.js', array('jquery'));
    wp_enqueue_style('socialmedia-css', DENTALFOCUS_CSS . 'socialmedia.css');

    ?><div id="pageparentdiv" class="postbox">
    <h3 class="hndle ui-sortable-handle inside">
        SCI Membership Price Settings &nbsp;
        <!--<a href="admin.php?page=tssettings&tab=socialmedia&action=add" class="button button-primary button-medium">Add New</a>-->
    </h3>
    <div class="inside"><?php
        dentalfocus_messagedisplay();
        ?><table class="wp-list-table widefat fixed" id="socialmedialist">
            <thead>
            <tr>
                <th><strong>Sr No</strong></th>
                <th><strong>Membership Term</strong></th>
                <th><strong>eProsit Digital</strong></th>
                <th><strong>eProsit Print USA</strong></th>
                <th><strong>eProsit Print Canada/Maxico</strong></th>
                <th><strong>eProsit Print All other worldwide</strong></th>
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
                dentalfocus_select_all_records : Function name for get all records from table : trentium_membership_settings
            */
            $resData = $objDB->dentalfocus_select_all_records('trentium_membership_settings');
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
                    <td nowrap><?php echo $r['memership_term']; ?> Yr</td>
                    <td nowrap>$<?php echo $r['eprosit_digital']; ?></td>
                    <td nowrap>$<?php echo $r['eprosit_print_usa']; ?></td>
                    <td nowrap>$<?php echo $r['eprosit_print_ca_mx']; ?></td>
                    <td nowrap>$<?php echo $r['eprosit_print_all']; ?></td>
                    <td style="text-align:center;">
                        <a class="button button-secondary"
                           href="admin.php?page=tssettings&tab=socialmedia&action=edit&id=<?php echo $r['id']; ?>">Edit</a>
                        <a class="button button-danger"
                           onclick="return confirm('are you sure you want to delete membership?');"
                           href="admin.php?page=tssettings&tab=socialmedia&action=delete&id=<?php echo $r['id']; ?>">Delete</a>
                    </td>
                    </tr><?php
                }

            } else {
                ?><tr>
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
function dentalfocus_add_social_media(){

    ?><script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("#form-socialmedia").validationEngine();
        });
    </script><div id="pageparentdiv" class="postbox">
        <h3 class="hndle ui-sortable-handle inside">
            Add SCI Membership Price Settings &nbsp;
            <a href="admin.php?page=tssettings&tab=socialmedia" style="float:right;" class="button button-primary button-medium">Back</a>
        </h3>
        <div class="inside"><?php
            dentalfocus_messagedisplay();
            ?><form name="form-socialmedia" id="form-socialmedia" method="post" action="admin.php?page=tssettings&tab=socialmedia&action=save">
                <p>
                <table width="70%">
                    <tr>
                        <td><label><strong>Title :</strong></label></td>
                        <td><input type="text" name="txtTitle" id="txtTitle" class="validate[required]" /></td>
                        <td><label><strong>URL :</strong></label></td>
                        <td><input type="text" name="txtUrl" id="txtUrl" class="validate[required,custom[url]]" /></td>
                        <td align="right">
                            <input type="submit" name="addsocialmedia" id="addsocialmedia" class="button" value="Add Membership Settings">
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
function dentalfocus_save_social_media(){
    if(isset($_REQUEST['addsocialmedia']) && !empty($_REQUEST['addsocialmedia'])){
        $df_social_table = 'trentium_membership_settings';
        $title = $_REQUEST['txtTitle'];
        $url = $_REQUEST['txtUrl'];
        $arrayInsertData = array(
            'title' => htmlspecialchars($title),
            'slug' => sanitize_title($title),
            'url' 	=> $url
        );
        $objDB = new dentalfocus_db_function();
        $objDB->dentalfocus_insert_records($df_social_table,$arrayInsertData);
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&msg=rsi");
        exit;
    }
    else{
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&action=add&msg=swr");
        exit;
    }
}
/*
    Create Function for edit social media
*/
function dentalfocus_edit_social_media(){
    $df_social_table = 'trentium_membership_settings';
    if(!isset($_REQUEST['id']) || empty($_REQUEST['id'])){
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&msg=swr");
        exit;
    }
    $socialmedia_id = $_REQUEST['id'];
    $arrayEditData = array(
        'id' => intval($socialmedia_id)
    );
    $objDB = new dentalfocus_db_function();
    $resData = $objDB->dentalfocus_edit_records($df_social_table,$arrayEditData);

    ?><script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("#form-socialmedia").validationEngine();
        });
    </script><div id="pageparentdiv" class="postbox">
        <h3 class="hndle ui-sortable-handle inside">
            Edit SCI Membership Price Settings &nbsp;
            <a href="admin.php?page=tssettings&tab=socialmedia" style="float:right;" class="button button-primary button-medium">Back</a>
        </h3>
        <div class="inside"><?php
            dentalfocus_messagedisplay();
            ?><form name="form-socialmedia" id="form-socialmedia" method="post" action="admin.php?page=tssettings&tab=socialmedia&action=update">
                <input type="hidden" name="id" id="id" value="<?php echo $resData['id']; ?>" />
                <p>
                <table width="70%">
                    <tr>
                        <td><label><strong>Membership Term :</strong></label></td>
                        <td><input type="number" min="1" name="memership_term" id="memership_term" class="validate[required]" value="<?php echo $resData['memership_term']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><label><strong>eProsit Digital :</strong></label></td>
                        <td><input type="number" min="1" name="eprosit_digital" id="eprosit_digital" class="validate[required]" value="<?php echo $resData['eprosit_digital']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><label><strong>Print Subscriptions (USA) :</strong></label></td>
                        <td><input type="number" min="1" name="eprosit_print_usa" id="eprosit_print_usa" class="validate[required]" value="<?php echo $resData['eprosit_print_usa']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><label><strong>Print Subscriptions (Canada/Mexico) :</strong></label></td>
                        <td><input type="number" min="1" name="eprosit_print_ca_mx" id="eprosit_print_ca_mx" class="validate[required]" value="<?php echo $resData['eprosit_print_ca_mx']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><label><strong>Print Subscriptions (All other worldwide) :</strong></label></td>
                        <td><input type="number" min="1" name="eprosit_print_all" id="eprosit_print_all" class="validate[required]" value="<?php echo $resData['eprosit_print_all']; ?>" /></td>
                    </tr>
                    <tr>
                        <td align="right"><input type="submit" name="addsocialmedia" id="addsocialmedia" class="button" value="Update Membership Settings"></td>
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
function dentalfocus_update_social_media(){
    if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
        $df_social_table = 'trentium_membership_settings';
        $socialmedia_id = $_REQUEST['id'];
        $memership_term = $_REQUEST['memership_term'];
        $eprosit_digital = $_REQUEST['eprosit_digital'];
        $eprosit_print_usa = $_REQUEST['eprosit_print_usa'];
        $eprosit_print_ca_mx = $_REQUEST['eprosit_print_ca_mx'];
        $eprosit_print_all = $_REQUEST['eprosit_print_all'];

        $objDB = new dentalfocus_db_function();
        $arrayUpdateData = array(
            'memership_term' => sanitize_title($memership_term),
            'eprosit_digital' => sanitize_title($eprosit_digital),
            'eprosit_print_usa' => sanitize_title($eprosit_print_usa),
            'eprosit_print_ca_mx' => sanitize_title($eprosit_print_ca_mx),
            'eprosit_print_all' => sanitize_title($eprosit_print_all),
        );
        $arrayConditionData = array(
            'id' 	=> intval($socialmedia_id)
        );
        $objDB->dentalfocus_update_records($df_social_table,$arrayUpdateData,$arrayConditionData);
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&msg=rus");
        exit;
    }
    else{
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&msg=swr");
        exit;
    }
}
/*
    Create Function for Delete Membership Settings URL
*/
function dentalfocus_delete_social_media(){
    if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
        $df_social_table = 'trentium_membership_settings';
        $socialmedia_id = $_REQUEST['id'];
        $objDB = new dentalfocus_db_function();
        $arrayDeleteData = array(
            'id' => $socialmedia_id
        );
        $objDB->dentalfocus_delete_records($df_social_table,$arrayDeleteData);
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&msg=rds");
        exit;
    }
    else{
        wp_redirect("admin.php?page=tssettings&tab=socialmedia&action=add&msg=swr");
        exit;
    }
}
/*
    Create Function for View How to use social Media in your page
*/
function dentalfocus_view_social_media(){
?><div class="wrap">
    <div id="pageparentdiv" class="postbox">
        <h3 class="hndle ui-sortable-handle inside">
            How to use membership sortcode?
            <a href="admin.php?page=tssettings&tab=socialmedia" style="float:right;" class="button button-primary button-medium">Back</a>
        </h3>
        <div class="inside">
            <div id="message2" class="updated notice below-h2">
                <h2>How to use?</h2>
                <br />
                <p>
                    If you want to display membership form, you can use our sortcode directly.<br /><br />
                    How to use in template?<br /><br />
                    <strong><code>&lt;?php echo do_shortcode("[ts-membership]"); ?&gt;&nbsp;</code></strong><br /><br />
                    How to use wordpress page?<br /><br />
                    <strong><code>[ts_membership]</code></strong>
                </p>
            </div>
        </div>
    </div>
</div><?php
}
?></div>