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
$an_fabricatie =& JRequest::getVar( 'an_fabricatie', '', 'post', 'string' );
$app->setUserState('an_fabricatie', $an_fabricatie);
$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
$app->setUserState('cilindree', $cilindree);
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
$app->setUserState('carburant', $carburant);

$anunt =& JRequest::getVar( 'anunt9', '', 'post', 'string', JREQUEST_ALLOWHTML );
$app->setUserState('anunt', $anunt);

$price =& JRequest::getVar( 'price', '', 'post', 'string' );
$app->setUserState('price', $price);

$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;

$register_anunt = 0;
//echo '>>>>> marca '.$marca.'  >>>> '.$new_marca.'  >>>>> '.$model_auto.'  >>>>> '.$new_model.'<br />';
$link_redirect = JRoute::_('index.php?option=com_sauto&view=add_request');

if ($new_marca != '') {
	// avem marca noua,obligatoriu trebuie sa avem si model nou
	if ($new_model == '') {
		//model neintrodus, redirectionam spre pagina anterioara
		$app->redirect($link_redirect, JText::_('SAUTO_NO_MODEL_ADDED'));
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
	//echo '<br />>>>>>'.$model_auto_id.'<br />';
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
		if ($cilindree == '') {
			//cilindreea nu este introdusa
			//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
			$app->redirect($link_redirect, JText::_('SAUTO_NO_CAPACITY_ADDED'));
		} else {
			if ($carburant == '') {
				//carburantul nu este ales
				//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
				$app->redirect($link_redirect, JText::_('SAUTO_NO_CARBURANT_ADDED'));
			} else {
				if ($anunt == '') {
					//nu este adaugat anuntul
					//SautoViewAdding::deleteModels($marca_noua_id, $model_nou_id);
					$app->redirect($link_redirect, JText::_('SAUTO_NO_ANUNT_ADDED'));
				} else {
					//e ok
					$register_anunt = 1;
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
	(`titlu_anunt`, `anunt`, `tip_anunt`, `marca_auto`, `model_auto`, `an_fabricatie`, `cilindree`, `carburant`, `proprietar`, `data_adaugarii`, `status_anunt`, `raportat`, `pret`, `data_expirarii`) 
	VALUES 
	('".$titlu_anunt."', '".$anunt."', '9', '".$marca_auto_id."', '".$model_auto_id."', '".$an_fabricatie."', '".$cilindree."', '".$carburant."','".$uid."', '".$curentDate."', '1', '0', '".$price."', '".$expiryDate."')";
	$db->setQuery($query);
	$db->query();
	$anunt_id = $db->insertid();
###########################prelucrare imagine#############
SautoViewAdding::uploadImg($time, $uid, $anunt_id);
SautoViewAdding::sendMail($anunt_id);
###########################end prelucrare imagine##################	
	$app->setUserState('titlu_anunt', '');
	$app->setUserState('an_fabricatie', '');
	$app->setUserState('cilindree', '');
	$app->setUserState('carburant', '');
	$app->setUserState('marca', '');
	$app->setUserState('model_auto', '');
	$app->setUserState('request', '');
	$app->setUserState('anunt', '');
	$link_redirect_fr = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect_fr, JText::_('SAUTO_SUCCESS_ADDED'));
}
?>

