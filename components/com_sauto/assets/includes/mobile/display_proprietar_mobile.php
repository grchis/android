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

function view_proprietar($user_id, $tip, $id, $firma_id) {
	$img_path = JURI::base()."components/com_sauto/assets/images/";
	$img_path2 = JURI::base()."components/com_sauto/assets/users/";
	echo '<table width="100%" class="sa_table_class">';
		echo '<tr class="sa_table_row"><td colspan="2" class="sa_table_cell">';
		$db = JFactory::getDbo();
		$query = "SELECT `u`.`name`, `u`.`registerDate`, `p`.`fullname`, `p`.`telefon`, `p`.`judet`, `p`.`localitate`, 
				`p`.`poza`, `p`.`deleted` 
				FROM #__users as `u` 
				JOIN #__sa_profiles as `p` 
				ON `u`.`id` = '".$user_id."' 
				AND `u`.`id` = `p`.`uid`";
		$db->setQuery($query);
		$list = $db->loadObject();
		//print_r($list);
		$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$user_id);
			if ($list->deleted == 0) {
				echo '<a class="sa_public_profile" href="'.$link_profile.'">'.$list->name.'</a>';
			} else {
				echo JText::_('SAUTO_CONT_INACTIV');
			}
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
	if ($list->deleted == 0) {
		if ($list->poza == '') {
			//fara avatar personalizat
			echo '<img src="'.$img_path.'fi_avatar.png" width="100" border="0" />';
		} else {
			//cu avatar personalizat
			echo '<img src="'.$img_path2.$user_id.'/'.$list->poza.'" width="100" border="0" />';
		}
	} else {
		echo '<img src="'.$img_path.'fi_avatar.png" width="100" border="0" />';
	}
		echo '</td></tr>';
		echo '<tr class="sa_table_row"><td colspan="2" class="sa_table_cell">';
		echo '<div class="sa_phone sa_min_width_phone sa_hover">';
		echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />';
			echo '<span class="sa_phone_span">';
		if ($list->deleted == 0) {	
			if ($tip == 'dealer') {
				//verificam tipul de abonament
				$user =& JFactory::getUser();
				$uid = $user->id;
				$query = "SELECT `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
				$db->setQuery($query);
				$abonament = $db->loadResult();
				//echo $list->telefon;
				if ($abonament == 3) {
					echo $list->telefon;
				} else {
					//verificam daca anuntul este castigat de catre firma
					$query = "SELECT count(*) FROM #__sa_anunturi WHERE `id` = '".$id."' AND `uid_winner` = '".$firma_id."'";
					$db->setQuery($query);
					$total = $db->loadResult();	
					if ($total == 1) {
						//afisam pretul
						echo $list->telefon;
					} else {
					echo JText::_('SAUTO_TELEFON_ASCUNS');
					}
				}
			} elseif ($tip == 'vizitator') {
				echo JText::_('SAUTO_TELEFON_ASCUNS');
			} else {
				echo $list->telefon;
			}
		} else {
			echo JText::_('SAUTO_TELEFON_ASCUNS');
		}
			echo '</span>';
		echo '</div>';
		echo '</td></tr>';
	echo '</table>';
}
function getMobileDetails($user_id, $tip, $id, $firma_id){
			$db = JFactory::getDbo();
		$query = "SELECT `u`.`name`, `u`.`registerDate`, `p`.`fullname`, `p`.`telefon`, `p`.`judet`, `p`.`localitate`, 
				`p`.`poza`, `p`.`deleted` 
				FROM #__users as `u` 
				JOIN #__sa_profiles as `p` 
				ON `u`.`id` = '".$user_id."' 
				AND `u`.`id` = `p`.`uid`";
		$db->setQuery($query);
		$list = $db->loadObject();
		//print_r($list);
		$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$user_id);
			if ($list->deleted == 0) {
				echo '<p><span class="some-class"><a class="sa_public_profile" href="'.$link_profile.'"><span>'.$list->name.'</a><p> <br/>';
			} else {
				echo '<p><span class="some-class">'.JText::_('SAUTO_CONT_INACTIV').'</span></p>';
			}
		//obtin judet
		$query = "SELECT `judet` FROM #__sa_judete WHERE `id` = '".$list->judet."'";
		$db->setQuery($query);
		$judet = $db->loadResult();
	
		if ($judet != '') {
			echo '<p><span class="some-class">'.JText::_('SAUTO_DISPLAY_JUDET').': </span>'.$judet.'</p>';
		}
		//obtin localitate
		$query = "SELECT `localitate` FROM #__sa_localitati WHERE `id` = '".$list->localitate."'";
		$db->setQuery($query);
		$city = $db->loadResult();
	
		if ($city != '') {
			echo '<p><span class="some-class">'.JText::_('SAUTO_DISPLAY_CITY').':</span>'.$city.'</p>';
		}
		//data inregistrarii
		$data_inr = explode(" ", $list->registerDate);
		echo '<p><span class="some-class">'.JText::_('SAUTO_PROFILE_REGISTER_DATE').'</span>'.$data_inr[0].'</p>';

}