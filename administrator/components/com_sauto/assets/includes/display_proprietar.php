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

function view_proprietar($user_id) {
	$img_path = JURI::root()."components".DS."com_sauto".DS."assets".DS."images".DS;
	$img_path2 = JURI::root()."components".DS."com_sauto".DS."assets".DS."users".DS;
	echo '<table width="100%" class="sa_table_class">';
		echo '<tr class="sa_table_row"><td colspan="2" class="sa_table_cell">';
		$db = JFactory::getDbo();
		$query = "SELECT `u`.`name`, `u`.`registerDate`, `p`.`fullname`, `p`.`telefon`, `p`.`judet`, `p`.`localitate`, `p`.`poza` FROM #__users as `u` JOIN #__sa_profiles as `p` ON `u`.`id` = '".$user_id."' AND `u`.`id` = `p`.`uid`";
		$db->setQuery($query);
		$list = $db->loadObject();
		//print_r($list);
		$link_profile = JRoute::_('index.php?option=com_sauto&task=profil&id='.$user_id);
		echo '<a class="sa_profil" href="'.$link_profile.'">'.$list->name.'</a>';
		echo '</td></tr>';
		echo '<tr class="sa_table_row"><td valign="top" class="sa_table_cell">';
		//obtin judet
		$query = "SELECT `judet` FROM #__sa_judete WHERE `id` = '".$list->judet."'";
		$db->setQuery($query);
		$judet = $db->loadResult();
	
		if ($judet != '') {
			echo JText::_('SAUTO_DISPLAY_JUDET').': '.$judet.'<br />';
		}
		//obtin localitate
		$query = "SELECT `localitate` FROM #__sa_localitati WHERE `id` = '".$list->localitate."'";
		$db->setQuery($query);
		$city = $db->loadResult();
	
		if ($city != '') {
			echo JText::_('SAUTO_DISPLAY_CITY').': '.$city.'<br />';
		}
		//data inregistrarii
		$data_inr = explode(" ", $list->registerDate);
		echo JText::_('SAUTO_PROFILE_REGISTER_DATE').' '.$data_inr[0];
		echo '</td><td valign="top" class="sa_table_cell">';
		//avatar
		if ($list->poza == '') {
			//fara avatar personalizat
			echo '<img src="'.$img_path.'icon_profile.png" border="0" />';
		} else {
			//cu avatar personalizat
			echo '<img src="'.$img_path2.$user_id.'/'.$list->poza.'" width="70" border="0" />';
		}
		echo '</td></tr>';
		echo '<tr class="sa_table_row"><td colspan="2" class="sa_table_cell">';
		echo '<div class="sa_phone sa_min_width_phone">';
		echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />';
			echo '<span class="sa_phone_span">';
				echo $list->telefon;
			echo '</span>';
		echo '</div>';
		echo '</td></tr>';
	echo '</table>';
}
