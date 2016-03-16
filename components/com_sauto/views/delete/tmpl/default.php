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

$db = JFactory::getDbo();
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');
$user =& JFactory::getUser();
$uid = $user->id;
	if ($uid == 0) {
		//vizitator
		$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
	} else {
		//verificare tip utilizator
		$query= "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$tip = $db->loadResult();
		if ($tip == 0) {
			//client
			//verific daca sunt proprietarul anuntului
			$query = "SELECT count(*) FROM #__sa_anunturi WHERE `id` = '".$id."' AND `proprietar` = '".$uid."'";
			$db->setQuery($query);
			$my_anunt = $db->loadResult();
			if ($my_anunt == 1) {
				//este anuntul meu
				//verificam iarasi daca avem oferte introduse
				$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$id."'";
				$db->setQuery($query);
				$answered = $db->loadResult();
				if ($answered == 0) {
					//nu avem oferte, putem sterge
					delete_anunt($id, $uid);
				} else {
					//sunt oferte facute, nu se mai poate sterge
					$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
				}
			} else {
				//nu e anuntul meu, redirectionam
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			}
		} elseif ($tip == 1) {
			//dealer
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} else {
			//nedefinit, redirectionam la prima pagina
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} 
	}

function delete_anunt($id, $uid) {
	$db = JFactory::getDbo();
	jimport('joomla.filesystem.file');
	$query = "SELECT * FROM #__sa_poze WHERE `id_anunt` = '".$id."'";
	$db->setQuery($query);
	$pics = $db->loadObjectList();
	$path = JPATH_ROOT.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$uid.DS;
	foreach ($pics as $p) {
		echo '>>>> '.$p->poza.'<br />';
		//delete fisier
		$path_delete = $path.$p->poza;
		JFile::delete($path_delete);
		//delete from db
		$query = "DELETE FROM #__sa_poze WHERE `id` = '".$p->id."'";
		$db->setQuery($query);
		$db->query();
	}
	//delete anunt 
	$query = "DELETE FROM #__sa_anunturi WHERE `id` = '".$id."'";
	$db->setQuery($query);
	$db->query();
	$app =& JFactory::getApplication();
	$link_ok = JRoute::_('index.php?option=com_sauto&view=my_request');
	$app->redirect($link_ok, JText::_('SAUTO_ANUNT_STERS_CU_SUCCES'));
}
?>
