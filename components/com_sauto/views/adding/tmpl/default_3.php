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


$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$app->setUserState('model_auto', $model_auto);


$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
$app->setUserState('cilindree', $cilindree);
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
$app->setUserState('carburant', $carburant);
$nr_usi =& JRequest::getVar( 'nr_usi', '', 'post', 'string' );
$app->setUserState('nr_usi', $nr_usi);
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$app->setUserState('caroserie', $caroserie);

$anunt3 =& JRequest::getVar( 'anunt3', '', 'post', 'string', JREQUEST_ALLOWHTML );
$app->setUserState('anunt', $anunt3);

$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );

$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$id_judet = $db->loadResult();

$localitate =& JRequest::getVar( 'localitate', '', 'post', 'string' );



$user =& JFactory::getUser();
$uid = $user->id;

$transmisie =& JRequest::getVar( 'transmisie', '', 'post', 'string' );

$register_anunt = 0;
$link_redirect = JRoute::_('index.php?option=com_sauto&view=add_request');

	//marca existenta, obtinem id-ul
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
	//echo '<br />>>>>>'.$model_auto_id.'<br />';


//verificam campurile introduse
if ($titlu_anunt == '') {
	//nu avem introdus titlul
	//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
	$app->redirect($link_redirect, JText::_('SAUTO_NO_TITLE_ADDED'));
} else {
	if ($nr_usi == '') {
		//nu sunt alese numarul de usi
		//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
		$app->redirect($link_redirect, JText::_('SAUTO_NO_NR_USI_ADDED'));
	} else {
		//if ($caroserie == '') {
			//nu este aleasa caroseria
			//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
			//$app->redirect($link_redirect, JText::_('SAUTO_NO_CARSERIE_ADDED'));
		//} else {
			if ($anunt3 == '') {
				//nu este adaugat anuntul
				//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
				$app->redirect($link_redirect, JText::_('SAUTO_NO_ANUNT_ADDED'));
			} else {
				//e ok
				$register_anunt = 1;
			}
		//}
	}				
}

		
//sfarsit verificare
if ($register_anunt == 1) {
	//obtin data curenta
	$curentDate = date('Y-m-d H:i:s', $time);
	$expiryDate = date('Y-m-d H:i:s', ($time+2592000));
	//echo '<br />caroserie>>>>'.$caroserie.'<br />';
	//adaug in baza de date
	$query = "INSERT INTO #__sa_anunturi 
	(`titlu_anunt`, `anunt`, `tip_anunt`, `judet`, `city`, `marca_auto`, `model_auto`,  `cilindree`, `carburant`, `nr_usi`, `caroserie`, `proprietar`, `data_adaugarii`, `status_anunt`, `raportat`, `data_expirarii`, `transmisie`) 
	VALUES 
	('".$titlu_anunt."', '".$anunt3."', '3', '".$id_judet."', '".$localitate."', '".$marca_auto_id."', '".$model_auto_id."', '".$cilindree."', '".$carburant."', '".$nr_usi."', '".$caroserie."', '".$uid."', '".$curentDate."', '1', '0', '".$expiryDate."', '".$transmisie."')";
	$db->setQuery($query);
	$db->query();
	$anunt_id = $db->insertid();
###########################prelucrare imagine#############
SautoViewAdding::uploadImg($time, $uid, $anunt_id);
SautoViewAdding::sendMail($anunt_id);
###########################end prelucrare imagine##################
	$app->setUserState('titlu_anunt', '');
	$app->setUserState('cilindree', '');
	$app->setUserState('carburant', '');
	$app->setUserState('marca', '');
	$app->setUserState('nr_usi', '');
	$app->setUserState('caroserie', '');

	$app->setUserState('anunt', '');
	$app->setUserState('model_auto', '');
	$app->setUserState('request', '');
	$link_redirect_fr = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect_fr, JText::_('SAUTO_SUCCESS_ADDED'));
}

?>

