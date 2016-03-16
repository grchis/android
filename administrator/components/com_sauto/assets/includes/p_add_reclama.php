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

$reclama =& JRequest::getVar( 'reclama', '', 'post', 'string' );
$pozitionare =& JRequest::getVar( 'pozitionare', '', 'post', 'string' );
$lista =& JRequest::getVar( 'lista', '', 'post', 'string' );
$maxim_afisari =& JRequest::getVar( 'maxim_afisari', '', 'post', 'string' );
$published =& JRequest::getVar( 'published', '', 'post', 'string' );
$cod_reclama =& JRequest::getVar( 'cod_reclama', '', 'post', 'string', JREQUEST_ALLOWHTML );
$necontorizat =& JRequest::getVar( 'necontorizat', '', 'post', 'string' );

if ($necontorizat == 1) {
	$maxim_afisari = 100;
}
//echo '>>> '.$reclama.'<br />>>>>'.$pozitionare.'<br /> >>> '.$lista.'<br /> >>> '.$maxim_afisari.'<br /> >>>> '.$published.' <br /> >>>> '.$cod_reclama;
$db = JFactory::getDbo();
$query = "INSERT INTO #__sa_reclame (`reclama`, `pozitionare`, `lista`, `maxim_afisari`, `afisari_curente`, `published`, `cod_reclama`, `necontorizat`) VALUES ('".$reclama."', '".$pozitionare."', '".$lista."', '".$maxim_afisari."', '0', '".$published."', '".$cod_reclama."', '".$necontorizat."')";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=reclame';
$app->redirect($redirect, 'Reclama adaugata cu succes');
