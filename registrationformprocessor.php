<?php

// ----- This php program collects the data entered on the convention registration form,
// ----- formats the field values for an email sent to the convention committee,
// ----- sets up a PayPal request and invokes PayPal.
// ----- Return from PayPal will go to ConventionPaymentConfirmation.

// ----- prevent direct execution
// Check if Referral URL exists
if (isset($_SERVER['HTTP_REFERER'])) {
  // Store Referral URL in a variable
  $refURL = $_SERVER['HTTP_REFERER'];
  // Display the Referral URL on web page
} else {
  $refURL = "No referer URL";
} 




// if memberName is not set, it is not a valid attempt to execute this routine
if (! isset($_POST["memberName"])) {
exit();
} 
if (empty($_POST["memberName"])) {
exit();
} 

// ----- How to test form processing
// ----- Place the form and the form processor in a directory named TESTING
// -----
$mode = "LIVE";
if (basename(__DIR__) == "TESTING") {
$mode = "TEST";
}

$memberName = $_POST["memberName"];

if ($memberName == "JCfUZQsq") {exit();}


$firstMember = $_POST["firstMember"];
$memberBadge = $_POST["memberBadge"];

if ($memberBadge == "JCfUZQsq") {exit();}



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
	exit();
}	
			
$minimumDeposit = $_POST["minimumDeposit"];
$amountToPay = $_POST["amountToPay"];

// build customized html for email sent to registrant and convention committee
// first section - the basics - name, address, etc.
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
<p style="font-size: small;">email generated by 2024RegistrationFormProcessor.php<br>' . $refURL . '</p>';

$htmlContent .= '</td></tr>';
$htmlContent .= '</table>';
$htmlContent .= '</div>';

$htmlContent .=  '</body></html>';




// activate the next two lines for testing to see the email format and content
// echo($htmlContent);
// exit();










// Set content-type header for sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$replyTo = "crro26@gmail.com";
$CC = "crro26@gmail.com,dsbruha@Frontier.com,webmaster@stein-collectors.org";
if ($mode == "TEST") {
    $CC = "webmaster@stein-collectors.org";
}

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
//mail($to,$subject,$htmlContent,$headers);

//build PayPal call

$paypal_business = 'treasurer@stein-collectors.org';
$cancel_url = 'http://stein-collectors.org/payment-cancelled.html';
$item_name = 'SCI Convention Deposit:' . $memberName; 

$querystring = '?';
$querystring .= "cmd=_xclick&";
$querystring .= "charset=utf-8&";
$querystring .= "business=".$paypal_business ."&";
$querystring .= "item_name=".urlencode($item_name)."&";
$querystring .= "amount=" . $amountToPay . "&";
$querystring .= "return=https://stein-collectors.org/ConventionPaymentConfirmation.php";

$querystring .= "?custom=".urlencode($memberEmail);

// Redirect to paypal (will cause GET request to PayPal)
header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
exit();

?>