<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(strpos($useragent,'Mobile')){
require_once('/mobile/reg_form_mobile.php');
}else{
$document = JFactory::getDocument ();
$img_path = JURI::base()."components/com_sauto/assets/images/";

$document->addStyleSheet( 'components/com_sauto/assets/tabs.css' );
//$document->addScript('components/com_sauto/assets/script/contentdivider.js');
require("tab_js.php");
$document->addScriptDeclaration ($js_code_tab);
$jslink = JUri::base().'components/com_sauto/assets/script/domtab.js';
$document->addScript($jslink);
?>
<?php /*
<div style="min-height:1850px;">
<ul class="tabs">
	<li>
		<input type="radio" checked name="tabs" id="tab1">
		<label for="tab1">
			<img src="<?php echo $img_path; ?>reg_client_mic_alb.png" width="32" style="position:relative;top:7px;" />
			<?php echo JText::_('SAUTO_TABS_CLIENT'); ?>
		</label>
		<div id="tab-content1" class="tab-content animated fadeIn">
			<?php require('register_customer.php'); ?>
		</div>
	</li>
	<li>
		<input type="radio" name="tabs" id="tab2">
		<label for="tab2">
			<img src="<?php echo $img_path; ?>reg_firma_mic_alb.png" width="32" style="position:relative;top:7px;" />
			<?php echo JText::_('SAUTO_TABS_DEALER'); ?>
		</label>
		<div id="tab-content2" class="tab-content animated fadeIn">
			<?php require('register_dealer.php'); ?>
		</div>
	</li>
</ul>
</div>*/ ?>

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
   <?php require("register_dealer.php"); ?>
  </div>
   <div>
    <h2 class="tabset_label"><a name="t1" id="t1"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a></h2>
   <?php require("register_customer.php"); ?>
  </div>
</div>
<?php } ?>
