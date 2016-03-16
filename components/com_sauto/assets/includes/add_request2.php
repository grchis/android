<?php

defined('_JEXEC') || die('=;)');
$document = JFactory::getDocument();
$app = JFactory::getApplication();

require("javascript.php");
require("toggle_js.php");
$document->addScriptDeclaration ($js_code);


$req_val = $app->getUserState('request');
if ($req_val == '') {
	$request = JRequest::getVar( 'request', '', 'post', 'string' );
} else {
	$request = $req_val;
}
if ($request == 1) {
	$document->addScriptDeclaration ($js_code1);
	require_once("components/com_sauto/assets/includes/request1.php");
} elseif ($request == 2) {
	$document->addScriptDeclaration ($js_code2);
	$document->addScriptDeclaration ($js_code3);
	require_once("components/com_sauto/assets/includes/request2.php");
} elseif ($request == 3) {
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code2);
	require_once("components/com_sauto/assets/includes/request3.php");
} elseif ($request == 4) {
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code2);
	require_once("components/com_sauto/assets/includes/request4.php");
} elseif ($request == 5) {
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code2);
	$document->addScriptDeclaration ($js_code3);
	require_once("components/com_sauto/assets/includes/request5.php");
} elseif ($request == 6) {
	$document->addScriptDeclaration ($js_code1);
	require_once("components/com_sauto/assets/includes/request6.php");
} elseif ($request == 7) {
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code4);
	require_once("components/com_sauto/assets/includes/request7.php");
} elseif ($request == 8) {
	$document->addScriptDeclaration ($js_code1);
	$document->addScriptDeclaration ($js_code2);
	require_once("components/com_sauto/assets/includes/request8.php");
} elseif ($request == 9) {
	$document->addScriptDeclaration ($js_code1);
	require_once("components/com_sauto/assets/includes/request9.php");
} else {
	//redirectam,pagina gresita
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
}
?>

