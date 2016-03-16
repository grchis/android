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

$db = JFactory::getDbo();
$query = "DELETE FROM #__sa_moneda WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=moneda';
$app->redirect($redirect, 'Moneda a fost eliminata cu succes');
