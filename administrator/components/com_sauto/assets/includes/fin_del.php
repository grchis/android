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
$query = "DELETE FROM #__sa_facturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();
$query = "DELETE FROM #__sa_tranzactii WHERE `tranz_id` = '".$id."'";
$db->setQuery($query);
$db->query();
$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=financiar';
$app->redirect($redirect, 'Factura a fost eliminata cu succes');
