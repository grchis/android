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
$app =& JFactory::getApplication();
$db = JFactory::getDbo();

$link_redirect = JRoute::_('index.php?option=com_sauto&view=new_request');

$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$an_fabricatie =& JRequest::getVar( 'an_fabricatie', '', 'post', 'string' );
$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
$nr_usi =& JRequest::getVar( 'nr_usi', '', 'post', 'string' );
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$serie_caroserie =& JRequest::getVar( 'serie_caroserie', '', 'post', 'string' );
$stare =& JRequest::getVar( 'stare', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt4', '', 'post', 'string', JREQUEST_ALLOWHTML );
$time = time();
$curentDate = date('Y-m-d H:i:s', $time);
$expiryDate = date('Y-m-d H:i:s', ($time+2592000));	

$buget_min =& JRequest::getVar( 'buget_min', '', 'post', 'string' );
$buget_max =& JRequest::getVar( 'buget_max', '', 'post', 'string' );
$buget_moneda =& JRequest::getVar( 'buget_moneda', '', 'post', 'string' );

$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );

$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$id_judet = $db->loadResult();

$localitate =& JRequest::getVar( 'localitate', '', 'post', 'string' );

if ($marca == '') {
	//nu am selectat marca
	$app->redirect($link_redirect, JText::_('SAUTO_NO_MARCA_ADDED'));
} else {
	//marca existenta, obtinem id-ul
	$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
	$db->setQuery($query);
	$mid = $db->loadResult();
	$marca_auto_id = $mid;
	$app->setUserState('marca', $mid);
			//echo '<br />>>>>>'.$marca_auto_id.'<br />';

		if ($model_auto == '') {	
			//nu ati ales modelul) {
			$app->redirect($link_redirect, JText::_('SAUTO_NO_MODEL_ADDED'));
		} else {
			$model_auto_id = $model_auto;
			$app->setUserState('model_auto', $model_auto);
		}
}

//introducem in tabela temporara

$query = "INSERT INTO #__sa_temporar (`titlu_anunt`, `anunt`, `tip_anunt`, `marca_auto`, `model_auto`, `an_fabricatie`, `cilindree`, `carburant`, `nr_usi`, `caroserie`, `proprietar`, `data_adaugarii`, `status_anunt`, `raportat`, `data_expirarii`, `buget_min`, `buget_max`, `buget_moneda`, `judet`, `city`) VALUES ('".$titlu_anunt."', '".$anunt."', '4', '".$marca_auto_id."', '".$model_auto_id."', '".$an_fabricatie."', '".$cilindree."', '".$carburant."', '".$nr_usi."', '".$caroserie."',  '0', '".$curentDate."', '1', '0', '".$expiryDate."', '".$buget_min."', '".$buget_max."', '".$buget_moneda."', '".$id_judet."', '".$localitate."')";
$db->setQuery($query);
$db->query();
$anunt_id = $db->insertid();
//setez variabilele
$app->setUserState('anunt_id', $anunt_id);

