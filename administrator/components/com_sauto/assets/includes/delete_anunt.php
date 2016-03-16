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
//verificam daca snt poze auxiliare
$query = "SELECT count(*) FROM #__sa_poze WHERE `id_anunt` = '".$anunt_id."'";
$db->setQuery($query);
$total = $db->loadResult();
if ($total != 0) {
	jimport('joomla.filesystem.file');
	jimport('joomla.filesystem.folder');
	$base_path = JPATH_SITE.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS;
	$query = "SELECT * FROM #__sa_poze WHERE `id_anunt` = '".$anunt_id."'";
	$db->setQuery($query);
	$stergeri = $db->loadObjectList();
	foreach ($stergeri as $s) {
		//stergem avatarul existent
		$deletePath = $base_path.$s->owner.DS.$s->poza;
		JFile::delete($deletePath);
	}
	//stergem si din baza de date
	$query = "DELETE FROM #__sa_poze WHERE `id_anunt` = '".$anunt_id."'";
	$db->setQuery($query);
	$db->query();
}
//stergem si anuntul propriuzis
$query = "DELETE FROM #__sa_anunturi WHERE `id` = '".$anunt_id."'";
$db->setQuery($query);
$db->query();
	
//stergem si eventualele raportari
$query = "DELETE FROM #__sa_reported WHERE `anunt_id` = '".$anunt_id."'";
$db->setQuery($query);
$db->query();

//redirectionam
$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=anunturi';
$app->redirect($redirect, 'Anuntul a fost eliminat cu succes');
