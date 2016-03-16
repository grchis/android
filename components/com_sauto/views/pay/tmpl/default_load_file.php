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

$id_factura =& JRequest::getVar( 'id_factura', '', 'post', 'string' );


$time = time();
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$app =& JFactory::getApplication();

jimport('joomla.filesystem.file');
//jimport('joomla.filesystem.folder');
$image = JRequest::getVar('image', null, 'files','array');
//echo '>>>>> '.$image['name'];

$image['name'] = JFile::makeSafe($image['name']);


	//echo 'poza urcata: '.$image['name'].'<br />';
	$base_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'files'.DS;
	//echo 'calea de upload: '.$base_path.'<br />';
	if ($image['name'] != '') {
		$newName = 'plata-'.$uid.'-'.$time.'-'.$image['name'];
		$uploadPath = $base_path.$newName;
		JFile::upload($image['tmp_name'], $uploadPath);
	} else {
		$newName = '';
	}
	
	$query = "UPDATE #__sa_tranzactii SET `fisier` = '".$newName."', `new_upload` = '1' WHERE `tranz_id` = '".$id_factura."'";
	$db->setQuery($query);
	$db->query();
	$link_redirect = JRoute::_('index.php?option=com_sauto&view=facturi');
	//echo 'e bun';
	$app->redirect($link_redirect, JText::_('SAUTO_SUCCES_CONFIRM_PAY'));

	
	
	
