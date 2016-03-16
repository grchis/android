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
$tip =& JRequest::getVar( 'tip', '', 'post', 'string' );
$published =& JRequest::getVar( 'published', '', 'post', 'string' );

$db = JFactory::getDbo();
$query = "UPDATE #__sa_tip_anunt SET `tip` = '".$tip."', `published` = '".$published."' WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();
$app =& JFactory::getApplication();
$link_abonament = 'index.php?option=com_sauto&task=setari&action=anunt';
$app->redirect($link_abonament, 'Tipul anuntului a fost editat cu succes');
