<?php
$tabName = 'socialmedia';
if(isset($_REQUEST['tab']) && !empty($_REQUEST['tab'])){
    $tabName = $_REQUEST['tab'];
}
?><div id="wpbody" role="main">
    <div class="wrap">
        <div id="message2" class="updated notice below-h2">
            <h3>SCI Membership Settings</h3>
        </div>
        <!-- Content -->
        <div class="wp-filter">
            <ul class="filter-links">
                <li class="plugin-install-featured"><a href="admin.php?page=tssettings&tab=socialmedia" class="
				<?php if(!empty($tabName)){ if($tabName == "socialmedia"){ echo 'current'; } } ?>">Settings</a>
                </li>
                <li class="plugin-install-popular"><a href="admin.php?page=tssettings&tab=payment" class="
				<?php if(!empty($tabName)){ if($tabName == "payment"){ echo 'current'; } } ?>">Payments</a>
                </li>
                <li class="plugin-install-recommended"><a href="admin.php?page=tssettings&tab=members" class="
				<?php if(!empty($tabName)){ if($tabName == "members"){ echo 'current'; } } ?>">Members</a>
                </li>
                <li class="plugin-install-recommended"><a href="admin.php?page=tssettings&tab=convention" class="
				<?php if(!empty($tabName)){ if($tabName == "convention"){ echo 'current'; } } ?>">Convention Payment</a>
                </li>
                <!--<li class="plugin-install-favorites"><a href="admin.php?page=tssettings&tab=favorites" class="
				<?php /*if(!empty($tabName)){ if($tabName == "favorites"){ echo 'current'; } } */?>">Favourites</a>
                </li>-->
            </ul>
        </div><?php
        switch ($tabName) {
            case "socialmedia":
                include 'socialmedia.php';
                break;
            case "payment":
                include 'payment.php';
                break;
            case "convention":
                include 'convention.php';
                break;
            case "members":
                include 'members.php';
                break;
            default:
                include 'socialmedia.php';
        }
        ?></div>
</div>