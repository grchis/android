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
$document = JFactory::getDocument();
$app =& JFactory::getApplication();

require("javascript.php");

$request =& JRequest::getVar( 'request', '', 'post', 'string' );
if ($request == '') {
	$link_redirect = JRoute::_('index.php?option=com_sauto&view=search_request');
	$app->redirect($link_redirect);
}

if ($request == 1) {
	$document->addScriptDeclaration ($js_code1);
	require_once("components/com_sauto/assets/includes/s_request1.php");
} elseif ($request == 2) {
	$document->addScriptDeclaration ($js_code2);
	require_once("components/com_sauto/assets/includes/s_request2.php");
} elseif ($request == 3) {
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code2);
	require_once("components/com_sauto/assets/includes/s_request3.php");
} elseif ($request == 4) {
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code2);
	require_once("components/com_sauto/assets/includes/s_request4.php");
} elseif ($request == 5) {
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code2);
	$document->addScriptDeclaration ($js_code3);
	require_once("components/com_sauto/assets/includes/s_request5.php");
} elseif ($request == 6) {
	$document->addScriptDeclaration ($js_code1);
	require_once("components/com_sauto/assets/includes/s_request6.php");
} elseif ($request == 7) {
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code4);
	require_once("components/com_sauto/assets/includes/s_request7.php");
} elseif ($request == 8) {
	$document->addScriptDeclaration ($js_code1);
	require_once("components/com_sauto/assets/includes/s_request8.php");
} elseif ($request == 9) {
	$document->addScriptDeclaration ($js_code1);
	require_once("components/com_sauto/assets/includes/s_request9.php");
} else {
	//redirectam,pagina gresita
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
}
?>

