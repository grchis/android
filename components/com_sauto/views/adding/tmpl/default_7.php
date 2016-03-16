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
//$anunt_id = 7;
//SautoViewAdding::sendMail($anunt_id);

$time = time();
$app = JFactory::getApplication();
$request_v = JRequest::getVar( 'request', '', 'post', 'string' );
$app->setUserState('request', $request_v);
$titlu_anunt = JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$app->setUserState('titlu_anunt', $titlu_anunt);
$acc = JRequest::getVar( 'acc', '', 'post', 'string' );
$app->setUserState('accesorii', $acc);
$subacc = JRequest::getVar( 'subacc', '', 'post', 'string' );
$app->setUserState('subaccesorii', $subacc);
$anunt = JRequest::getVar( 'anunt7', '', 'post', 'string', JREQUEST_ALLOWHTML );
$app->setUserState('anunt', $anunt);
$marca = JRequest::getVar( 'marca', '', 'post', 'string' );
$app->setUserState('marca', $marca);
$model_auto = JRequest::getVar( 'model_auto', '', 'post', 'string' );
$app->setUserState('model_auto', $model_auto);

$db = JFactory::getDbo();
$user = JFactory::getUser();
$uid = $user->id;

//$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
//$db->setQuery($query);
//$sconfig = $db->loadObject();

$register_anunt = 0;
//echo '>>>>> marca '.$marca.'  >>>> '.$new_marca.'  >>>>> '.$model_auto.'  >>>>> '.$new_model.'<br />';
$link_redirect_f = JRoute::_('index.php?option=com_sauto&view=add_request2');


//verificam campurile introduse
if ($titlu_anunt == '') {
	//nu avem introdus titlul
	$app->redirect($link_redirect_f, JText::_('SAUTO_NO_TITLE_ADDED'));
} else {
	if ($acc == '') {
		//nu avem introdus accesoriul
		$app->redirect($link_redirect_f, JText::_('SAUTO_NO_ACC_ADDED'));
	} else {
		if ($anunt == '') {
			//nu este adaugat anuntul
			$app->redirect($link_redirect_f, JText::_('SAUTO_NO_ANUNT_ADDED'));
		} else {
			//e ok
			$register_anunt = 1;
		}
	}
}

//sfarsit verificare
if ($register_anunt == 1) {
	if ($marca != '') {
		$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
		$db->setQuery($query);
		$mid = $db->loadResult();
	}
	//obtin data curenta
	$query = "SELECT `id` FROM #__sa_accesorii WHERE `accesorii` = '".$acc."'";
	$db->setQuery($query);
	$acc_id = $db->loadResult();
	
	$curentDate = date('Y-m-d H:i:s', $time);
	$expiryDate = date('Y-m-d H:i:s', ($time+2592000));
	//echo '<br />caroserie>>>>'.$caroserie.'<br />';
	//adaug in baza de date
	$query = "INSERT INTO #__sa_anunturi 
	(`titlu_anunt`, `anunt`, `tip_anunt`, `accesorii_auto`, `subaccesorii_auto`, `proprietar`, 
	`data_adaugarii`, `status_anunt`, `raportat`, `marca_auto`, `model_auto`) 
	VALUES 
	('".$titlu_anunt."', '".$anunt."', '7', '".$acc_id."', '".$subacc."', '".$uid."', '".$curentDate."', '1', '0', '".$mid."', '".$model_auto."')";
	$db->setQuery($query);
	$db->query();
	$anunt_id = $db->insertid();
###########################prelucrare imagine#############
SautoViewAdding::uploadImg($time, $uid, $anunt_id);
SautoViewAdding::sendMail($anunt_id);
###########################end prelucrare imagine##################

	
	//echo $query;
	$app->setUserState('titlu_anunt', '');
	$app->setUserState('accesorii', '');
	$app->setUserState('marca', '');
	$app->setUserState('model_auto', '');
	$app->setUserState('subaccesorii', '');
	$app->setUserState('anunt7', '');
	$app->setUserState('request', '');
	$app->setUserState('anunt', '');
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect, JText::_('SAUTO_SUCCESS_ADDED'));
}
?>

