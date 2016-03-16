<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$anunt_id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$db = JFactory::getDbo();
$query = "UPDATE #__sa_anunturi SET `raportat` = '0' WHERE `id` = '".$anunt_id."'";
$db->setQuery($query);
$db->query();
$query = "UPDATE #__sa_reported SET `stare` = '1' WHERE `anunt_id` = '".$anunt_id."'";
$db->setQuery($query);
$db->query();
$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=anunt&id='.$anunt_id;
$app->redirect($redirect, 'Anuntului i-a fost anulata starea de "Anunt raportat"');
?>

