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
$app =& JFactory::getApplication();
$request_v =& JRequest::getVar( 'request', '', 'post', 'string' );
$app->setUserState('request', $request_v);
$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$app->setUserState('titlu_anunt', $titlu_anunt);
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$app->setUserState('model_auto', $model_auto);
$an_fabricatie =& JRequest::getVar( 'an_fabricatie', '', 'post', 'string' );
$app->setUserState('an_fabricatie', $an_fabricatie);
$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
$app->setUserState('cilindree', $cilindree);
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
$app->setUserState('carburant', $carburant);
$nr_usi =& JRequest::getVar( 'nr_usi', '', 'post', 'string' );
$app->setUserState('nr_usi', $nr_usi);
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$app->setUserState('caroserie', $caroserie);
$serie_caroserie =& JRequest::getVar( 'serie_caroserie', '', 'post', 'string' );
$app->setUserState('serie_caroserie', $serie_caroserie);
$stare =& JRequest::getVar( 'stare', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt1', '', 'post', 'string', JREQUEST_ALLOWHTML );$transmisie =& JRequest::getVar( 'transmisie', '', 'post', 'string' );$app->setUserState('transmisie', $transmisie);
$nou =& JRequest::getVar( 'nou', '', 'post', 'string' );
$sh =& JRequest::getVar( 'sh', '', 'post', 'string' );
$app->setUserState('anunt', $anunt);
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
//$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
//$db->setQuery($query);
//$sconfig = $db->loadObject();
$register_anunt = 0;
//echo '>>>>> marca '.$marca.'  >>>> '.$new_marca.'  >>>>> '.$model_auto.'  >>>>> '.$new_model.'<br />';
$link_redirect_f = JRoute::_('index.php?option=com_sauto&view=add_request2');

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
		//echo '<br />>>>>>'.$marca_auto_id.'<br />';
			if ($model_auto == '') {	
				//nu ati ales modelul) {
				$app->redirect($link_redirect_f, JText::_('SAUTO_NO_MODEL_ADDED'));
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
	$app->redirect($link_redirect_f, JText::_('SAUTO_NO_TITLE_ADDED'));
} else {
	if ($an_fabricatie == '') {
		//nu avem introdus anul fabricatiei
		//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
		$app->redirect($link_redirect_f, JText::_('SAUTO_NO_PRODUCTION_YEAR_ADDED'));
	} else {
		if ($cilindree == '') {
			//cilindreea nu este introdusa
			//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
			###########################prelucrare imagine#############
			//SautoViewAdding::uploadImg($time, $uid, $anunt_id);
			//preluam imaginea
			$app->redirect($link_redirect_f, JText::_('SAUTO_NO_CAPACITY_ADDED'));
		} else {
			if ($carburant == '') {
				//carburantul nu este ales
				//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
				$app->redirect($link_redirect_f, JText::_('SAUTO_NO_CARBURANT_ADDED'));
			} else {
				if ($nr_usi == '') {
					//nu sunt alese numarul de usi
					//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
					$app->redirect($link_redirect_f, JText::_('SAUTO_NO_NR_USI_ADDED'));
				} else {
					if ($caroserie == '') {
						//nu este aleasa caroseria
						//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
						$app->redirect($link_redirect_f, JText::_('SAUTO_NO_CARSERIE_ADDED'));
					} else {
						if ($serie_caroserie == '') {
							//seria caroseriei nu este introdusa
							//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
							$app->redirect($link_redirect_f, JText::_('SAUTO_NO_SERIE_CARSERIE_ADDED'));
						} else {
							if ($anunt == '') {
								//nu este adaugat anuntul
								//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
								$app->redirect($link_redirect_f, JText::_('SAUTO_NO_ANUNT_ADDED'));
							} else {
								//e ok
								$register_anunt = 1;
							}
						}
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
		(`titlu_anunt`, `anunt`, `tip_anunt`, `marca_auto`, `model_auto`, `an_fabricatie`, `cilindree`, 		`carburant`, `nr_usi`, `caroserie`, `serie_caroserie`, `proprietar`, `data_adaugarii`, 		`status_anunt`, `raportat`, `data_expirarii`, `nou`, `sh`, `transmisie`) 
		VALUES 
		('".$titlu_anunt."', '".$anunt."', '1', '".$marca_auto_id."', '".$model_auto_id."', '".$an_fabricatie."', 		'".$cilindree."', '".$carburant."', '".$nr_usi."', '".$caroserie."', '".$serie_caroserie."', '".$uid."', 		'".$curentDate."', '1', '0', '".$expiryDate."', '".$nou."', '".$sh."', '".$transmisie."')";
	$db->setQuery($query);
	$db->query();
	$anunt_id = $db->insertid();
###########################prelucrare imagine#############
SautoViewAdding::uploadImg($time, $uid, $anunt_id);
SautoViewAdding::sendMail($anunt_id);
###########################end prelucrare imagine##################
	//parcam masina daca este cazul....
	$parcheaza =& JRequest::getVar( 'parcheaza', '', 'post', 'string' );
	if ($parcheaza == 1) {
	$query = "INSERT INTO #__sa_garaj 		(`owner`, `marca`, `model`, `an_fabricatie`, `cilindree`, `carburant`, `nr_usi`, `caroserie`, 		`serie_caroserie`, `transmisie`) 
		VALUES 		('".$uid."', '".$marca_auto_id."', '".$model_auto_id."', '".$an_fabricatie."', '".$cilindree."', 		'".$carburant."', '".$nr_usi."', '".$caroserie."', '".$serie_caroserie."', '".$transmisie."')";
	$db->setQuery($query);
	$db->query();
	}
	//end parcare masina
	
	//echo $query;
	$app->setUserState('titlu_anunt', '');
	$app->setUserState('an_fabricatie', '');
	$app->setUserState('cilindree', '');
	$app->setUserState('carburant', '');
	$app->setUserState('marca', '');
	$app->setUserState('nr_usi', '');
	$app->setUserState('caroserie', '');
	$app->setUserState('serie_caroserie', '');
	$app->setUserState('stare', '');
	$app->setUserState('anunt1', '');
	$app->setUserState('model_auto', '');
	$app->setUserState('request', '');
	$app->setUserState('anunt', '');	$app->setUserState('transmisie', '');
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect, JText::_('SAUTO_SUCCESS_ADDED'));
}
?>

