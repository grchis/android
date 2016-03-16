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
	$region = trim(stripslashes($_POST['id']));          // Preia datele primite
    //$content .= 'Textul "<i>'.$region.'"</i> contine '. strlen($region). ' caractere si '. str_word_count($region, 0). ' cuvinte.';
    //get region id
    $query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$region."'";
    $db->setQuery($query);
    $region_id = $db->loadResult();
    $content .= '<select name="localitate_r" class="sa_select">';
    $content .= '<option value="">'.JText::_('SAUTO_FORM_SELECT_CITY').'</option>';
    $query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$region_id."' AND `published` = '1' ORDER BY `localitate`";
    $db->setQuery($query);
    $city = $db->loadObjectList();
    foreach ($city as $c) {
		$content .= '<option value="'.$c->id.'">'.$c->localitate.'</option>';
	}
    $content .= '</select>';
    
}

print $content;
?>
