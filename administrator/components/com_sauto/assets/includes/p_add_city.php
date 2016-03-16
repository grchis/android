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

$city =& JRequest::getVar( 'city', '', 'post', 'string' );
$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$redirect =& JRequest::getVar( 'redirect', '', 'post', 'string' );

$db = JFactory::getDbo();
$query = "INSERT INTO #__sa_localitati (`jid`, `localitate`, `published`) VALUES ('".$judet."', '".$city."', '1')";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();

$app->redirect($redirect, 'Localitate adaugata cu succes');	
