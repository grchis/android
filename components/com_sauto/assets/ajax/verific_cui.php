<?php
define( '_JEXEC', 1);
define( 'DS', DIRECTORY_SEPARATOR );
define( 'JPATH_BASE', realpath(dirname(__FILE__) .'/../../../..' ) );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$user =JFactory::getUser();
$session =& JFactory::getSession();
$db = JFactory::getDBO();	

$lang =& JFactory::getLanguage();
$lang->load('com_sauto',JPATH_ROOT);

if (isset($_POST['cod_fiscal'])) {
	$cf = trim(stripslashes($_POST['cod_fiscal']));          // Preia datele primite
    //$content .= 'Textul "<i>'.$region.'"</i> contine '. strlen($region). ' caractere si '. str_word_count($region, 0). ' cuvinte.';
    //get region id
    $query = "SELECT count(*) FROM #__sa_profiles WHERE `cod_fiscal` = '".$cf."'";
    $db->setQuery($query);
    $total = $db->loadResult();
	if ($cf == '') {
		//baga un cod fiscal....
		$content = '<span class="sa_cf_exist">'.JText::_('SAUTO_CF_NON_VALUE').'</span>';
	} else {
		if ($total != 0) {
			//$content = '<span class="sa_cf_ok">'.JText::_('SAUTO_CF_NOU').'</span>';
			//} else {
			//obtin email
			$query = "SELECT `u`.`email` FROM #__sa_profiles as `p` JOIN #__users as `u` ON `p`.`cod_fiscal` = '".$cf."' AND `p`.`uid` = `u`.`id` AND `p`.`f_principal` = '1'";
			$db->setQuery($query);
			$owner_email = $db->loadResult();
			$content = '<span class="sa_cf_exist">'.JText::_('SAUTO_CF_EXISTENT').'</span>';
			$content .= '<div>'.JText::_('SA_ESTE_FILIALA').' <input type="checkbox" name="filiala" value="1" /></div>';
			$content .= '<div class="sauto_form_important">'.JText::sprintf('SAUTO_FORM_REG_FILIALA', $owner_email).'</div>';
			//$content .= '<br />';
			//$content .= '<div class="sauto_form_important">'.JText::_('SAUTO_FORM_REG_FILIALA_ONLY_ADDRESS').'</div>';
		}
	}
	//$content .= '<span class="sa_cf_exist"> >>> '.$total.'</span>';
    //$content .= '<select name="localitate" class="sa_select">';
    //$content .= '<option value="">'.JText::_('SAUTO_FORM_SELECT_CITY').'</option>';
    //$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$region_id."'  AND `published` = '1' ORDER BY `localitate` ASC";
    //$db->setQuery($query);
    //$city = $db->loadObjectList();
   // foreach ($city as $c) {
	//	$content .= '<option value="'.$c->id.'">'.$c->localitate.'</option>';
	//}
    //$content .= '</select>';
    
}

print $content;
?>