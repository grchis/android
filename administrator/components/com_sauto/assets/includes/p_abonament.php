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
$abonament =& JRequest::getVar( 'abonament', '', 'post', 'string' );
$moneda =& JRequest::getVar( 'moneda', '', 'post', 'string' );
$pret =& JRequest::getVar( 'pret', '', 'post', 'string' );
//echo '>>>> '.$abonament.' >>> '.$pret.' >>>> '.$moneda;
$db = JFactory::getDbo();
$query = "UPDATE #__sa_abonament SET `abonament` = '".$abonament."', `pret` = '".$pret."', `moneda` = '".$moneda."' WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();
$app =& JFactory::getApplication();
$link_abonament = 'index.php?option=com_sauto&task=setari&action=abonament';
$app->redirect($link_abonament, 'Abonament editat cu succes');
