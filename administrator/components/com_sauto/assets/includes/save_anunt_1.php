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
//obtin id anunt
$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$db = JFactory::getDbo();
$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$an_fabricatie =& JRequest::getVar( 'an_fabricatie', '', 'post', 'string' );
$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt1', '', 'post', 'string', JREQUEST_ALLOWHTML  );
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$serie_caroserie =& JRequest::getVar( 'serie_caroserie', '', 'post', 'string' );
$nr_usi =& JRequest::getVar( 'nr_usi', '', 'post', 'string' );
$stare =& JRequest::getVar( 'stare', '', 'post', 'string' );

//obtin proprietar
$query = "SELECT `proprietar` FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$proprietar = $db->loadResult();

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
	$upd_marca = '';
} else {
	//obtin id marca
	$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
	$db->setQuery($query);
	$marca = $db->loadResult();
	$upd_marca = ", `marca_auto` = '".$marca."' ";
}
if ($model_auto == '') {
	$upd_model = '';
} else {
	$upd_model = " , `model_auto` = '".$model_auto."'";
}

//actualizam anuntul
$query = "UPDATE #__sa_anunturi SET ".$upd_titlu_anunt." ".$upd_anunt." ".$upd_cilindree." ".$upd_serie_caroserie."  `nr_usi` = '".$nr_usi."', `stare` = '".$stare."', `an_fabricatie` = '".$an_fabricatie."', `carburant` = '".$carburant."', `caroserie` = '".$caroserie."', `serie_caroserie` = '".$serie_caroserie."' ".$upd_marca." ".$upd_model." WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();

//preluam pozele
jimport('joomla.filesystem.file');
$path = JPATH_ROOT.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'users'.DS.$proprietar.DS;
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
		//echo $path_delete.'<br />';
		//delete from db
		$query = "DELETE FROM #__sa_poze WHERE `id` = '".$p->id."'";
		$db->setQuery($query);
		$db->query();
	}
}

$app =& JFactory::getApplication();
$link_redirect = 'index.php?option=com_sauto&task=anunturi';
$app->redirect($link_redirect, 'Anuntul a fost editat cu succes');

?>

