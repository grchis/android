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
function form_comment($r_id, $multiple_id, $id, $proprietar, $firma) {
	?>
	<div class="sa_comments"><?php echo JText::_('SAUTO_COMMENT_LABEL'); ?>:</div>
	<div class="sa_comments"><textarea cols="100" rows="3" name="mesaj"></textarea></div>	
	<input type="hidden" name="anunt_id" value="<?php echo $id; ?>" />
	<input type="hidden" name="proprietar" value="<?php echo $proprietar; ?>" />
	<input type="hidden" name="firma" value="<?php echo $firma; ?>" />
	<div class="sauto_form_label">
	<?php echo JText::_('SAUTO_IMAGINE'); ?>
	</div>
	<div>
	<input type="file" name="image_1" value="" class="sa_inputbox" />
	</div>
	<?php 
	
}
