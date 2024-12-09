<?php
/*
	Create function to manage dentalfocus pages and functions.
*/
function dentalfocusmanager(){
    /*
        Check page is define or not in the request url
    */
    if(!isset($_REQUEST['page']) || empty($_REQUEST['page'])){
        die('Page not defined please try again');
    }

    $pageSlug = $_REQUEST['page'];

    switch ($pageSlug) {
        case "dentalfocus":
            include 'pages/dashboard.php';
            break;
        case "tssettings":
            ob_start();
            include 'pages/settings.php';
            break;
        default:
            include 'pages/dashboard.php';
    }
}
?>