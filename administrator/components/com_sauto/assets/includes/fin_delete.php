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

//id factura
$id =& JRequest::getVar( 'id', '', 'get', 'string' );

$db = JFactory::getDbo();
//verificam daca avem fisier
$query = "SELECT `fisier` FROM #__sa_tranzactii WHERE `tranz_id` = '".$id."'";
$db->setQuery($query);
$file = $db->loadResult();

if ($file != '') {
	jimport('joomla.filesystem.file');
	jimport('joomla.filesystem.folder');
	//avem fisierul, trebuie sa-l stergem....
	$base_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'files'.DS;
	$deletePath = $base_path.$file;
	JFile::delete($deletePath);
}

//stergem alte inregistrari din baza de date
//stergere din #__sa_tranzactii
$query = "DELETE FROM #__sa_tranzactii WHERE `tranz_id` = '".$id."'";
$db->setQuery($query);
$db->query();

//stergere din #__sa_facturi
$query = "DELETE FROM #__sa_facturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();


//stergere din #__sa_financiar_temp
$query = "DELETE FROM #__sa_financiar_temp WHERE `tranz_id` = '".$id."'";
$db->setQuery($query);
$db->query();

//redirectionam.....
$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=financiar';
$app->redirect($redirect, 'Factura proforma a fopst eliminata cu succes!');




