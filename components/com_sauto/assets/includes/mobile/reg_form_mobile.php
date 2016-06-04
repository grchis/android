<?php
defined('_JEXEC') || die('=;)');
$document = JFactory::getDocument ();
$img_path = JURI::base()."components/com_sauto/assets/images/";

$document->addStyleSheet( 'components/com_sauto/assets/tabs.css' );
//$document->addScript('components/com_sauto/assets/script/contentdivider.js');
require("tab_js_mobile.php");
$document->addScriptDeclaration ($js_code_tab);
$jslink = JUri::base().'components/com_sauto/assets/script/domtab.js';
$document->addScript($jslink);
?>
<div class = "header" style="width: 100%; height: 100px; background-color: #509EFF">
	<a href=""><img src="./components/com_sauto/assets/images/menu_logo.png"/></a>
</div>
<div class="domtab">
  <ul class="domtabs domtabs2">
    <li>
		<a href="#t1">
			<img src="<?php echo $img_path; ?>reg_client_mic_alb.png" width="32" style="position:relative;top:7px;" />
			<span class="sa_reg_tab">
				<?php echo JText::_('SAUTO_TABS_CLIENT'); ?>
			</span>
		</a>
	</li>
    <li>
		<a href="#t2">
			<img src="<?php echo $img_path; ?>reg_firma_mic_alb.png" width="32" style="position:relative;top:7px;" />
			<span class="sa_reg_tab">
				<?php echo JText::_('SAUTO_TABS_DEALER'); ?>
			</span>
		</a>
	</li>
  </ul>
 
  <div>
    <h2 class="tabset_label"><a name="t2" id="t2"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a> 	</h2>
   <?php require("register_dealer_mobile.php"); ?>
  </div>
   <div>
    <h2 class="tabset_label"><a name="t1" id="t1"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a></h2>
   <?php require("register_customer_mobile.php"); ?>
  </div>
</div>

<script>
document.getElementsByTagName('h1')[0].remove();
</script>
<style type="text/css">
.header img {
  float: left;
}
</style>
