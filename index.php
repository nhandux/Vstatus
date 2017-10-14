<?php
@ob_start();
@session_start();
// System
define( 'TTH_SYSTEM', true );

$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$path = array();
$path = explode('/',$url);
if($path[0]=='en') {
	$_SESSION["language"] = 'en';
} elseif($path[0]=='vi') {
	$_SESSION["language"] = 'vi';
} else {
	$_SESSION["language"] = 'vi';
	array_unshift($path, 'vi');
}
//----------------------------------------------------------------------------------------------------------------------
require_once(str_replace( DIRECTORY_SEPARATOR, '/', dirname( __file__ ) ) . '/define.php');
//---
require_once(ROOT_DIR . DS ."lang" . DS . TTH_LANGUAGE . ".lang");
include_once(_F_FUNCTIONS . DS . "Function.php");
try {
	$db =  new ActiveRecord(TTH_DB_HOST, TTH_DB_USER, TTH_DB_PASS, TTH_DB_NAME);
}
catch(DatabaseConnException $e) {
	echo $e->getMessage();
}
$account["id"] = empty($_SESSION["user_id"]) ? 0 : $_SESSION["user_id"]+0;
include_once(_F_INCLUDES . DS . "_tth_constants.php");
include_once(_F_INCLUDES . DS . "_tth_url.php");
include_once(_F_INCLUDES . DS . "_tth_online_daily.php");
?>
<!DOCTYPE html>
<html lang="<?php echo TTH_LANGUAGE;?>">
<head>
<?php
include(_F_INCLUDES . DS . "_tth_head.php");
include(_F_INCLUDES . DS . "_tth_script.php");
?>
</head>
<body>
<div class="se-pre-con"></div>
<?php
$active = 0;
$active = getPage('popup', 'is_active') + 0;
if($active==1 && !isset($_SESSION['popup'])) {
	echo '<div class="hidden"><div id="startpopup" class="startpopup"><div class="popup">'. getPage('popup') .'</div></div></div>';
	echo '<script>$(document).ready(function () {
			$.fancybox("#startpopup");
		});</script>';
	$_SESSION['popup'] = 'OK';
}
echo getConstant('script_body');
?>
<!-- #wrapper -->
<div id="wrapper">
	<?php
	include(_F_INCLUDES . DS . "tth_header.php");
	if($slug_cat=='home') include(_F_INCLUDES . DS . "tth_slider.php");
	else include(_F_INCLUDES . DS . "tth_banner.php");
	?>
	<!-- .container -->
	<section class="container">
		<?php
		include(_F_MODULES . DS .  str_replace('-','_',$slug_cat) . ".php");
		?>
	</section>
	<!-- / .container -->
	<?php
	if($slug_cat=='home') include(_F_INCLUDES . DS . "tth_partners.php");
	include(_F_INCLUDES . DS . "tth_footer.php");
	include(_F_INCLUDES . DS . "tth_menu_sm.php");
	?>
</div>
<!-- / #wrapper -->
<a href="javascript:void(0)" title="Lên đầu trang" id="go-top"></a>
<div id="_loading"></div>
<?php
echo getConstant('script_bottom');
?>
</body>
</html>