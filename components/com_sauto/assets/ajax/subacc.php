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

if (isset($_POST['id'])) {
	$accesoriu = trim(stripslashes($_POST['id']));          // Preia datele primite
    //$content .= 'Textul "<i>'.$region.'"</i> contine '. strlen($region). ' caractere si '. str_word_count($region, 0). ' cuvinte.';
    //get region id
    $query = "SELECT `id` FROM #__sa_accesorii WHERE `accesorii` = '".$accesoriu."'";
    $db->setQuery($query);
    $acc_id = $db->loadResult();
    $content .= '<select name="subacc" class="sa_select">';
    $content .= '<option value="">'.JText::_('SAUTO_ALEGE_SUBACCESORIUL').'</option>';
    $query = "SELECT * FROM #__sa_subaccesorii WHERE `acc_id` = '".$acc_id."' AND `published` = '1' ORDER BY `subaccesoriu` ASC";
    $db->setQuery($query);
    $subacc = $db->loadObjectList();
    foreach ($subacc as $s) {
		$content .= '<option value="'.$s->id.'">'.$s->subaccesoriu.'</option>';
	}
    $content .= '</select>';
    
}

print $content;
?>
