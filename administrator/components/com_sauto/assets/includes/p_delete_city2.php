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

$id =& JRequest::getVar( 'id', '', 'get', 'string' );
$db = JFactory::getDbo();
$query = "DELETE FROM #__sa_localitati WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();

//redirect
$app =& JFactory::getApplication();
$link_city = 'index.php?option=com_sauto&task=setari&action=cities';
$app->redirect($link_city, 'Localitate eliminata cu succes');
