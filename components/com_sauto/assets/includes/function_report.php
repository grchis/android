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
function report_now($rezult_raport, $id, $uid) {
	$img_path = JURI::base()."components/com_sauto/assets/images/";
	if ($rezult_raport == 1) {
		?>
		<div class="sa_reported_div sa_hover" style="text-align:right;">
			<span class="sa_report">
				<?php echo JText::_('SAUTO_REPORTED_ANUNT'); ?>
			</span>
			<img src="<?php echo $img_path; ?>icon_report.png" width="18"/>
			</div>
		<?php
	} else {
		$link_report = JRoute::_('index.php?option=com_sauto&view=report');
		?>
		<form name="sa_report_form" id="sa_report_form" action="<?php echo $link_report; ?>" method="post">
			<input type="hidden" name="anunt_id" value="<?php echo $id; ?>" />
			<input type="hidden" name="uid" value="<?php echo $uid; ?>" /> 
			</form> 
			<div onClick="document.forms['sa_report_form'].submit();" class="sa_submit_form sa_hover">
			<span class="sa_report">
				<?php echo JText::_('SAUTO_REPORT_ANUNT'); ?>
			</span>
			<img src="<?php echo $img_path; ?>icon_report.png" width="18"/>
			</div>
		<?php
	}
}
