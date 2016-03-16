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
$suport =& JRequest::getVar( 'suport', '', 'post', 'string' , JREQUEST_ALLOWHTML  );
$db = JFactory::getDbo();
$query = "UPDATE #__sa_configurare SET `suport` = '".$suport."' WHERE `id` = '1'";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=suport';
$app->redirect($redirect, 'Pagina Suport a fost actualizata cu succes'); 
