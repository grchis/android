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
$an_fabricatie =& JRequest::getVar( 'an_fabricatie', '', 'post', 'string' );
$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt4', '', 'post', 'string', JREQUEST_ALLOWHTML  );
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$serie_caroserie =& JRequest::getVar( 'serie_caroserie', '', 'post', 'string' );
$nr_usi =& JRequest::getVar( 'nr_usi', '', 'post', 'string' );


$buget_min =& JRequest::getVar( 'buget_min', '', 'post', 'string' );
$buget_max =& JRequest::getVar( 'buget_max', '', 'post', 'string' );
$buget_moneda =& JRequest::getVar( 'buget_moneda', '', 'post', 'string' );

$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );

$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$id_judet = $db->loadResult();

$localitate =& JRequest::getVar( 'localitate', '', 'post', 'string' );


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
if ($serie_caroserie == '') {
	$upd_serie_caroserie = '';
} else {
	$upd_serie_caroserie = " `serie_caroserie` = '".$serie_caroserie."', ";
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
				$marca_noua_id = " , `marca_auto` = '".$mid."' ";
				$model_nou_id = " , `model_auto` = '".$model_auto."' ";
			}

	}


//actualizam anuntul
$query = "UPDATE #__sa_anunturi SET ".$upd_titlu_anunt." ".$upd_anunt." ".$upd_cilindree." ".$upd_serie_caroserie." `nr_usi` = '".$nr_usi."', `judet` = '".$id_judet."', `city` = '".$localitate."', `an_fabricatie` = '".$an_fabricatie."', `carburant` = '".$carburant."', `buget_min` = '".$buget_min."', `buget_max` = '".$buget_max."', `buget_moneda` = '".$buget_moneda."', `caroserie` = '".$caroserie."', `serie_caroserie` = '".$serie_caroserie."' ".$marca_noua_id." ".$model_nou_id." WHERE `proprietar` = '".$uid."' AND `id` = '".$id."'";
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

 
