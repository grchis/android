<?php
/**
 * @package    sauto
 * @subpackage Base
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$db = JFactory::getDbo();
$id =& JRequest::getVar( 'id', '', 'get', 'string' );

$query = "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$id."'";
$db->setQuery($query);
$tip = $db->loadResult();
if ($tip == '') {
	$app =& JFactory::getApplication();
	$link_redirect = 'index.php?option=com_sauto';
	$app->redirect($link_redirect, 'Pagina inexistenta');
} elseif ($tip == 0) {
	//client
	require("profil_client.php");
} elseif ($tip == 1) {
	//dealer
	require("profil_dealer.php");
}

