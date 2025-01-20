<?php
if (!is_admin()) {
    add_action('wp_enqueue_scripts', 'ts_membership_sortcode_scripts');
    add_action('wp_enqueue_scripts', 'ts_membership_sortcode_scripts', 100);
    add_shortcode('ts_membership_sortcode', 'ts_membership_sortcode');
    add_shortcode('ts_paypal_return_sortcode', 'handle_return_page');
    add_shortcode('ts_paypal_registration_sortcode', 'handle_registration_page');
    add_shortcode('ts_convention_registration_sortcode', 'ts_convention_registration_form_handle_submission');
    add_shortcode('ts_member_search_result_sortcode', 'handle_member_search_result_page');
    add_shortcode('ts_convention_paypal_return_sortcode', 'handle_convention_return_page');
}
add_action('init', 'ts_membership_form_handle_submission');
add_action('init', 'ts_convention_registration_form_handle_submission');

function handle_member_search_result_page()
{
    ob_start();

    $last_name = NULL;
    $chapter = NULL;
    $spouse = NULL;
    $state = NULL;
    $country = NULL;
    if (isset($_REQUEST['last_name']) && !empty($_REQUEST['last_name'])) {
        $last_name = $_REQUEST['last_name'];
    }
    if (isset($_REQUEST['chapter']) && !empty($_REQUEST['chapter'])) {
        $chapter = $_REQUEST['chapter'];
    }
    if (isset($_REQUEST['spouse']) && !empty($_REQUEST['spouse'])) {
        $spouse = $_REQUEST['spouse'];
    }
    if (isset($_REQUEST['state']) && !empty($_REQUEST['state'])) {
        $state = $_REQUEST['state'];
    }
    if (isset($_REQUEST['country']) && !empty($_REQUEST['country'])) {
        $country = $_REQUEST['country'];
    }

    if (get_current_user_id() == 602 or get_current_user_id() == 2 or get_current_user_id() == 567 or get_current_user_id() == 98) {
        $DBA = "yes";
    } else {
        $DBA = "no";
    }

    $PARM_preamble = " This is the member search by <u>";
    $searchtype = $_GET["search_type"];
    $prepare_params = "SELECT
    member_no,
    customer_first_name,
    customer_last_name,
    customer_spouse,
    customer_address,
    customer_city,
    customer_state,
    customer_zip,
    customer_country,
    customer_home_phone,
    customer_email,
    chapter,
    master_steinologist,
    local_chapter_officer,
    collecting_interests,
    paid_until,
    first_class,
    paid_qtr,
    cell_phone,
    No_list,
    chapter_position,
    referred_by,
    SubCode,
    FirstYear,
    PastMember,
    Notes
FROM
    trentium_membership_users
WHERE
    PastMember = 0 AND customer_last_name <> ''";

    if ($DBA == "no") {
        $prepare_params .= " AND No_list <> 'N'";
    }

    if ($searchtype == "name") {
        $PARM_preamble .= "Last Name like " . $last_name . ".</u>";
        $prepare_params .= " AND customer_last_name LIKE '%" . $last_name . "%'";
    }
    if ($searchtype == "chapter") {
        $PARM_preamble .= "Chapter = " . $chapter . ".</u>";
        $prepare_params .= " AND chapter = '" . $chapter . "'";
    }
    if ($searchtype == "spouse") {
        $PARM_preamble .= "Spouse/Partner name like " . $spouse . ".</u>";
        $prepare_params .= " AND customer_spouse LIKE '%" . $spouse . "%'";
    }
    if ($searchtype == "state") {
        $PARM_preamble .= "State = " . $state . ".</u>";
        $prepare_params .= " AND customer_state = '" . $state . "'";
    }
    if ($searchtype == "country") {
        $PARM_preamble .= "Country = " . $country . ".</u>";
        $prepare_params .= " AND customer_country = '" . $country . "'";
    }

    $prepare_params .= " ORDER BY customer_last_name ASC, customer_first_name ASC";

    $objDB = new dentalfocus_db_function();
    $resData = $objDB->dentalfocus_query($prepare_params);
    $htmlCode = "<p style=\"text-align: center; font-size: 20px;\"> " . $PARM_preamble . "</u><br>Members who have asked not to be listed are excluded.<br>Specific fields which members have asked not be shown, will not be shown.</p>";
    $htmlCode .= '<div style="margin: 0 auto; border: 4px solid sienna; padding:10px; width: 960px; background-color: white;">
    <table style="border: 0 solid blue; border-collapse: collapse; width: 100%;">
        <tbody>
            <tr style="border-bottom: 1px solid blue;">
                <th width="320px">Name (Last, First)<br>&nbsp;&nbsp;&nbsp;email address<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Spouse/Partner name<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Collecting Interests</th>
                <th width="320px">MAILING ADDRESS</th>
                <th width="180px">Home Phone<br>&nbsp;&nbsp;&nbsp;Cell Phone<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chapter</th>
            </tr>';
    if(isset($resData) && !empty($resData)){
        foreach ($resData as $keyData => $valueData){

            $customer_last_name = isset($valueData['customer_last_name']) ? $valueData['customer_last_name'] : '';
            $customer_first_name = isset($valueData['customer_first_name']) ? $valueData['customer_first_name'] : '';
            $customer_email = isset($valueData['customer_email']) ? $valueData['customer_email'] : '';
            $customer_address = isset($valueData['customer_address']) ? $valueData['customer_address'] : '';
            $customer_city = isset($valueData['customer_city']) ? $valueData['customer_city'] : '';
            $customer_state = isset($valueData['customer_state']) ? $valueData['customer_state'] : '';
            $customer_zip = isset($valueData['customer_zip']) ? $valueData['customer_zip'] : '';
            $customer_country = isset($valueData['customer_country']) ? $valueData['customer_country'] : '';
            $customer_home_phone = isset($valueData['customer_home_phone']) ? $valueData['customer_home_phone'] : '';
            $cell_phone = isset($valueData['cell_phone']) ? $valueData['cell_phone'] : '';
            $chapter = isset($valueData['chapter']) ? $valueData['chapter'] : '';

            if ($DBA == "yes") {
                $customer_last_name = $valueData['member_no'] . "  " . $valueData['customer_last_name'];
            }
            else{
                if ($valueData['No_list'] == "NSAT") {
                    $customer_address = "--------------------------";
                    $customer_city = "-------";
                    $customer_state = "--";
                    $customer_zip = "----------";
                    $customer_country = "------";
                    $customer_home_phone = "----------";
                    $cell_phone = "----------";
                }
                if ($valueData['No_list'] == "NSA") {
                    $customer_address = "---------------------------";
                    $customer_city = "--------";
                    $customer_state = "--";
                    $customer_zip = "----------";
                    $customer_country = "------";
                }
            }


            $htmlCode .= '<tr>
				<td style="vertical-align: top;">';
            $htmlCode .= $customer_last_name;
            $htmlCode .= ', ';
            $htmlCode .= $customer_first_name;
            $htmlCode .= '<br>';
            $htmlCode .= $customer_email;
            $htmlCode .= '<br></td>
				<td style="vertical-align: top;">';
            $htmlCode .= $customer_address;
            $htmlCode .= '<br>';
            $htmlCode .= $customer_city;
            $htmlCode .= ', ';
            $htmlCode .= $customer_state;
            $htmlCode .= $customer_zip;
            $htmlCode .= '<br>';
            $htmlCode .= $customer_country;
            $htmlCode .= '</td>
				<td style="vertical-align: top;">';
            $htmlCode .= $customer_home_phone;
            $htmlCode .= '<br>';
            $htmlCode .= $cell_phone;
            $htmlCode .= '<br>';
            $htmlCode .= $chapter;
            $htmlCode .= '</td></tr>';
        }
    }
    else{
        $htmlCode .= "<tr><td colspan='4' style='text-align: center;'><a href='https://demo.stein-collectors.org/member-search/'>Return to SEARCH</tr>";
    }

	$htmlCode .= '</tbody></table></div>';
    return $htmlCode;
}

/*function handle_registration_page(){
    ob_start();
    $htmlCode = "<div style=\"margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;\"><table>
<tbody>
<tr>
<td width=\"100\"><img class=\"alignnone size-full wp-image-1647\" src=\"https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg\" alt=\"\" width=\"85\" height=\"116\" /></td>
<td>There are issue with your registration, You can email us on <a href=\"mailto:treasurer@stein-collectors.org\">treasurer@stein-collectors.org</a> 

<a href=\"http://stein-collectors.org/\">Click here </a>to return to the home page of Stein Collectors International.</td>
</tr>
</tbody>
</table></div>";

    if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
        $objDB = new dentalfocus_db_function();
        $df_social_table = 'trentium_membership_payments';
        $arrayEditData = array(
            'id' => "'" . $_REQUEST['id'] . "'"
        );
        $resData = $objDB->dentalfocus_edit_records($df_social_table,$arrayEditData);
        if($resData){
            $df_users_table = 'trentium_membership_users';
            $arrayEditData = array(
                'username' => "'" . $_REQUEST['username'] . "'"
            );
            $resDataUser = $objDB->dentalfocus_edit_records($df_users_table,$arrayEditData);
            if(!empty($resDataUser)){
                $htmlCodeError = "<div style=\"margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;\"><table>
<tbody>
<tr>
<td width=\"100\"><img class=\"alignnone size-full wp-image-1647\" src=\"https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg\" alt=\"\" width=\"85\" height=\"116\" /></td>
<td>Username already used, please try with different one. Or You can connect with us on <a href=\"mailto:treasurer@stein-collectors.org\">treasurer@stein-collectors.org</a> 

<a href=\"http://stein-collectors.org/\">Click here </a>to return to the home page of Stein Collectors International.</td>
</tr>
</tbody>
</table></div>";
                echo $htmlCodeError;
                return ob_get_clean();
            }

            $arrayEditID = array(
                'last_payment_id' => "'" . $_REQUEST['id'] . "'"
            );
            $resDataUserID = $objDB->dentalfocus_edit_records($df_users_table,$arrayEditID);
            if(!empty($resDataUserID)){
                $htmlCodeError = "<div style=\"margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;\"><table>
<tbody>
<tr>
<td width=\"100\"><img class=\"alignnone size-full wp-image-1647\" src=\"https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg\" alt=\"\" width=\"85\" height=\"116\" /></td>
<td>User already created for payment, You can connect with us on <a href=\"mailto:treasurer@stein-collectors.org\">treasurer@stein-collectors.org</a> 

<a href=\"http://stein-collectors.org/\">Click here </a>to return to the home page of Stein Collectors International.</td>
</tr>
</tbody>
</table></div>";
                echo $htmlCodeError;
                return ob_get_clean();
            }

            $customer_first_name = NULL;
            if(isset($_REQUEST['customer_first_name']) && !empty($_REQUEST['customer_first_name'])){
                $customer_first_name = $_REQUEST['customer_first_name'];
            }

            $customer_last_name = NULL;
            if(isset($_REQUEST['customer_last_name']) && !empty($_REQUEST['customer_last_name'])){
                $customer_last_name = $_REQUEST['customer_last_name'];
            }

            $customer_address = NULL;
            if(isset($_REQUEST['customer_address']) && !empty($_REQUEST['customer_address'])){
                $customer_address = $_REQUEST['customer_address'];
            }

            $customer_country = NULL;
            if(isset($_REQUEST['customer_country']) && !empty($_REQUEST['customer_country'])){
                $customer_country = $_REQUEST['customer_country'];
            }

            $customer_state = NULL;
            if(isset($_REQUEST['customer_state']) && !empty($_REQUEST['customer_state'])){
                $customer_state = $_REQUEST['customer_state'];
            }

            $customer_city = NULL;
            if(isset($_REQUEST['customer_city']) && !empty($_REQUEST['customer_city'])){
                $customer_city = $_REQUEST['customer_city'];
            }

            $customer_zip = NULL;
            if(isset($_REQUEST['customer_zip']) && !empty($_REQUEST['customer_zip'])){
                $customer_zip = $_REQUEST['customer_zip'];
            }

            if(!empty($customer_first_name) && !empty($customer_last_name) && !empty($customer_address) && !empty($customer_country) && !empty($customer_state) && !empty($customer_city) && !empty($customer_zip)){

                $arrayInsertData = array(
                    'last_payment_id' => $_REQUEST['id'],
                    'customer_first_name' => isset($customer_first_name) ? strtoupper(sanitize_title($customer_first_name)) : NULL,
                    'customer_last_name' => isset($customer_last_name) ? strtoupper(sanitize_title($customer_last_name)) : NULL,
                    'customer_address' => isset($customer_address) ? strtoupper(sanitize_title($customer_address)) : NULL,
                    'customer_city' => isset($customer_city) ? strtoupper(sanitize_title($customer_city)) : NULL,
                    'customer_state' => isset($customer_state) ? strtoupper(sanitize_title($customer_state)) : NULL,
                    'customer_zip' => isset($customer_zip) ? strtoupper(sanitize_title($customer_zip)) : NULL,
                    'customer_country' => isset($customer_country) ? strtoupper(sanitize_title($customer_country)) : NULL,
                    'customer_email' => isset($_REQUEST['customer_email']) ? strtoupper($_REQUEST['customer_email']) : NULL,
                    'customer_spouse' => isset($_REQUEST['customer_spouse']) ? strtoupper($_REQUEST['customer_spouse']) : NULL,
                    'customer_home_phone' => isset($_REQUEST['customer_home_phone']) ? $_REQUEST['customer_home_phone'] : NULL,
                    'customer_mobile_phone' => isset($_REQUEST['customer_mobile_phone']) ? $_REQUEST['customer_mobile_phone'] : NULL,
                    'listing_option' => isset($_REQUEST['listing_option']) ? $_REQUEST['listing_option'] : NULL,
                    'referred_by' => isset($_REQUEST['referred_by']) ? strtoupper($_REQUEST['referred_by']) : NULL,
                    'username' => isset($_REQUEST['username']) ? $_REQUEST['username'] : NULL,
                    'password' => isset($_REQUEST['password']) ? md5($_REQUEST['password']) : NULL,
                    'purchaser_name' => isset($_REQUEST['purchaser_name']) ? strtoupper($_REQUEST['purchaser_name']) : NULL,
                    'purchaser_email' => isset($_REQUEST['purchaser_email']) ? strtoupper($_REQUEST['purchaser_email']) : NULL
                );
                $insertedId = $objDB->dentalfocus_insert_records($df_users_table,$arrayInsertData);

                if(!$insertedId){
                    if(isset($_REQUEST['username']) && !empty($_REQUEST['username']) && isset($_REQUEST['password']) && !empty($_REQUEST['password'])){
                        $userdata = array(
                            'user_login'    => $_REQUEST['username'],                // Username
                            'user_email'    => isset($_REQUEST['customer_email']) ? strtoupper($_REQUEST['customer_email']) : NULL,    // Email
                            'user_pass'     => md5($_REQUEST['password']),   // Password (optional: use wp_generate_password for auto-generation)
                            'first_name'    => isset($customer_first_name) ? strtoupper(sanitize_title($customer_first_name)) : NULL,
                            'last_name'     => isset($customer_last_name) ? strtoupper(sanitize_title($customer_last_name)) : NULL,
                            'role'          => 'subscriber'             // Assign a role (e.g., administrator, editor, subscriber)
                        );

                        // Insert the user
                        $user_id = wp_insert_user($userdata);

                        if(!$user_id){
                            $htmlCodeError = "<div style=\"margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;\"><table>
<tbody>
<tr>
<td width=\"100\"><img class=\"alignnone size-full wp-image-1647\" src=\"https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg\" alt=\"\" width=\"85\" height=\"116\" /></td>
<td>Oops Not able to create new user, You can connect with us on <a href=\"mailto:treasurer@stein-collectors.org\">treasurer@stein-collectors.org</a> 

<a href=\"http://stein-collectors.org/\">Click here </a>to return to the home page of Stein Collectors International.</td>
</tr>
</tbody>
</table></div>";
                            echo $htmlCodeError;
                            return ob_get_clean();
                        }
                        else{
                            wp_redirect('https://demo.stein-collectors.org/new-member-registration-confirmation/');
                            exit;
                        }
                    }
                    else{
                        wp_redirect('https://demo.stein-collectors.org/new-member-registration-confirmation/');
                        return ob_get_clean();
                    }
                }
                else{
                    wp_redirect('https://demo.stein-collectors.org/new-member-registration-confirmation/');
                    return ob_get_clean();
                }

            }
            else{
                echo $htmlCode;
                return ob_get_clean();
            }
        }
        else{
            echo $htmlCode;
            return ob_get_clean();
        }
    }
    else{
        echo $htmlCode;
        return ob_get_clean();
    }
}*/

function handle_registration_page()
{
    ob_start();

    // Default error HTML block
    $default_html = "<div style=\"margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;\">
        <table>
            <tbody>
                <tr>
                    <td width=\"100\">
                        <img class=\"alignnone size-full wp-image-1647\" src=\"https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg\" alt=\"\" width=\"85\" height=\"116\" />
                    </td>
                    <td>
                        There are issues with your registration. Please contact us at 
                        <a href=\"mailto:treasurer@stein-collectors.org\">treasurer@stein-collectors.org</a>.
                        <br>
                        <a href=\"http://stein-collectors.org/\">Click here</a> to return to the home page of Stein Collectors International.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>";

    // Check if `id` is provided
    if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
        return $default_html;
    }

    // Database operations
    $objDB = new dentalfocus_db_function();
    $payment_table = 'trentium_membership_payments';
    $user_table = 'trentium_membership_users';

    $payment_data = ['id' => "'" . sanitize_text_field($_REQUEST['id']) . "'"];
    $payment_result = $objDB->dentalfocus_edit_records($payment_table, $payment_data);

    if (!$payment_result) {
        return $default_html;
    }

    // Check username uniqueness
    $username = sanitize_text_field($_REQUEST['username'] ?? '');
    $user_data = ['username' => "'" . $username . "'"];
    $user_result = $objDB->dentalfocus_edit_records($user_table, $user_data);

    if (!empty($user_result)) {
        return str_replace('There are issues', 'Username already used', $default_html);
    }

    // Validate required fields
    $required_fields = ['customer_first_name', 'customer_last_name', 'customer_address', 'customer_country', 'customer_state', 'customer_city', 'customer_zip'];
    foreach ($required_fields as $field) {
        if (empty($_REQUEST[$field])) {
            return $default_html;
        }
    }

    // Prepare data for insertion
    $insert_data = [
        'last_payment_id' => sanitize_text_field($_REQUEST['id']),
        'username' => $username,
        'customer_first_name' => strtoupper(sanitize_text_field($_REQUEST['customer_first_name'])),
        'customer_last_name' => strtoupper(sanitize_text_field($_REQUEST['customer_last_name'])),
        'customer_address' => strtoupper(sanitize_text_field($_REQUEST['customer_address'])),
        'customer_city' => strtoupper(sanitize_text_field($_REQUEST['customer_city'])),
        'customer_state' => strtoupper(sanitize_text_field($_REQUEST['customer_state'])),
        'customer_zip' => strtoupper(sanitize_text_field($_REQUEST['customer_zip'])),
        'customer_country' => strtoupper(sanitize_text_field($_REQUEST['customer_country'])),
        'customer_email' => sanitize_email($_REQUEST['customer_email']),
        'password' => isset($_REQUEST['password']) ? wp_hash_password($_REQUEST['password']) : null, // Use WordPress password hashing
    ];

    $insert_result = $objDB->dentalfocus_insert_records($user_table, $insert_data);

    if (!$insert_result) {
        return str_replace('There are issues', 'User could not be created', $default_html);
    }

    $message  = "";     // initialize

    if (isset($_GET)) {
        foreach($_GET as $key => $value) {
            $message .= "GET value " . $key . "=" . $value . "\r\n";
        }
        $message .= "\r\n";
    }
    if (isset($_POST)) {
        foreach($_POST as $key => $value) {
            $message .= "POST value " . $key . "=" . $value . "\r\n";
        }
        $message .= "\r\n";
    }

    $message .= "Payment Status: " . $payment_result['payment_status'] . "\r\n";
    $message .= "PayPal pmt. of $" . $payment_result['paypal_amount'] . " for " . $payment_result['item_name'] . "\r\n";
    $message .= "email created by JoinRenew/v2/RegistrationForm-US.php" . "\r\n";

    $email_to = 'webmaster@stein-collectors.org,dbm@stein-collectors.org';
    $email_subject = "PayPal Transaction " . $payment_result['paypal_tx'] . " - Status = " . $payment_result['paypal_st'];
    $headers  = 'From: do_not_reply@stein-collectors.org' . "\r\n";
    $headers .= 'Reply-To: do_not_reply@stein-collectors.org' . "\r\n";
    $headers .= 'Bcc: webmaster@stein-collectors.org,dbm@stein-collectors.org' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    mail($email_to, $email_subject, $message, $headers);

    // Add user to WordPress
    if (!empty($username) && !empty($_REQUEST['password'])) {
        $wp_user_data = [
            'user_login' => $username,
            'user_email' => sanitize_email($_REQUEST['customer_email']),
            'user_pass' => $_REQUEST['password'], // Use plain password
            'first_name' => $insert_data['customer_first_name'],
            'last_name' => $insert_data['customer_last_name'],
            'role' => 'subscriber',
        ];

        $wp_user_id = wp_insert_user($wp_user_data);

        if (is_wp_error($wp_user_id)) {
            return str_replace('There are issues', 'WordPress user could not be created', $default_html);
        }
    }

    // Redirect on success (using JavaScript for shortcodes)
    $redirect_url = esc_url(home_url('/new-member-registration-confirmation/'));
    return "<script>window.location.href='$redirect_url';</script>";
}
function ts_convention_registration_form_handle_submission()
{
    ob_start();

    // Default error HTML block
    $default_html = "<div style=\"margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;\">
        <table>
            <tbody>
                <tr>
                    <td width=\"100\">
                        <img class=\"alignnone size-full wp-image-1647\" src=\"https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg\" alt=\"\" width=\"85\" height=\"116\" />
                    </td>
                    <td>
                        There are issues with your registration. Please contact us at 
                        <a href=\"mailto:treasurer@stein-collectors.org\">treasurer@stein-collectors.org</a>.
                        <br>
                        <a href=\"http://stein-collectors.org/\">Click here</a> to return to the home page of Stein Collectors International.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>";

    // if memberName is not set, it is not a valid attempt to execute this routine
    if (! isset($_POST["memberName"])) {
        return str_replace('There are issues with your registration', 'Invalid member name', $default_html);
    }
    if (empty($_POST["memberName"])) {
        return str_replace('There are issues with your registration', 'Invalid member name', $default_html);
    }

    // Check if `id` is provided
    if (!isset($_REQUEST['memberEmail']) || empty($_REQUEST['memberEmail'])) {
        return str_replace('There are issues with your registration', 'Invalid member email', $default_html);
    }

    if (isset($_SERVER['HTTP_REFERER'])) {
        // Store Referral URL in a variable
        $refURL = $_SERVER['HTTP_REFERER'];
        // Display the Referral URL on web page
    } else {
        $refURL = "No referer URL";
    }

    $firstMember = $_POST["firstMember"];
    $memberBadge = $_POST["memberBadge"];

    $memberName = sanitize_text_field($_REQUEST['memberName']);

    if ($memberName == "JCfUZQsq") {
        return str_replace('There are issues with your registration', 'Sorry you can not submit form.', $default_html);
    }

    $spouseName = $_POST["spouseName"];
    $firstSpouse = $_POST["firstSpouse"];
    $spouseBadge = $_POST["spouseBadge"];
    $guest1Name = $_POST["guest1Name"];
    $firstGuest1 = $_POST["firstGuest1"];
    $guest1Badge = $_POST["guest1Badge"];
    $guest2Name = $_POST["guest2Name"];
    $firstGuest2 = $_POST["firstGuest2"];
    $guest2Badge = $_POST["guest2Badge"];

    $specialNeeds = $_POST["specialNeeds"];

    $addressLine1 = $_POST["addressLine1"];
    $addressLine2 = $_POST["addressLine2"];
    $addressLine3 = $_POST["addressLine3"];
    $addressLine4 = $_POST["addressLine4"];
    $memberNumber = $_POST["memberNbr"];
    $memberPhone = $_POST["memberPhone"];
    $memberCell = $_POST["memberCell"];
    $memberEmail = $_POST["memberEmail"];
    $chapterSelect = $_POST["chapterSelect"];

    $priceSingle = $_POST["priceSingle"];
    $qtySingle = $_POST["qtySingle"];

    $priceCouple = $_POST["priceCouple"];
    $qtyCouple = $_POST["qtyCouple"];

    $priceEvent1 = $_POST["priceEvent1"];
    $qtyEvent1 = $_POST["qtyEvent1"];
    $textEvent1 = $_POST["textEvent1"];

    $priceEvent2 = $_POST["priceEvent2"];
    $qtyEvent2 = $_POST["qtyEvent2"];
    $textEvent2 = $_POST["textEvent2"];

    $priceEvent3 = $_POST["priceEvent3"];
    $qtyEvent3 = $_POST["qtyEvent3"];
    $textEvent3 = $_POST["textEvent3"];

    $priceEvent4 = $_POST["priceEvent4"];
    $qtyEvent4 = $_POST["qtyEvent4"];
    $textEvent4 = $_POST["textEvent4"];

    $priceTea = $_POST["priceTea"];
    $qtyTea = $_POST["qtyTea"];
    $textTea = $_POST["textTea"];

    $priceFullTables = $_POST["priceFullTables"];
    $qtyFullTables = $_POST["qtyFullTables"];

    $priceHalfTables = $_POST["priceHalfTables"];
    $qtyHalfTables = $_POST["qtyHalfTables"];

    $priceSteins = $_POST["priceSteins"];
    $qtySteins = $_POST["qtySteins"];

    $qtyThursdayDinner = $_POST["qtyThursdayDinner"];
    $qtyThursEntree1 = $_POST["qtyThursEntree1"];
    $textThursEntree1 = $_POST["textThursEntree1"];
    $qtyThursEntree2 = $_POST["qtyThursEntree2"];
    $textThursEntree2 = $_POST["textThursEntree2"];
    $qtyThursEntree3 = $_POST["qtyThursEntree3"];
    $textThursEntree3 = $_POST["textThursEntree3"];
    $qtyThursEntree4 = $_POST["qtyThursEntree4"];
    $textThursEntree4 = $_POST["textThursEntree4"];

    $qtySaturdayDinner = $_POST["qtySaturdayDinner"];
    $qtySatEntree1 = $_POST["qtySatEntree1"];
    $textSatEntree1 = $_POST["textSatEntree1"];
    $qtySatEntree2 = $_POST["qtySatEntree2"];
    $textSatEntree2 = $_POST["textSatEntree2"];
    $qtySatEntree3 = $_POST["qtySatEntree3"];
    $textSatEntree3 = $_POST["textSatEntree3"];
    $qtySatEntree4 = $_POST["qtySatEntree4"];
    $textSatEntree4 = $_POST["textSatEntree4"];

    // totals for each item must be recalculated for browsers which do not have scripting enabled
    $totalSingle = $qtySingle * $priceSingle;
    $totalCouple = $qtyCouple * $priceCouple;
    $totalEvent1 = $qtyEvent1 * $priceEvent1;
    $totalEvent2 = $qtyEvent2 * $priceEvent2;
    $totalEvent3 = $qtyEvent3 * $priceEvent3;
    $totalEvent4 = $qtyEvent4 * $priceEvent4;
    $totalTea = $qtyTea * $priceTea;
    $totalFullTables = $qtyFullTables * $priceFullTables;
    $totalHalfTables = $qtyHalfTables * $priceHalfTables;
    $totalSteins = $qtySteins * $priceSteins;

    $grandTotal = $totalSingle
        + $totalCouple
        + $totalEvent1
        + $totalEvent2
        + $totalEvent3
        + $totalTea
        + $totalFullTables
        + $totalHalfTables
        + $totalSteins;

    // ----- one more check for illegitimate execution of this routine
    if ($grandTotal == 0) {
        return str_replace('There are issues with your registration', 'Total amount must be grater than 0', $default_html);
    }

    $minimumDeposit = $_POST["minimumDeposit"];
    $amountToPay = $_POST["amountToPay"];


    $htmlContent = '
       <html>
       <head>
   		<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
   		<meta name="viewport" content="width=device-width">
           <title>Convention Registration Details</title>
   		<style type="text/css">

   			* {
   			box-sizing: border-box;
   			font-family: arial, sans-serif;
   			font-size: 1em;
   			color: navy;
   			}

   			table, th, td {
   				padding: 5px;
   				font-family: arial, sans-serif, sans serif;
   				font-size: 1em;
   			}

   		</style>

       </head>
   	<body>
   <div style="max-width: 700px;">
           <h2>We look forward to seeing you in Madison, Wisconsin at SCIs 57th annual convention!<br>Early Bird days - July 2-3, Convention - July 4-6</h2>
           <h3>You will receive a confirmation email when your payment is received.</h3>
           <table cellspacing="6" style="max-width: 100%; border-collapse: collapse; padding: 10px;">';

    $htmlContent .= '<tr><td colspan="4">SCI convention registration information for ' . $memberName . ' is shown below.</td></tr>';
    $htmlContent .= '<tr style="border-bottom: 2px solid lightgray;"><td>ATTENDEES</td><td>Name</td><td>First<br>Timer?</td><td>Badge name</td></tr>';
    $htmlContent .= '<tr><td>Member</td><td>' . $memberName . '</td><td>' . $firstMember . '</td><td>' . $memberBadge . '</td></tr>';
    if ($spouseName != "") {
        $htmlContent .= '<tr><td>Spouse/Partner</td><td>' . $spouseName . '</td><td>' . $firstSpouse . '</td><td>' . $spouseBadge . '</td></tr>';
    }
    if ($guest1Name != "") {
        $htmlContent .= '<tr><td>Guest 1</td><td>' . $guest1Name . '</td><td>' . $firstGuest1 . '</td><td>' . $guest1Badge . '</td></tr>';
    }
    if ($guest2Name != "") {
        $htmlContent .= '<tr><td>Guest 2</td><td>' . $guest2Name . '</td><td>' . $firstGuest2 . '</td><td>' . $guest2Badge . '</td></tr>';
    }

    $htmlContent .= '<tr><td>&nbsp;</td></tr><tr style="border-bottom: 2px solid lightgray;"><td colspan=4>MEMBERS CONTACT INFORMATION</td></tr>';
    $htmlContent .= '<tr><td colspan=2>' . $memberName   . '</td><td>' . 'Mbr. #'  . '</td><td>' . $memberNumber  . '</td></tr>';
    $htmlContent .= '<tr><td colspan=2>' . $addressLine1 . '</td><td>' . 'phone'   . '</td><td>' . $memberPhone   . '</td></tr>';
    $htmlContent .= '<tr><td colspan=2>' . $addressLine2 . '</td><td>' . 'cell'    . '</td><td>' . $memberCell    . '</td></tr>';
    $htmlContent .= '<tr><td colspan=2>' . $addressLine3 . '</td><td>' . 'email'   . '</td><td>' . $memberEmail   . '</td></tr>';
    $htmlContent .= '<tr><td colspan=2>' . $addressLine4 . '</td><td>' . 'chapter' . '</td><td>' . $chapterSelect . '</td></tr>';

    $htmlContent .= '</table>';

    //second table with fees, costs and other choices

    // FEES

    $htmlContent .= '<table style="max-width: 100%; border-collapse: collapse; border: 2px dashed blue; background-color: lightgray; overflow: auto;">
   							<tr style="border-bottom: 2px solid blue;"><td style="font-weight: bold; color: blue;">FEES</td><td  style="width=50px; text-align: right;">Qty</td><td  style="width=50px; text-align: right;">Price</td><td  style="width=50px; text-align: right;">Cost</td></tr>';

    if ($qtySingle != 0) {
        $htmlContent .= '<tr><td>Single registrations</td><td align=right>' . $qtySingle . '</td><td align=right>' . '$' . $priceSingle . '</td><td align=right>' . '$' . $totalSingle . '</td></tr>' ;
    }

    if ($qtyCouple != 0) {
        $htmlContent .= '<tr><td>Couple registrations</td><td align=right>' . $qtyCouple . '</td><td align=right>' . '$' . $priceCouple . '</td><td align=right>' . '$' . $totalCouple . '</td></tr>' ;
    }

    if ($textEvent1 !== 'not used') {
        if ($qtyEvent1 != 0) {
            $htmlContent .= '<tr><td>' . $textEvent1 . '</td><td align=right>' . $qtyEvent1 . '</td><td align=right>' . '$' . $priceEvent1 . '</td><td align=right>' . '$' . $totalEvent1 . '</td></tr>';
        }
    }

    if ($textEvent2 !== 'not used') {
        if ($qtyEvent2 != 0) {
            $htmlContent .= '<tr><td>' . $textEvent2 . '</td><td align=right>' . $qtyEvent2 . '</td><td align=right>' . '$' . $priceEvent2 . '</td><td align=right>' . '$' . $totalEvent2 . '</td></tr>';
        }
    }

    if ($textEvent3 !== 'not used') {
        if ($qtyEvent3 != 0) {
            $htmlContent .= '<tr><td>' . $textEvent3 . '</td><td align=right>' . $qtyEvent3 . '</td><td align=right>' . '$' . $priceEvent3 . '</td><td align=right>' . '$' . $totalEvent3 . '</td></tr>';
        }
    }

    if ($textEvent4 !== 'not used') {
        if ($qtyEvent4 != 0) {
            $htmlContent .= '<tr><td>' . $textEvent4 . '</td><td align=right>' . $qtyEvent4 . '</td><td align=right>' . '$' . $priceEvent4 . '</td><td align=right>' . '$' . $totalEvent4 . '</td></tr>';
        }
    }

    if ($textTea !== 'not used') {
        if ($qtyTea != 0) {
            $htmlContent .= '<tr><td>' . $textTea . '</td><td align=right>' . $qtyTea . '</td><td align=right>' . '$' . $priceTea . '</td><td align=right>' . '$' . $totalTea . '</td></tr>';
        }
    }

    if ($qtyFullTables != 0) {
        $htmlContent .= '<tr><td>Full Sales Tables</td><td align=right>' . $qtyFullTables . '</td><td align=right>' . '$' . $priceFullTables . '</td><td align=right>' . '$' . $totalFullTables . '</td></tr></tr>';
    }

    if ($qtyHalfTables != 0) {
        $htmlContent .= '<tr><td>Half Sales Tables</td><td align=right>' . $qtyHalfTables . '</td><td align=right>' . '$' . $priceHalfTables . '</td><td align=right>' . '$' . $totalHalfTables . '</td></tr>';
    }

    if ($qtySteins != 0) {
        $htmlContent .= '<tr><td>Additional convention steins</td><td align=right>' . $qtySteins . '</td><td align=right>' . '$' . $priceSteins . '</td><td align=right>' . '$' . $totalSteins . '</td></tr>';
    }

    $htmlContent .= '<tr><td colspan=4></td></tr>
   				<tr><td colspan=3>TOTAL REGISTRATION COST</td><td align=right>' . '$' . $grandTotal . '</td></tr>';

    $htmlContent .= '<tr style="border-bottom: 2px solid blue;"><td style="font-weight: bold; color: blue;" colspan=4><br><br>OTHER CHOICES / INSTRUCTIONS</td></tr>';
    $htmlContent .= '<tr><td colspan=4>Thursday Night Dinner Choice(s)';
    if ($qtyThursdayDinner == 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;None specified.';
    }
    if ($qtyThursEntree1 != 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qtyThursEntree1 . ' ' . $textThursEntree1 ;
    }
    if ($qtyThursEntree2 != 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qtyThursEntree2 . ' ' . $textThursEntree2 ;
    }
    if ($qtyThursEntree3 != 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qtyThursEntree3 . ' ' . $textThursEntree3 ;
    }
    if ($qtyThursEntree4 != 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qtyThursEntree4 . ' ' . $textThursEntree4 ;
    }
    $htmlContent .= '</td></tr>';

    $htmlContent .= '<tr><td colspan=4>Saturday Night Dinner Choice(s)';
    if ($qtySaturdayDinner == 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;None specified.';
    }
    if ($qtySatEntree1 != 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qtySatEntree1 . ' ' . $textSatEntree1 ;
    }
    if ($qtySatEntree2 != 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qtySatEntree2 . ' ' . $textSatEntree2 ;
    }
    if ($qtySatEntree3 != 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qtySatEntree3 . ' ' . $textSatEntree3 ;
    }
    if ($qtySatEntree4 != 0) {
        $htmlContent .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qtySatEntree4 . ' ' . $textSatEntree4 ;
    }
    $htmlContent .= '</td></tr>';

    if ($specialNeeds == "") {
        $specialNeeds = "none specified";
    }
    $htmlContent .= '<tr><td colspan=4>Dietary Restrictions or Special Needs<br><p style="padding-left: 10px; margin-top: 0px; color: red;">' . $specialNeeds . '</p></td></tr>';

    $htmlContent .= '</table>';

    $htmlContent .=  '<p style="text-align: justify; max-width: 85%;">SCI has negotiated a special room rate with The Madison Concourse and Governors Club of $139 for either a single or double room. The rate is available three days pre- and post-convention. Register as soon as possible to ensure you receive this special rate. To make your reservation call the hotel directly, toll free, at 1-800-356-8293 - say you are with the Stein Collectors International 2024 Annual Convention.
   </p>
   <p style="font-size:1.3em; font-weight: bold;">
   Questions about your REGISTRATION?<br>Contact Celia Clark at crro26@gmail.com or 936-828-6539<BR><BR>
   Questions about the CONVENTION?<br>Contact David Bruha at dsbruha@Frontier.com or 715-277-3796
   </p>
   <p style="font-size: small;">email generated by <br>' . $refURL . '</p>';

    $htmlContent .= '</td></tr>';
    $htmlContent .= '</table>';
    $htmlContent .= '</div>';

    $htmlContent .=  '</body></html>';

    // Set content-type header for sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $replyTo = "crro26@gmail.com";
    $CC = "crro26@gmail.com,dsbruha@Frontier.com,webmaster@stein-collectors.org";

    // set FROM and CC values for email
    $headers .= 'From: SCI_Convention_Coordinator@steincollectors.org' . "\r\n";
    $headers .= 'Reply-To: ' . $replyTo . "\r\n";
    $headers .= 'CC:  ' . $CC  . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    $to = $memberEmail;
    $subject = "SCI Convention Registration for: " . $memberName;

    // Send email and check status
    // if (! mail($to,$subject,$htmlContent,$headers)) {
    //      echo('Non-specific system failure, please go back and resubmit your registration request.');
    //  	exit();
    //}
    mail($to,$subject,$htmlContent,$headers);

    // Database operations
    $objDB = new dentalfocus_db_function();
    $convention_table = 'trentium_convention';

    // Prepare data for insertion
    $insert_data = [
        'member_name' => $memberName,
        'first_member' => sanitize_text_field($_REQUEST['firstMember']),
        'member_badge' => sanitize_text_field($_REQUEST['memberBadge']),
        'spouse_name' => sanitize_text_field($_REQUEST['spouseName']),
        'first_spouse' => sanitize_text_field($_REQUEST['firstSpouse']),
        'spouse_badge' => sanitize_text_field($_REQUEST['spouseBadge']),
        'guest1_name' => sanitize_text_field($_REQUEST['guest1Name']),
        'first_guest1' => sanitize_text_field($_REQUEST['firstGuest1']),
        'guest1_badge' => sanitize_text_field($_REQUEST['guest1Badge']),
        'guest2_name' => sanitize_text_field($_REQUEST['guest2Name']),
        'first_guest2' => sanitize_text_field($_REQUEST['firstGuest2']),
        'guest2_badge' => sanitize_text_field($_REQUEST['guest2Badge']),
        'special_needs' => sanitize_text_field($_REQUEST['specialNeeds']),
        'address_line1' => sanitize_text_field($_REQUEST['addressLine1']),
        'address_line2' => sanitize_text_field($_REQUEST['addressLine2']),
        'address_line3' => sanitize_text_field($_REQUEST['addressLine3']),
        'address_line4' => sanitize_text_field($_REQUEST['addressLine4']),
        'member_nbr' => sanitize_text_field($_REQUEST['memberNbr']),
        'member_phone' => sanitize_text_field($_REQUEST['memberPhone']),
        'member_cell' => sanitize_text_field($_REQUEST['memberCell']),
        'member_email' => sanitize_text_field($_REQUEST['memberEmail']),
        'chapter_select' => sanitize_text_field($_REQUEST['chapterSelect']),
        'price_single' => sanitize_text_field($_REQUEST['priceSingle']),
        'qty_single' => sanitize_text_field($_REQUEST['qtySingle']),
        'total_single' => sanitize_text_field($_REQUEST['totalSingle']),
        'price_couple' => sanitize_text_field($_REQUEST['priceCouple']),
        'qty_couple' => sanitize_text_field($_REQUEST['qtyCouple']),
        'total_couple' => sanitize_text_field($_REQUEST['totalCouple']),
        'price_event1' => sanitize_text_field($_REQUEST['priceEvent1']),
        'qty_event1' => sanitize_text_field($_REQUEST['qtyEvent1']),
        'total_event1' => sanitize_text_field($_REQUEST['totalEvent1']),
        'text_event1' => sanitize_text_field($_REQUEST['textEvent1']),
        'price_event2' => sanitize_text_field($_REQUEST['priceEvent2']),
        'qty_event2' => sanitize_text_field($_REQUEST['qtyEvent2']),
        'total_event2' => sanitize_text_field($_REQUEST['totalEvent2']),
        'text_event2' => sanitize_text_field($_REQUEST['textEvent2']),
        'price_event3' => sanitize_text_field($_REQUEST['priceEvent3']),
        'qty_event3' => sanitize_text_field($_REQUEST['qtyEvent3']),
        'total_event3' => sanitize_text_field($_REQUEST['totalEvent3']),
        'text_event3' => sanitize_text_field($_REQUEST['textEvent3']),
        'price_event4' => sanitize_text_field($_REQUEST['priceEvent4']),
        'qty_event4' => sanitize_text_field($_REQUEST['qtyEvent4']),
        'total_event4' => sanitize_text_field($_REQUEST['totalEvent4']),
        'text_event4' => sanitize_text_field($_REQUEST['textEvent4']),
        'price_tea' => sanitize_text_field($_REQUEST['priceTea']),
        'qty_tea' => sanitize_text_field($_REQUEST['qtyTea']),
        'total_tea' => sanitize_text_field($_REQUEST['totalTea']),
        'text_tea' => sanitize_text_field($_REQUEST['textTea']),
        'price_full_tables' => sanitize_text_field($_REQUEST['priceFullTables']),
        'qty_full_tables' => sanitize_text_field($_REQUEST['qtyFullTables']),
        'total_full_tables' => sanitize_text_field($_REQUEST['totalFullTables']),
        'price_half_tables' => sanitize_text_field($_REQUEST['priceHalfTables']),
        'qty_half_tables' => sanitize_text_field($_REQUEST['qtyHalfTables']),
        'total_half_tables' => sanitize_text_field($_REQUEST['totalHalfTables']),
        'price_steins' => sanitize_text_field($_REQUEST['priceSteins']),
        'qty_steins' => sanitize_text_field($_REQUEST['qtySteins']),
        'total_steins' => sanitize_text_field($_REQUEST['totalSteins']),
        'grand_total' => sanitize_text_field($_REQUEST['grandTotal']),
        'minimum_deposit' => sanitize_text_field($_REQUEST['minimumDeposit']),
        'amount_to_pay' => sanitize_text_field($_REQUEST['amountToPay']),
        'qty_thursday_dinner' => sanitize_text_field($_REQUEST['qtyThursdayDinner']),
        'qty_thurs_entree1' => sanitize_text_field($_REQUEST['qtyThursEntree1']),
        'qty_thurs_entree2' => sanitize_text_field($_REQUEST['qtyThursEntree2']),
        'qty_thurs_entree3' => sanitize_text_field($_REQUEST['qtyThursEntree3']),
        'qty_thurs_entree4' => sanitize_text_field($_REQUEST['qtyThursEntree4']),
        'text_thurs_entree1' => sanitize_text_field($_REQUEST['textThursEntree1']),
        'text_thurs_entree2' => sanitize_text_field($_REQUEST['textThursEntree2']),
        'text_thurs_entree3' => sanitize_text_field($_REQUEST['textThursEntree3']),
        'text_thurs_entree4' => sanitize_text_field($_REQUEST['textThursEntree4']),
        'qty_saturday_dinner' => sanitize_text_field($_REQUEST['qtySaturdayDinner']),
        'qty_sat_entree1' => sanitize_text_field($_REQUEST['qtySatEntree1']),
        'qty_sat_entree2' => sanitize_text_field($_REQUEST['qtySatEntree2']),
        'qty_sat_entree3' => sanitize_text_field($_REQUEST['qtySatEntree3']),
        'qty_sat_entree4' => sanitize_text_field($_REQUEST['qtySatEntree4']),
        'text_sat_entree1' => sanitize_text_field($_REQUEST['textSatEntree1']),
        'text_sat_entree2' => sanitize_text_field($_REQUEST['textSatEntree2']),
        'text_sat_entree3' => sanitize_text_field($_REQUEST['textSatEntree3']),
        'text_sat_entree4' => sanitize_text_field($_REQUEST['textSatEntree4']),
        'qty_monday_dinner' => sanitize_text_field($_REQUEST['qtyMondayDinner']),
        'created_at' => date("Y-m-d H:i:s"),
    ];

    $insert_result = $objDB->dentalfocus_insert_records($convention_table, $insert_data,true);

    if (!$insert_result) {
        return str_replace('There are issues', 'User could not be created', $default_html);
    }

    $cancel_url = home_url('/ts-paypal-con-cancel'); // Redirect to 'cancel' page
    $return_url = home_url('/ts-paypal-con-thankyou'); // Redirect to 'thank-you' page

    $itemName = 'SCI Convention Deposit:' . $memberName;

    $custom_data = json_encode(array(
        'id' => intval($insert_result),
        'amount_to_pay' => $_REQUEST['amountToPay'],
        'member_email' => $_REQUEST['memberEmail'],
        'member_name' => $memberName,
    ));
    // Redirect to avoid resubmission on refresh
    $paypal_url = add_query_arg(
        array(
            'cmd' => '_xclick',
            'charset' => 'utf-8',
            'business' => 'treasurer@stein-collectors.org', // Your PayPal business email
            'item_name' => $itemName,          // Item name
            'amount' => $_REQUEST['amountToPay'],               // Payment amount
            'return' => $return_url,        // Return URL
            'cancel_return' => $cancel_url,     // Cancel URL
            'custom' => base64_encode($custom_data),
        ),
        'https://www.paypal.com/cgi-bin/webscr'
    );

    // Use wp_redirect to redirect to PayPal
    wp_redirect($paypal_url);
    exit;
}

function handle_return_page()
{
    ob_start();
    $htmlCode = "<div style=\"margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;\"><table>
<tbody>
<tr>
<td width=\"100\"><img class=\"alignnone size-full wp-image-1647\" src=\"https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg\" alt=\"\" width=\"85\" height=\"116\" /></td>
<td>There are issue with payment, You can email us on <a href=\"mailto:treasurer@stein-collectors.org\">treasurer@stein-collectors.org</a> 

<a href=\"http://stein-collectors.org/\">Click here </a>to return to the home page of Stein Collectors International.</td>
</tr>
</tbody>
</table></div>";

    if (isset($_REQUEST['custom']) && !empty($_REQUEST['custom'])) {
        $custom_data = json_decode(base64_decode(sanitize_text_field($_REQUEST['custom'])), true);

        if ($custom_data) {
            $membership = $custom_data['membership'];
            $print_or_digital = $custom_data['print_or_digital'];
            $country = $custom_data['country'];
            $term = $custom_data['id'];

            $objDB = new dentalfocus_db_function();

            /*$df_settings = 'trentium_membership_settings';
            $arrayEditData = array(
                'id' => intval($term)
            );
            $resData = $objDB->dentalfocus_edit_records($df_settings,$arrayEditData);*/
            $df_social_table = 'trentium_membership_payments';
            $arrayEditData = array(
                'txn_id' => "'" . $_REQUEST['txn_id'] . "'"
            );

            $resData = $objDB->dentalfocus_edit_records($df_social_table, $arrayEditData);
            if (!$resData) {
                $arrayInsertData = array(
                    'memership_term' => $term,
                    'memership_country' => $country,
                    'print_or_digital' => $print_or_digital,
                    'membership' => $membership,
                    'paypal_payer_id' => $_REQUEST['PayerID'],
                    'paypal_st' => $_REQUEST['st'],
                    'paypal_tx' => $_REQUEST['tx'],
                    'paypal_cc' => $_REQUEST['cc'],
                    'paypal_amount' => $_REQUEST['amt'],
                    'payer_email' => $_REQUEST['payer_email'],
                    'payer_id' => $_REQUEST['payer_id'],
                    'payer_status' => $_REQUEST['payer_status'],
                    'first_name' => $_REQUEST['first_name'],
                    'last_name' => $_REQUEST['last_name'],
                    'address_name' => $_REQUEST['address_name'],
                    'address_street' => $_REQUEST['address_street'],
                    'address_city' => $_REQUEST['address_city'],
                    'address_state' => $_REQUEST['address_state'],
                    'address_country_code' => $_REQUEST['address_country_code'],
                    'address_zip' => $_REQUEST['address_zip'],
                    'residence_country' => $_REQUEST['residence_country'],
                    'txn_id' => $_REQUEST['txn_id'],
                    'mc_currency' => $_REQUEST['mc_currency'],
                    'mc_fee' => $_REQUEST['mc_fee'],
                    'mc_gross' => $_REQUEST['mc_gross'],
                    'protection_eligibility' => $_REQUEST['protection_eligibility'],
                    'payment_fee' => $_REQUEST['payment_fee'],
                    'payment_gross' => $_REQUEST['payment_gross'],
                    'payment_status' => $_REQUEST['payment_status'],
                    'payment_type' => $_REQUEST['payment_type'],
                    'handling_amount' => $_REQUEST['handling_amount'],
                    'shipping' => $_REQUEST['shipping'],
                    'item_name' => $_REQUEST['item_name'],
                    'quantity' => $_REQUEST['quantity'],
                    'txn_type' => $_REQUEST['txn_type'],
                    'payment_date' => $_REQUEST['payment_date'],
                    'receiver_id' => $_REQUEST['receiver_id'],
                    'notify_version' => $_REQUEST['notify_version'],
                    'verify_sign' => $_REQUEST['verify_sign'],
                );
                $recordID = $objDB->dentalfocus_insert_records($df_social_table, $arrayInsertData);
            } else {
                $recordID = $resData['id'];
            }
            $arrayInsertData['id'] = $recordID;
            if ($membership === "New") {
                $registration_url = home_url('/ts-new-member-registration');
                if ($country === "US") {
                    $htmlCodeReg = '<style>
    input[type=text], input[type=url], input[type=email], input[type=password], input[type=tel] {
        -webkit-appearance: none;
        -moz-appearance: none;
        display: block;
        margin: 0;
        width: 100%;
        height: 40px;
        line-height: 40px;
        font-size: 17px;
        border: 1px solid black;
        background-color: lightgray;
    }

    /*p {
        color: navy;
        font-size: 16px;
    }*/

    textarea {
        width: 100%;
        height: 60px;
        padding: 0px;
        box-sizing: border-box;
        border: 1px solid black;
        border-radius: 0px;
        background-color: lightgray;
        font-size: 16px;
        resize: none;
    }

    select {
        width: 100%;
        height: 40px;
        border: 1px solid black;
        background-color: lightgray;
        font-size: 1em;
    }

    label {
        float: right;
        margin-right: 20px;
        color: navy;
        font-size: 16px;
        font-weight: bold;
    }
</style>';
                    $htmlCodeReg .= '<div style="margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;">
    <form id="new_registration" action="' . $registration_url . '" method="post" style="font-size: 1em;">
        <input type="hidden" name="id" value="' . $recordID . '">
        <fieldset
                style="border: 4px solid sienna; margin: 0pt auto; padding: 5px; max-width: 800px; background-color: white;">
            <legend style="font-size: 2em; color: blue; margin-left: 30px;">Welcome&nbsp;to&nbsp;SCI</legend>
            <table style="max-width: 100%; border-collapse: collapse;">
                <tbody>
                <tr>
                    <td colspan="2">
                        <p style="text-align: justify;"><img
                                src="https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg"
                                alt="" align="left" hspace="10"><span style="color: blue;">Before we can
start your
subscription we need your mailing address, and we hope you will provide
other
personal information as well. If you have an email address, we hope you will
provide it to us so that we may communicate with you in the future
regarding your membership/subscription. SCI member information is never used or shared for
any commercial purpose.</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p style="text-align: center;"><span style="font-weight: bold;">All
data entered below
should
be for the subscriber.  Fields marked with * are required.</span><br>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td><label>* First Name:</label></td>
                    <td><input name="customer_first_name" id="customer_first_name" size="20" required type="text"></td>
                </tr>
                <tr>
                    <td><label>* Last Name:</label></td>
                    <td><input name="customer_last_name" id="customer_last_name" size="20" required type="text"></td>
                </tr>
                <tr>
                    <td><label>* Address:</label></td>
                    <td><input class="long" id="customer_address" name="customer_address" size="20"
                               required type="text"></td>
                </tr>
                <tr>
                    <td><label>* City:</label></td>
                    <td><input name="customer_city" id="customer_city" size="20" required type="text"></td>
                </tr>
                <tr>
                    <td><label>* State (choose)</label></td>
                    <td>
                        <select name="customer_state" id="customer_state" required placeholder="Select">
                            <option>Select</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Conneticut</option>
                            <option value="DE">Deleware</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>* Zip code:</label></td>
                    <td><input name="customer_zip" id="customer_zip" size="20" required type="text"></td>
                </tr>
                <input type="hidden" name="customer_country" value="USA">
                <tr>
                    <td><label>Email:</label></td>
                    <td><input name="customer_email" id="customer_email" size="20"
                               placeholder="We will respect your privacy." type="email"></td>
                </tr>
                <tr>
                    <td><label>Spouse/Partner:</label></td>
                    <td><input name="customer_spouse" id="customer_spouse" size="20" type="text"></td>
                </tr>
                <tr>
                    <td><label>Home Phone:</label></td>
                    <td><input name="customer_home_phone" id="customer_home_phone" size="20" type="tel"></td>
                </tr>
                <tr>
                    <td><label>Mobile Phone:</label></td>
                    <td><input name="customer_mobile_phone" id="customer_mobile_phone" size="20" type="tel"></td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td><label>Collecting Interests</label></td>
                    <td><textarea name="collecting_interests" id="collecting_interests" form="registration"
                                  placeholder="Other members may share the same interests..."></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><em>To foster communications among our members
                        we maintain an online directory.<br>No personal information will be
                        published or shared without your
                        permission.</em></td>
                </tr>
                <tr>
                    <td><label>Directory listing option (select)</label></td>
                    <td>
                        <select name="listing_option" id="listing_option">
                            <option value="">List with no restrictions</option>
                            <option value="NSA">List me without street address</option>
                            <option value="NSAT">List me without street address or telephone</option>
                            <option value="N">Do not list me in the directory</option>
                        </select>
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td><label>Referred By:</label></td>
                    <td><input name="referred_by" id="referred_by" size="20" type="text"></td>
                </tr>
                <tr style="border-top: 2px solid sienna; background-color: wheat;">
                    <td colspan="2">
                        <p><strong><em>Username</em></strong>
                            and <strong><em>password</em></strong>
                            are optional, although you will need them if you have an <em><strong>eProsit</strong></em>
                            subscription, or if you want to be able to log in to other portions of
                            the Members Only area (e.g., to access the membership directory).</p>
                    </td>
                </tr>
                <tr style="background-color: wheat;">
                    <td><label>Member\'s Username:</label></td>
                    <td><input name="username" id="username" size="20" type="text"></td>
                </tr>
                <tr style="background-color: wheat;">
                    <td><label>Member\'s Password:</label></td>
                    <td><input name="password" id="password" size="20" type="text"></td>
                </tr>
                <tr
                        style="border-bottom: 2px solid sienna; background-color: wheat; height: 10px;">
                    <td><br>
                    </td>
                    <td><br>
                    </td>
                </tr>
                <tr style="background-color: wheat;">
                    <td colspan="2"><strong><em>If
                        this is a gift or you are
                        making
                        payment on behalf of someone else,</em></strong> please give us your name and
                        email address so we can properly associate your PayPal payment with this subscription. We will
                        send you an email confirming your payment.
                    </td>
                </tr>
                <tr style="background-color: wheat;">
                    <td><label>Purchaser\'s name:</label></td>
                    <td><input name="purchaser_name" id="purchaser_name" type="text"></td>
                </tr>
                <tr style="background-color: wheat;">
                    <td><label>Purchaser\'s email:</label></td>
                    <td><input name="purchaser_email" id="purchaser_email"
                               placeholder="We will respect your privacy." type="text"></td>
                </tr>
                <tr
                        style="border-bottom: 2px solid sienna; background-color: wheat; height: 10px;">
                    <td><br>
                    </td>
                    <td><br>
                    </td>
                </tr>
                <tr>
                    <td
                            style="padding: 10px; font-weight: bold; color: blue; text-align: center;"
                            colspan="2">Registration
                        is not complete until you click this button --
                        <button type="submit" class="button" style="border: 2px solid blue;">Register</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </fieldset>
    </form>
</div>';
                    echo $htmlCodeReg;
                    return ob_get_clean();
                }
                else {
                    $htmlCodeReg = '<style>
    input[type=text], input[type=url], input[type=email], input[type=password], input[type=tel] {
        -webkit-appearance: none;
        -moz-appearance: none;
        display: block;
        margin: 0;
        width: 100%;
        height: 40px;
        line-height: 40px;
        font-size: 17px;
        border: 1px solid black;
        background-color: lightgray;
    }

    textarea {
        width: 100%;
        height: 60px;
        padding: 0px;
        box-sizing: border-box;
        border: 1px solid black;
        border-radius: 0px;
        background-color: lightgray;
        font-size: 16px;
        resize: none;
    }

    select {
        width: 100%;
        height: 40px;
        border: 1px solid black;
        background-color: lightgray;
        font-size: 1em;
    }

    label {
        float: right;
        margin-right: 20px;
        color: navy;
        font-size: 16px;
        font-weight: bold;
    }
</style>';
                    $htmlCodeReg .= '<div style="margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;">
    <form id="new_registration" action="' . $registration_url . '" method="post" style="font-size: 1em;">
        <input type="hidden" name="id" value="' . $recordID . '">
        <fieldset
                style="border: 4px solid sienna; margin: 0pt auto; padding: 5px; max-width: 800px; background-color: white;">
            <legend style="font-size: 2em; color: blue; margin-left: 30px;">Welcome&nbsp;to&nbsp;SCI</legend>
            <table style="max-width: 100%; border-collapse: collapse;">
                <tbody>
                <tr>
                    <td colspan="2">
                        <p style="text-align: justify;"><img
                                src="https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg"
                                alt="" align="left" hspace="10"><span style="color: blue;">Before we can
start your
subscription we need your mailing address, and we hope you will provide
other
personal information as well. If you have an email address, we hope you will
provide it to us so that we may communicate with you in the future
regarding your membership/subscription. SCI member information is never used or shared for
any commercial purpose.</span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p style="text-align: center;"><span style="font-weight: bold;">All
data entered below
should
be for the subscriber.  Fields marked with * are required.</span><br>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td><label>* First Name:</label></td>
                    <td><input name="customer_first_name" id="customer_first_name" size="20" required type="text"></td>
                </tr>
                <tr>
                    <td><label>* Last Name:</label></td>
                    <td><input name="customer_last_name" id="customer_last_name" size="20" required type="text"></td>
                </tr>
                <tr>
                    <td><label>* Address:</label></td>
                    <td><input class="long" id="customer_address" name="customer_address" size="20"
                               required type="text"></td>
                </tr>
                <tr>
                    <td><label>* City:</label></td>
                    <td><input name="customer_city" id="customer_city" size="20" required type="text"></td>
                </tr>
                <tr>
                    <td><label>* State: </label></td>
                    <td><input name="customer_state" id="customer_state" size="20" required type="text"></td>
                </tr>
                <tr>
                    <td><label>* Post code:</label></td>
                    <td><input name="customer_zip" id="customer_zip" size="20" required type="text"></td>
                </tr>
                <tr>
                    <td><label>* Country:</label></td>
                    <td><input name="customer_country" id="customer_country" size="20" required type="text"></td>
                </tr>
                <tr>
                    <td><label>Email:</label></td>
                    <td><input name="customer_email" id="customer_email" size="20"
                               placeholder="We will respect your privacy." type="email"></td>
                </tr>
                <tr>
                    <td><label>Spouse/Partner:</label></td>
                    <td><input name="customer_spouse" id="customer_spouse" size="20" type="text"></td>
                </tr>
                <tr>
                    <td><label>Home Phone:</label></td>
                    <td><input name="customer_home_phone" id="customer_home_phone" size="20" type="tel"></td>
                </tr>
                <tr>
                    <td><label>Mobile Phone:</label></td>
                    <td><input name="customer_mobile_phone" id="customer_mobile_phone" size="20" type="tel"></td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td><label>Collecting Interests</label></td>
                    <td><textarea name="collecting_interests" id="collecting_interests" form="registration"
                                  placeholder="Other members may share the same interests..."></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><em>To foster communications among our members
                        we maintain an online directory.<br>No personal information will be
                        published or shared without your
                        permission.</em></td>
                </tr>
                <tr>
                    <td><label>Directory listing option (select)</label></td>
                    <td>
                        <select name="listing_option" id="listing_option">
                            <option value="">List with no restrictions</option>
                            <option value="NSA">List me without street address</option>
                            <option value="NSAT">List me without street address or telephone</option>
                            <option value="N">Do not list me in the directory</option>
                        </select>
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td><label>Referred By:</label></td>
                    <td><input name="referred_by" id="referred_by" size="20" type="text"></td>
                </tr>
                <tr style="border-top: 2px solid sienna; background-color: wheat;">
                    <td colspan="2">
                        <p><strong><em>Username</em></strong>
                            and <strong><em>password</em></strong>
                            are optional, although you will need them if you have an <em><strong>eProsit</strong></em>
                            subscription, or if you want to be able to log in to other portions of
                            the Members Only area (e.g., to access the membership directory).</p>
                    </td>
                </tr>
                <tr style="background-color: wheat;">
                    <td><label>Member\'s Username:</label></td>
                    <td><input name="username" id="username" size="20" type="text"></td>
                </tr>
                <tr style="background-color: wheat;">
                    <td><label>Member\'s Password:</label></td>
                    <td><input name="password" id="password" size="20" type="text"></td>
                </tr>
                <tr
                        style="border-bottom: 2px solid sienna; background-color: wheat; height: 10px;">
                    <td><br>
                    </td>
                    <td><br>
                    </td>
                </tr>
                <tr style="background-color: wheat;">
                    <td colspan="2"><strong><em>If
                        this is a gift or you are
                        making
                        payment on behalf of someone else,</em></strong> please give us your name and
                        email address so we can properly associate your PayPal payment with this subscription. We will
                        send you an email confirming your payment.
                    </td>
                </tr>
                <tr style="background-color: wheat;">
                    <td><label>Purchaser\'s name:</label></td>
                    <td><input name="purchaser_name" id="purchaser_name" type="text"></td>
                </tr>
                <tr style="background-color: wheat;">
                    <td><label>Purchaser\'s email:</label></td>
                    <td><input name="purchaser_email" id="purchaser_email"
                               placeholder="We will respect your privacy." type="text"></td>
                </tr>
                <tr
                        style="border-bottom: 2px solid sienna; background-color: wheat; height: 10px;">
                    <td><br>
                    </td>
                    <td><br>
                    </td>
                </tr>
                <tr>
                    <td
                            style="padding: 10px; font-weight: bold; color: blue; text-align: center;"
                            colspan="2">Registration
                        is not complete until you click this button --
                        <button type="submit" class="button" style="border: 2px solid blue;">Register</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </fieldset>
    </form>
</div>';
                    echo $htmlCodeReg;
                    return ob_get_clean();
                }
            } else {
                $htmlCodeReg = '';
                $htmlCodeReg .= '<div style="max-width: 800px; background-color: white; margin: 0 auto; border: solid 1px blue">
<p style="overflow: auto; color: blue">
<img style="width: 85px; height: 116px; float: left; margin: 10px;" src="https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg">
<br><br>Thanks for renewing! <a href="http://localhost/tsp/stein">Click here</a> to return to the SCI website.</p>

</div>';
                echo $htmlCodeReg;
                return ob_get_clean();
            }
        } else {
            echo $htmlCode;
            return ob_get_clean();
        }
    } else {
        echo $htmlCode;
        return ob_get_clean();
    }
}

function handle_convention_return_page()
{
    ob_start();
    $htmlCode = "<div style=\"margin: 0px auto; padding: 0px; max-width: 800px; width: 100%;\"><table>
<tbody>
<tr>
<td width=\"100\"><img class=\"alignnone size-full wp-image-1647\" src=\"https://demo.stein-collectors.org/wp-content/uploads/2024/11/SCI-logo-stein_85x116.jpg\" alt=\"\" width=\"85\" height=\"116\" /></td>
<td>There are issue with payment, You can email us on <a href=\"mailto:treasurer@stein-collectors.org\">treasurer@stein-collectors.org</a> 

<a href=\"http://stein-collectors.org/\">Click here </a>to return to the home page of SCI Convention Registration.</td>
</tr>
</tbody>
</table></div>";

    if (isset($_REQUEST['custom']) && !empty($_REQUEST['custom'])) {
        $custom_data = json_decode(base64_decode(sanitize_text_field($_REQUEST['custom'])), true);

        if ($custom_data) {
            $member_name = $custom_data['member_name'];
            $member_email = $custom_data['member_email'];
            $amount_to_pay = $custom_data['amount_to_pay'];
            $convention_id = $custom_data['id'];

            $itemName = $_GET['item_name'];
            $amountPaid = $_GET['amt'];
            $memberNamePosition = strpos($itemName,":") + 1;
            $memberNameLength = strlen($itemName) - $memberNamePosition;
            $memberName = substr($itemName, $memberNamePosition, $memberNameLength);

            $memberEmail = 'webmaster@stein-collectors.org';
            if (isset ($_GET['custom'])) {
                $memberEmail = urldecode($_GET['custom']);
            }

            $emailContent = '
       <html>
       <head>
           <title>Convention Deposit Payment Confirmation</title>
   		<style>
   			table, th, td {
   				padding: 5px;
   			}
   		</style>
       </head>
   	<body>
           <h2>Convention deposit payment confirmation for: ' . $memberName . '</h2>
           <table cellspacing="6" style="border: 2px dashed white; width: 750px; border-collapse: collapse; padding: 10px;">
   ';


            $emailContent .= '<tr><td>' . $memberName . ' has made a convention payment of $' . $amountPaid . ' by PayPal.</td></tr>';
            $emailContent .=  '</table></body></html>';

            // for debugging    $emailContent .= $_SERVER['QUERY_STRING'];

            // generate email for convention registration team
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: Stein Collectors International<webmaster@stein-collectors.org>' . "\r\n";
            $headers .= 'Cc: webmaster@stein-collectors.org,crro26@gmail.com,sciconvenreg@comcast.net' . "\r\n";
            $to = $memberEmail;
            $subject = "SCI Convention Payment from " . $memberName;
            mail($to,$subject,$emailContent,$headers);

            $objDB = new dentalfocus_db_function();

            $df_social_table = 'trentium_con_payments';
            $arrayEditData = array(
                'txn_id' => "'" . $_REQUEST['txn_id'] . "'"
            );

            $resData = $objDB->dentalfocus_edit_records($df_social_table, $arrayEditData);
            if (!$resData) {
                $arrayInsertData = array(
                    'member_name' => $member_name,
                    'member_email' => $member_email,
                    'amount_to_pay' => $amount_to_pay,
                    'con_id' => $convention_id,
                    'paypal_payer_id' => $_REQUEST['PayerID'],
                    'paypal_st' => $_REQUEST['st'],
                    'paypal_tx' => $_REQUEST['tx'],
                    'paypal_cc' => $_REQUEST['cc'],
                    'paypal_amount' => $_REQUEST['amt'],
                    'payer_email' => $_REQUEST['payer_email'],
                    'payer_id' => $_REQUEST['payer_id'],
                    'payer_status' => $_REQUEST['payer_status'],
                    'first_name' => $_REQUEST['first_name'],
                    'last_name' => $_REQUEST['last_name'],
                    'address_name' => $_REQUEST['address_name'],
                    'address_street' => $_REQUEST['address_street'],
                    'address_city' => $_REQUEST['address_city'],
                    'address_state' => $_REQUEST['address_state'],
                    'address_country_code' => $_REQUEST['address_country_code'],
                    'address_zip' => $_REQUEST['address_zip'],
                    'residence_country' => $_REQUEST['residence_country'],
                    'txn_id' => $_REQUEST['txn_id'],
                    'mc_currency' => $_REQUEST['mc_currency'],
                    'mc_fee' => $_REQUEST['mc_fee'],
                    'mc_gross' => $_REQUEST['mc_gross'],
                    'protection_eligibility' => $_REQUEST['protection_eligibility'],
                    'payment_fee' => $_REQUEST['payment_fee'],
                    'payment_gross' => $_REQUEST['payment_gross'],
                    'payment_status' => $_REQUEST['payment_status'],
                    'payment_type' => $_REQUEST['payment_type'],
                    'handling_amount' => $_REQUEST['handling_amount'],
                    'shipping' => $_REQUEST['shipping'],
                    'item_name' => $_REQUEST['item_name'],
                    'quantity' => $_REQUEST['quantity'],
                    'txn_type' => $_REQUEST['txn_type'],
                    'payment_date' => $_REQUEST['payment_date'],
                    'receiver_id' => $_REQUEST['receiver_id'],
                    'notify_version' => $_REQUEST['notify_version'],
                    'verify_sign' => $_REQUEST['verify_sign'],
                );
                $recordID = $objDB->dentalfocus_insert_records($df_social_table, $arrayInsertData, true);

                if (!$recordID) {
                    wp_redirect('https://demo.stein-collectors.org/convention-payment-received/');
                    exit;
                }
                else{
                    echo $htmlCode;
                    return ob_get_clean();
                }
            }
            else {
                echo $htmlCode;
                return ob_get_clean();
            }
        } else {
            echo $htmlCode;
            return ob_get_clean();
        }
    } else {
        echo $htmlCode;
        return ob_get_clean();
    }
}

function ts_membership_sortcode_scripts($hook)
{
    if (is_admin()) exit;
    wp_enqueue_script('ts-membership-sortcode', TRENTIUM_CONTACT_FORM_PLUGIN_PATH . 'scripts/ts-membership-sortcode.js', array('jquery'), TRENTIUM_PLUGIN_VERSION, true, true);
}

function ts_membership_form_handle_submission()
{
    if (isset($_REQUEST['submit_x']) && !empty($_REQUEST['submit_x'])) {
        $membership = NULL;
        if (isset($_REQUEST['membership']) && !empty($_REQUEST['membership'])) {
            $membership = sanitize_text_field($_REQUEST['membership']);
        }
        if (empty($membership)) {
            wp_redirect(add_query_arg('form_submitted', 'Please select membership option renew or new.', $_SERVER['REQUEST_URI']));
            exit;
        }

        $print_or_digital = NULL;
        if (isset($_REQUEST['print_or_digital']) && !empty($_REQUEST['print_or_digital'])) {
            $print_or_digital = sanitize_text_field($_REQUEST['print_or_digital']);
        }
        if (empty($print_or_digital)) {
            wp_redirect(add_query_arg('form_submitted', 'Please select print or digital option.', $_SERVER['REQUEST_URI']));
            exit;
        }

        $country = NULL;
        if (isset($_REQUEST['country']) && !empty($_REQUEST['country'])) {
            $country = sanitize_text_field($_REQUEST['country']);
        }
        if (empty($country)) {
            wp_redirect(add_query_arg('form_submitted', 'Please select country option.', $_SERVER['REQUEST_URI']));
            exit;
        }

        $term = NULL;
        if (isset($_REQUEST['term']) && !empty($_REQUEST['term'])) {
            $term = sanitize_text_field($_REQUEST['term']);
        }
        if (empty($term)) {
            wp_redirect(add_query_arg('form_submitted', 'Please select term option.', $_SERVER['REQUEST_URI']));
            exit;
        }

        $df_social_table = 'trentium_membership_settings';
        $objDB = new dentalfocus_db_function();
        $arrayEditData = array(
            'id' => intval($term)
        );
        $resData = $objDB->dentalfocus_edit_records($df_social_table, $arrayEditData);

        $amount = "0";    // precaution against not being able to identify the transaction details

        if ($country === "US") {
            if ($print_or_digital === "Prosit") {
                $amount = $resData['eprosit_print_usa'];
            }
        }

        if ($country === "C/M") {
            if ($print_or_digital === "Prosit") {
                $amount = $resData['eprosit_print_ca_mx'];
            }
        }

        if ($country === "Eur") {
            if ($print_or_digital === "Prosit") {
                $amount = $resData['eprosit_print_all'];
            }
        }

        if ($country === "US") {
            if ($print_or_digital === "eProsit") {
                $amount = $resData['eprosit_digital'];
            }
        }

        if ($country === "C/M") {
            if ($print_or_digital === "eProsit") {
                $amount = $resData['eprosit_digital'];
            }
        }

        if ($country === "Eur") {
            if ($print_or_digital === "eProsit") {
                $amount = $resData['eprosit_digital'];
            }
        }
        /*print '<pre>';
        print_r($resData);
        print_r($_REQUEST);
        print_r($amount);
        print '</pre>';
        exit;*/

        $cancel_url = home_url('/ts-paypal-cancel'); // Redirect to 'cancel' page
        $return_url = home_url('/ts-paypal-thankyou'); // Redirect to 'thank-you' page

        $itemName = $term . " " . $print_or_digital . " " . $membership;

        $custom_data = json_encode(array(
            'id' => intval($term),      // Example: Pass user ID
            'country' => $country,     // Example: Pass order ID
            'print_or_digital' => $print_or_digital,      // Example: Pass mode
            'membership' => $membership,      // Example: Pass mode
        ));
        // Redirect to avoid resubmission on refresh
        $paypal_url = add_query_arg(
            array(
                'cmd' => '_xclick',
                'charset' => 'utf-8',
                'business' => 'treasurer@stein-collectors.org', // Your PayPal business email
                'item_name' => $itemName,          // Item name
                'amount' => $amount,               // Payment amount
                'return' => $return_url,        // Return URL
                'cancel_return' => $cancel_url,     // Cancel URL
                'custom' => base64_encode($custom_data),
            ),
            'https://www.paypal.com/cgi-bin/webscr'
        );

        // Use wp_redirect to redirect to PayPal
        wp_redirect($paypal_url);
        exit;
    }
}

function ts_membership_sortcode($attrs)
{
    if (is_admin()) exit;
    ob_start();

    $df_social_table = 'trentium_membership_settings';
    $objDB = new dentalfocus_db_function();
    $resData = $objDB->dentalfocus_select_all_records($df_social_table);
    $htmlCode = '<style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        max-width: 800px;
                        margin: 20px auto;
                        font-size: 20px;
                        font-family: Arial, sans-serif;
                    }
                    th, td {
                        border: 1px solid #000;
                        text-align: center;
                        padding: 10px;
                    }
                    th {
                        background-color: #f4f4f4;
                        font-weight: bold;
                    }
                    .header {
                        border-bottom: 2px solid navy;
                    }
                    .green-text {
                        color: green;
                        font-weight: bold;
                    }
                </style>
                <table>
                    <thead>
                        <tr>
                            <th colspan="2" class="header">Digital Subscriptions</th>
                            <th colspan="3" class="header">Print Subscriptions</th>
                        </tr>
                        <tr>
                            <th>Term</th>
                            <th>eProsit <br>(digital only)</th>
                            <th>USA</th>
                            <th>Canada/ <br>Mexico</th>
                            <th>All other <br>worldwide</th>
                        </tr>
                    </thead>
                    <tbody>';
    if (isset($resData) && !empty($resData)) {
        foreach ($resData as $keyTerm => $valueTerm) {
            $class = "";
            if ($keyTerm == 1) {
                $class = "green-text";
            }
            $htmlCode .= '<tr>
                            <td class="' . $class . '">' . $valueTerm['memership_term'] . 'yr</td>
                            <td class="' . $class . '">$' . $valueTerm['eprosit_digital'] . '</td>
                            <td class="' . $class . '">$' . $valueTerm['eprosit_print_usa'] . '</td>
                            <td class="' . $class . '">$' . $valueTerm['eprosit_print_ca_mx'] . '</td>
                            <td class="' . $class . '">$' . $valueTerm['eprosit_print_all'] . '</td>
                        </tr>';
        }
    }

    $htmlCode .= '</tbody>
                </table>';

    $htmlCode .= '<p>Options to pay by PayPal are available below. <span style="font-style: italic;">Please consider making your payment by check so we can avoid PayPal fees.</span> A downloadable subscription form is available by clicking <a style="font-weight: bold;" href="https://demo.stein-collectors.org/wp-content/uploads/2024/11/pay-by-check_Rev20221002.pdf">HERE</a>.<br></p>';


    if (isset($_GET['form_submitted']) && $_GET['form_submitted'] === 'true') {
        $htmlCode .= '<p></p>';
    }

    $htmlCode .= '<form id="registration" action="" method="post" style="font-size: 1em;">
                    <fieldset style="border: 2px solid blue; margin: 0pt auto; padding: 5px; max-width: 800px; background-color: white;">
                        <legend style="font-size: 24px; color: blue; margin-left: 30px;">Sign me up!</legend>
                        <table style="margin: 0pt auto; width: 100%; max-width: 600px;">
                            <tbody>
                            <tr>
                                <td><label>For NEW subscriptions we will ask you for full enrollment data (address, contact info, etc.).</label> </td>
                                <td>
                                    <select name="membership" id="membership" style="min-width: 160px" required>
                                        <option value="">Select</option>
                                        <option value="New">New</option>
                                        <option value="Renew">Renew</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Is this a print subscription or eProsit (digital only)?</label> </td>
                                <td>
                                    <select name="print_or_digital" id="print_or_digital" style="min-width: 160px" required>
                                        <option value="">Select</option>
                                        <option value="Prosit">Print</option>
                                        <option value="eProsit">Digital</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Where do you live?</label> </td>
                                <td>
                                    <select name="country" id="country" style="min-width: 160px" required>
                                        <option value="">Select</option>
                                        <option value="US">US</option>
                                        <option value="C/M">Canada/Mexico</option>
                                        <option value="Eur">Other Worldwide</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Save with a three-year subscription</label> </td>
                                <td>
                                    <select name="term" id="term" style="min-width: 160px" required>
                                        <option value="">Select</option>';
    if (isset($resData) && !empty($resData)) {
        foreach ($resData as $keyTerm => $valueTerm) {
            $htmlCode .= '<option value="' . $valueTerm['id'] . '">' . $valueTerm['memership_term'] . ' year</option>';
        }
    }

    $htmlCode .= '</select>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right; font-weight: bold;">Credit card payments by PayPal are easy and secure.<br>Clicking the Pay Now button will whisk you away...</td>
                                <td><input alt="PayPal - The safer, easier way to pay online!" name="submit" src="' . DENTALFOCUS_IMAGES . 'PayPalPayNowButton.jpg" type="image"></td>
                            </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </form>
';
    echo $htmlCode;
    return ob_get_clean();

    /*$content = $htmlCode;
    return $content; // Return the content.*/
}