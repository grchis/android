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

$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$reclama =& JRequest::getVar( 'reclama', '', 'post', 'string' );
$pozitionare =& JRequest::getVar( 'pozitionare', '', 'post', 'string' );
$lista =& JRequest::getVar( 'lista', '', 'post', 'string' );
$maxim_afisari =& JRequest::getVar( 'maxim_afisari', '', 'post', 'string' );
$afisari_curente =& JRequest::getVar( 'afisari_curente', '', 'post', 'string' );
$published =& JRequest::getVar( 'published', '', 'post', 'string' );
$cod_reclama =& JRequest::getVar( 'cod_reclama', '', 'post', 'string', JREQUEST_ALLOWHTML );

$necontorizat =& JRequest::getVar( 'necontorizat', '', 'post', 'string' );

if ($necontorizat == 1) {
	$maxim_afisari = 100;
}

//echo '>>> '.$reclama.'<br />>>>>'.$pozitionare.'<br /> >>> '.$lista.'<br /> >>> '.$maxim_afisari.'<br /> >>>> '.$published.' <br /> >>>> '.$cod_reclama;
$db = JFactory::getDbo();
//$query = "INSERT INTO #__sa_reclame (`reclama`, `pozitionare`, `lista`, `maxim_afisari`, `afisari_curente`, `published`, `cod_reclama`) VALUES ('".$reclama."', '".$pozitionare."', '".$lista."', '".$maxim_afisari."', '0', '".$published."', '".$cod_reclama."')";
$query = "UPDATE #__sa_reclame SET `reclama` = '".$reclama."', `pozitionare` = '".$pozitionare."', `lista` = '".$lista."', `maxim_afisari` = '".$maxim_afisari."', `afisari_curente` = '".$afisari_curente."', `published` = '".$published."', `cod_reclama` = '".$cod_reclama."', `necontorizat` = '".$necontorizat."' WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=reclame';
$app->redirect($redirect, 'Reclama editata cu succes');
