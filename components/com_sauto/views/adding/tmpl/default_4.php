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
$app->setUserState('marca', $marca);

$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$app->setUserState('model_auto', $model_auto);

$an_fabricatie =& JRequest::getVar( 'an_fabricatie', '', 'post', 'string' );
$app->setUserState('an_fabricatie', $an_fabricatie);
$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
//$app->setUserState('cilindree', $cilindree);
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
//$app->setUserState('carburant', $carburant);
$nr_usi =& JRequest::getVar( 'nr_usi', '', 'post', 'string' );
$app->setUserState('nr_usi', $nr_usi);
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$app->setUserState('caroserie', $caroserie);

$stare =& JRequest::getVar( 'stare', '', 'post', 'string' );
$app->setUserState('stare', $stare);
$anunt =& JRequest::getVar( 'anunt4', '', 'post', 'string', JREQUEST_ALLOWHTML );

$app->setUserState('anunt', $anunt);

$buget_min =& JRequest::getVar( 'buget_min', '', 'post', 'string' );
$buget_max =& JRequest::getVar( 'buget_max', '', 'post', 'string' );
$buget_moneda =& JRequest::getVar( 'buget_moneda', '', 'post', 'string' );
$app->setUserState('buget_min', $buget_min);
$app->setUserState('buget_max', $buget_max);
$app->setUserState('buget_moneda', $buget_moneda);

$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );

$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$id_judet = $db->loadResult();

$localitate =& JRequest::getVar( 'localitate', '', 'post', 'string' );



$user =& JFactory::getUser();
$uid = $user->id;

$register_anunt = 0;
//echo '>>>>> marca '.$marca.'  >>>> '.$new_marca.'  >>>>> '.$model_auto.'  >>>>> '.$new_model.'<br />';
$link_redirect = JRoute::_('index.php?option=com_sauto&view=add_request2');
	if ($marca == '') {
		$app->redirect($link_redirect, JText::_('SAUTO_NO_MARCA_ADDED'));
	} else {
		//marca existenta, obtinem id-ul
		$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
		$db->setQuery($query);
		$mid = $db->loadResult();
		$marca_auto_id = $mid;
		$app->setUserState('marca', $mid);
			if ($model_auto == '') {	
				//nu ati ales modelul) {
				$app->redirect($link_redirect, JText::_('SAUTO_NO_MODEL_ADDED'));
			} else {
				$model_auto_id = $model_auto;
				$app->setUserState('model_auto', $model_auto);
			}
}

//verificam campurile introduse
if ($titlu_anunt == '') {
	//nu avem introdus titlul
	//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
	$app->redirect($link_redirect, JText::_('SAUTO_NO_TITLE_ADDED'));
} else {
	if ($an_fabricatie == '') {
		//nu avem introdus anul fabricatiei
		//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
		$app->redirect($link_redirect, JText::_('SAUTO_NO_PRODUCTION_YEAR_ADDED'));
	} else {
		if ($nr_usi == '') {
			//nu sunt alese numarul de usi
			//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
			$app->redirect($link_redirect, JText::_('SAUTO_NO_NR_USI_ADDED'));
		} else {
			if ($caroserie == '') {
				//nu este aleasa caroseria
				//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
				$app->redirect($link_redirect, JText::_('SAUTO_NO_CARSERIE_ADDED'));
			} else {
				if ($stare == '') {
					//nu este adaugata starea
					//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
					$app->redirect($link_redirect, JText::_('SAUTO_NO_STARE_ADDED'));
				} else {
					if ($anunt == '') {
						//nu este adaugat anuntul
						//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
						$app->redirect($link_redirect, JText::_('SAUTO_NO_ANUNT_ADDED'));
					} else {
					//e ok
						if ($buget_min == '') {
							$buget_min = 0;
						}
					
						if ($buget_max == '') {
							$buget_max = 99999;
						}
						
					$register_anunt = 1;
					}
				}
			}
		}
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
	(`titlu_anunt`, `anunt`, `tip_anunt`, `judet`, `city`, `marca_auto`, `model_auto`, `an_fabricatie`, `cilindree`, `carburant`, `nr_usi`, `caroserie`, `stare`, `proprietar`, `data_adaugarii`, `status_anunt`, `raportat`, `data_expirarii`, `buget_min`, `buget_max`, `buget_moneda`) 
	VALUES 
	('".$titlu_anunt."', '".$anunt."', '4', '".$id_judet."', '".$localitate."', '".$marca_auto_id."', '".$model_auto_id."', '".$an_fabricatie."', '".$cilindree."', '".$carburant."', '".$nr_usi."', '".$caroserie."', '".$stare."', '".$uid."', '".$curentDate."', '1', '0', '".$expiryDate."', '".$buget_min."', '".$buget_max."', '".$buget_moneda."')";
	$db->setQuery($query);
	$db->query();
	$anunt_id = $db->insertid();
###########################prelucrare imagine#############
SautoViewAdding::uploadImg($time, $uid, $anunt_id);
SautoViewAdding::sendMail($anunt_id);
###########################end prelucrare imagine##################
	$app->setUserState('titlu_anunt', '');
	$app->setUserState('an_fabricatie', '');
	$app->setUserState('buget_min', '');
	$app->setUserState('buget_max', '');
	$app->setUserState('buget_moneda', '');
	$app->setUserState('marca', '');
	$app->setUserState('nr_usi', '');
	$app->setUserState('caroserie', '');
	$app->setUserState('stare', '');
	$app->setUserState('anunt', '');
	$app->setUserState('model_auto', '');
	$app->setUserState('request', '');
	$link_redirect_fr = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect_fr, JText::_('SAUTO_SUCCESS_ADDED'));
}
?>

