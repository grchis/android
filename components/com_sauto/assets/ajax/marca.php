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
	$marca = trim(stripslashes($_POST['id']));          // Preia datele primite
    //$content .= 'Textul "<i>'.$region.'"</i> contine '. strlen($region). ' caractere si '. str_word_count($region, 0). ' cuvinte.';
    //get region id
    $query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
    $db->setQuery($query);
    $mid = $db->loadResult();
    $content .= '<select name="model_auto" class="sa_select">';
    $content .= '<option value="">'.JText::_('SAUTO_ALEGE_MODELUL_DORIT').'</option>';
    $query = "SELECT * FROM #__sa_model_auto WHERE `mid` = '".$mid."' AND `published` = '1'";
    $db->setQuery($query);
    $model = $db->loadObjectList();
    foreach ($model as $m) {
		$content .= '<option value="'.$m->id.'">'.$m->model_auto.'</option>';
	}
    $content .= '</select>';
    $content .= '<div class="sauto_form_label">';
    $content .= '<a onClick="toggle_visibility(\'add_model\');" class="sauto_ajax_link">'.JText::_('SAUTO_ADD_MODEL_NOU').'</a>';
    $content .= '</div>';
    $content .= '<div id="add_model" style="display:none;">';
		$content .= '<input type="text" name="new_model" value="" class="sa_inputbox" />';
    $content .= '</div>';
    
}

print $content;
?>
