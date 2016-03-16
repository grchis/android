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
$time = time();
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto&view=my_request');

$id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );
$new_marca =& JRequest::getVar( 'new_marca', '', 'post', 'string' );
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$new_model =& JRequest::getVar( 'new_model', '', 'post', 'string' );
$an_fabricatie =& JRequest::getVar( 'an_fabricatie', '', 'post', 'string' );
$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt9', '', 'post', 'string', JREQUEST_ALLOWHTML  );

if ($titlu_anunt == '') {
	$upd_titlu_anunt = '';
} else {
	$upd_titlu_anunt = " `titlu_anunt` = '".$titlu_anunt."', "; 
}
if ($anunt == '') {
	$upd_anunt = '';
} else {
	$upd_anunt = " `anunt` = '".$anunt."', ";
}
if ($cilindree == '') {
	$upd_cilindree = '';
} else {
	$upd_cilindree = " `cilindree` = '".$cilindree."', ";
}

if ($new_marca != '') {
	// avem marca noua,obligatoriu trebuie sa avem si model nou
	if ($new_model == '') {
		//model neintrodus, redirectionam spre pagina anterioara
		$marca_noua_id = "";
		$model_nou_id = "";
	} else {
		//avem si modelul, adaugam in baza de date
		$query = "INSERT INTO #__sa_marca_auto (`marca_auto`, `published`) VALUES ('".$new_marca."', '0')";
		$db->setQuery($query);
		$db->query();
		$mid = $db->insertid();
		$query = "INSERT INTO #__sa_model_auto (`mid`, `model_auto`, `published`) VALUES ('".$mid."', '".$new_model."', '0')";
		$db->setQuery($query);
		$db->query();
		$m_id = $db->insertid();
		$marca_noua_id = " , `marca_auto` = '".$mid."' ";
		$model_nou_id = " , `model_auto` = '".$m_id."' ";
	}
} else {
	if ($marca == '') {
		//nu am selectat marca
		$marca_noua_id = "";
		$model_nou_id = "";
	} else {
		//marca existenta, obtinem id-ul
		$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
		$db->setQuery($query);
		$mid = $db->loadResult();
		//$mark_auto_id = $mid;
		//echo '<br />>>>>>'.$marca_auto_id.'<br />';
		
		if ($new_model != '') {
			//avem model noua
			$query = "INSERT INTO #__sa_model_auto (`mid`, `model_auto`, `published`) VALUES ('".$mid."', '".$new_model."', '0')";
			$db->setQuery($query);
			$db->query();
			$m_id = $db->insertid();
			$marca_noua_id = " , `marca_auto` = '".$mid."' ";
			$model_nou_id = " , `model_auto` = '".$m_id."' ";		
		} else {
			if ($model_auto == '') {	
				//nu ati ales modelul) {
				$marca_noua_id = "";
				$model_nou_id = "";
			} else {
				$marca_noua_id = " , `marca_auto` = '".$mid."' ";
				$model_nou_id = " , `model_auto` = '".$model_auto."' ";
			}
		}
	}
} 

//actualizam anuntul
$query = "UPDATE #__sa_anunturi SET ".$upd_titlu_anunt."' ".$upd_anunt."  ".$upd_cilindree." `an_fabricatie` = '".$an_fabricatie."', `carburant` = '".$carburant."' ".$marca_noua_id." ".$model_nou_id." WHERE `proprietar` = '".$uid."' AND `id` = '".$id."'";
$db->setQuery($query);
$db->query();


//preluam pozele
jimport('joomla.filesystem.file');
$path = JPATH_ROOT.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$uid.DS;
$query = "SELECT * FROM #__sa_poze WHERE `id_anunt` = '".$id."'";
$db->setQuery($query);
$pics = $db->loadObjectList();
foreach ($pics as $p) {
	$delete_pic = 'delete_pic_'.$p->id;
	$delete_p =& JRequest::getVar( $delete_pic, '', 'post', 'string' );	
	if ($delete_p == 1) {
		//stergem poza
		$path_delete = $path.$p->poza;
		JFile::delete($path_delete);
		//delete from db
		$query = "DELETE FROM #__sa_poze WHERE `id` = '".$p->id."'";
		$db->setQuery($query);
		$db->query();
	}
}
//upload imagini existente
###########################prelucrare imagine#############
SautoViewEditing::uploadImg($time, $uid, $id);
###########################end prelucrare imagine##################	
//redirectionare
$app->redirect($link_redirect, JText::_('SAUTO_ANUNT_UPDATED_SUCCESSFULY'));
?>

