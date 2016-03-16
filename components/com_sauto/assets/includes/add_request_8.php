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
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$serie_caroserie =& JRequest::getVar( 'serie_caroserie', '', 'post', 'string' );
$garaj =& JRequest::getVar( 'parcheaza', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt8', '', 'post', 'string', JREQUEST_ALLOWHTML );
$time = time();
$curentDate = date('Y-m-d H:i:s', $time);
$expiryDate = date('Y-m-d H:i:s', ($time+2592000));	
	
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
	if ($new_model != '') {
		//avem model noua
		$query = "INSERT INTO #__sa_model_auto (`mid`, `model_auto`, `published`) VALUES ('".$mid."', '".$new_model."', '0')";
		$db->setQuery($query);
		$db->query();
		$m_id = $db->insertid();
		$model_auto_id = $m_id;
		$model_nou_id = $m_id;	
		$app->setUserState('new_model', $new_model);	
	} else {
		if ($model_auto == '') {	
			//nu ati ales modelul) {
			$app->redirect($link_redirect, JText::_('SAUTO_NO_MODEL_ADDED'));
		} else {
			$model_auto_id = $model_auto;
			$app->setUserState('model_auto', $model_auto);
		}
	} 
}

//introducem in tabela temporara

$query = "INSERT INTO #__sa_temporar (`titlu_anunt`, `anunt`, `tip_anunt`, `marca_auto`, `model_auto`, `an_fabricatie`, `cilindree`, `carburant`, `caroserie`, `serie_caroserie`, `proprietar`, `data_adaugarii`, `status_anunt`, `raportat`, `data_expirarii`, `garaj`) VALUES ('".$titlu_anunt."', '".$anunt."', '8', '".$marca_auto_id."', '".$model_auto_id."', '".$an_fabricatie."', '".$cilindree."', '".$carburant."', '".$caroserie."', '".$serie_caroserie."', '0', '".$curentDate."', '1', '0', '".$expiryDate."', '".$garaj."')";
$db->setQuery($query);
$db->query();
$anunt_id = $db->insertid();
//setez variabilele
$app->setUserState('request', $request);
$app->setUserState('anunt_id', $anunt_id);

