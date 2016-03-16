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

$time = time();
$app =& JFactory::getApplication();
$request_v =& JRequest::getVar( 'request', '', 'post', 'string' );
$app->setUserState('request', $request_v);
$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$app->setUserState('titlu_anunt', $titlu_anunt);
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );

$new_marca =& JRequest::getVar( 'new_marca', '', 'post', 'string' );
	if ($new_marca == '') {
		$app->setUserState('new_marca', '');
	}
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$app->setUserState('model_auto', $model_auto);
$new_model =& JRequest::getVar( 'new_model', '', 'post', 'string' );
	if ($new_model == '') {
		$app->setUserState('new_model', '');
	}

$anunt =& JRequest::getVar( 'anunt5', '', 'post', 'string', JREQUEST_ALLOWHTML );
$app->setUserState('anunt', $anunt);

$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );
$judet_r =& JRequest::getVar( 'judet_r', '', 'post', 'string' );
$localitate_r =& JRequest::getVar( 'localitate_r', '', 'post', 'string' );
//obtin id judet
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet_r."'";
$db->setQuery($query);
$judet_r_id = $db->loadResult();



$user =& JFactory::getUser();
$uid = $user->id;

$register_anunt = 0;
$link_redirect_f = JRoute::_('index.php?option=com_sauto&view=add_request2');


if ($new_marca != '') {
	// avem marca noua,obligatoriu trebuie sa avem si model nou
	if ($new_model == '') {
		//model neintrodus, redirectionam spre pagina anterioara
		
		$app->redirect($link_redirect_f, JText::_('SAUTO_NO_MODEL_ADDED'));
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
		$marca_auto_id = $mid;
		$model_auto_id = $m_id;
		$marca_noua_id = $mid;
		$model_nou_id = $m_id;
		$app->setUserState('new_marca', $new_marca);
		$app->setUserState('new_model', $new_model);
	}
} else {
	if ($marca == '') {
		//nu am selectat marca
		$app->redirect($link_redirect_f, JText::_('SAUTO_NO_MARCA_ADDED'));
	} else {
		//marca existenta, obtinem id-ul
		$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
		$db->setQuery($query);
		$mid = $db->loadResult();
		$marca_auto_id = $mid;
		$app->setUserState('marca', $mid);
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
				$app->redirect($link_redirect_f, JText::_('SAUTO_NO_MODEL_ADDED'));
			} else {
				$model_auto_id = $model_auto;
				$app->setUserState('model_auto', $model_auto);
			}
		}
	}
}

if ($titlu_anunt == '') {
	//nu avem introdus titlul
	//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
	$app->redirect($link_redirect_f, JText::_('SAUTO_NO_TITLE_ADDED'));
} else {
	$register_anunt = 1;
}

if ($register_anunt == 1) {
	$curentDate = date('Y-m-d H:i:s', $time);
	$expiryDate = date('Y-m-d H:i:s', ($time+2592000));
	$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
	$db->setQuery($query);
	$id_judet = $db->loadResult();
	//adaug in baza de date
	$query = "INSERT INTO #__sa_anunturi 
	(`titlu_anunt`, `anunt`, `tip_anunt`, `marca_auto`, `model_auto`,  `proprietar`, `data_adaugarii`, `status_anunt`, `raportat`,  `data_expirarii`, `judet`, `city`, `judet_r`, `localitate_r`) 
	VALUES 
	('".$titlu_anunt."', '".$anunt."', '5', '".$marca_auto_id."', '".$model_auto_id."', '".$uid."', '".$curentDate."', '1', '0',  '".$expiryDate."', '".$id_judet."', '".$city."', '".$judet_r_id."', '".$localitate_r."')";
	$db->setQuery($query);
	$db->query();
	$anunt_id = $db->insertid();
	SautoViewAdding::sendMail($anunt_id);
	
	$app->setUserState('titlu_anunt', '');
	$app->setUserState('marca', '');
	$app->setUserState('anunt', '');
	$app->setUserState('model_auto', '');
	$app->setUserState('request', '');
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect, JText::_('SAUTO_SUCCESS_ADDED'));
}
