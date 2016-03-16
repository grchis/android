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
function loadImg($r_id, $multiple_id) {
	if ($multiple_id == 1) {
		$toggle1 = 'view_file_2_'.$r_id;
		$toggle2 = 'view_file_3_'.$r_id;
		$toggle3 = 'view_file_4_'.$r_id;
		$toggle4 = 'view_file_5_'.$r_id;
	} else {
		$toggle1 = 'view_file_2';
		$toggle2 = 'view_file_3';
		$toggle3 = 'view_file_4';
		$toggle4 = 'view_file_5';
	}
	echo '<a onClick="toggle_visibility(\''.$toggle1.'\');" class="sauto_ajax_link">';
	echo JText::_('SAUTO_INCARCA_ALTA_IMAGINE'); 
	echo '</a>';
	echo '<div id="'.$toggle1.'" style="display:none;">';
		echo '<div>';
			echo '<input type="file" name="image_2" value="" class="sa_inputbox" />';
		echo '</div>';
		
		echo '<a onClick="toggle_visibility(\''.$toggle2.'\');" class="sauto_ajax_link">';
		echo JText::_('SAUTO_INCARCA_ALTA_IMAGINE');
		echo '</a>';
		
		echo '<div id="'.$toggle2.'" style="display:none;">';
			echo '<div>';
				echo '<input type="file" name="image_3" value="" class="sa_inputbox" />';
			echo '</div>';
			
			echo '<a onClick="toggle_visibility(\''.$toggle3.'\');" class="sauto_ajax_link">';
			echo JText::_('SAUTO_INCARCA_ALTA_IMAGINE');
			echo '</a>';
			
			echo '<div id="'.$toggle3.'" style="display:none;">';
				echo '<div>';
					echo '<input type="file" name="image_4" value="" class="sa_inputbox" />';
				echo '</div>';
				
				echo '<a onClick="toggle_visibility(\''.$toggle4.'\');" class="sauto_ajax_link">';
				echo JText::_('SAUTO_INCARCA_ALTA_IMAGINE');
				echo '</a>';
				
				echo '<div id="'.$toggle4.'" style="display:none;">';
					echo '<div>';
						echo '<input type="file" name="image_5" value="" class="sa_inputbox" />';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

?>
