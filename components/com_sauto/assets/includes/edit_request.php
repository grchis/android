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

require("javascript.php");

$document = JFactory::getDocument();
//preiau id
$app =& JFactory::getApplication();
$id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
//verific daca id-ul anuntului este al proprietarului
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `id` = '".$id."'";
$db->setQuery($query);
$total = $db->loadResult();

$link_redirect = JRoute::_('index.php?option=com_sauto');
if ($total != 1) {
	//redirect
	$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
} else {
	//verificam tipul de anunt....
	$query = "SELECT `tip_anunt` FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `id` = '".$id."'";
	$db->setQuery($query);
	$type = $db->loadResult();
	$required = 'edit_request_'.$type.'.php';
	
	if ($type == 1) {
		$document->addScriptDeclaration ($js_code1);
	} elseif ($type == 2) {
		$document->addScriptDeclaration ($js_code2);
		$document->addScriptDeclaration ($js_code3);
	} elseif ($type == 3) {
		$document->addScriptDeclaration ($js_code1);
		$document->addScriptDeclaration ($js_code2);
	} elseif ($type == 4) {
		$document->addScriptDeclaration ($js_code1);
		$document->addScriptDeclaration ($js_code2);
	} elseif ($type == 5) {
		$document->addScriptDeclaration ($js_code1);
		$document->addScriptDeclaration ($js_code2);
		$document->addScriptDeclaration ($js_code3);
	} elseif ($type == 6) {
		$document->addScriptDeclaration ($js_code1);
	} elseif ($type == 7) {
		$document->addScriptDeclaration ($js_code1);
		$document->addScriptDeclaration ($js_code4);
	} elseif ($type == 8) {
		$document->addScriptDeclaration ($js_code1);
		$document->addScriptDeclaration ($js_code2);
	} elseif ($type == 9) {
		$document->addScriptDeclaration ($js_code1);
	}
	require($required);
}
?>
