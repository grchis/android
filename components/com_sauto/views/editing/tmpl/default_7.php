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
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt7', '', 'post', 'string', JREQUEST_ALLOWHTML  );
$acc =& JRequest::getVar( 'acc', '', 'post', 'string' );
$subacc =& JRequest::getVar( 'subacc', '', 'post', 'string' );

if ($titlu_anunt == '') {
	$upd_titlu_anunt = '';
} else {
	$upd_titlu_anunt = " `titlu_anunt` = '".$titlu_anunt."', "; 
}
if ($acc == '') {
	$upd_acc = '';
} else {
	$query = "SELECT `id` FROM #__sa_accesorii WHERE `accesorii` = '".$acc."'";
	$db->setQuery($query);
	$acc_id = $db->loadResult();
	$upd_acc = " `accesorii_auto` = '".$acc_id."', "; 
}
if ($subacc == '') {
	$upd_subacc = '';
} else {
	$upd_subacc = " `subaccesorii_auto` = '".$subacc."', "; 
}
if ($anunt == '') {
	$upd_anunt = '';
} else {
	$upd_anunt = " `anunt` = '".$anunt."', ";
}

if ($marca == '') {
		//nu am selectat marca
		$marca_noua_id = "";
		$model_nou_id = "";
} else {
	//marca existenta, obtinem id-ul
	$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
	$db->setQuery($query);
	$mid = $db->loadResult();
	if ($model_auto == '') {	
		//nu ati ales modelul) {
		$marca_noua_id = "";
		$model_nou_id = "";
	} else {
		$marca_noua_id = "  `marca_auto` = '".$mid."' ";
		$model_nou_id = " , `model_auto` = '".$model_auto."' ";
	}
}
 

//actualizam anuntul
$query = "UPDATE #__sa_anunturi SET ".$upd_titlu_anunt." ".$upd_subacc." ".$upd_acc." ".$upd_anunt." ".$marca_noua_id." ".$model_nou_id." WHERE `proprietar` = '".$uid."' AND `id` = '".$id."'";
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

 
