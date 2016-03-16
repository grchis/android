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

$data_preluare =& JRequest::getVar( 'data_preluare', '', 'post', 'string' );
$data_returnare =& JRequest::getVar( 'data_returnare', '', 'post', 'string' );
$judet_r =& JRequest::getVar( 'judet_r', '', 'post', 'string' );
$localitate_r =& JRequest::getVar( 'localitate_r', '', 'post', 'string' );


$time = time();
$app =& JFactory::getApplication();
$request_v =& JRequest::getVar( 'request', '', 'post', 'string' );
$app->setUserState('request', $request_v);

$db = JFactory::getDbo();

$user =& JFactory::getUser();
$uid = $user->id;

$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$app->setUserState('titlu_anunt', $titlu_anunt);

$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$new_city =& JRequest::getVar( 'new_city', '', 'post', 'string' );
$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );
$app->setUserState('new_city', $new_city);

//obtin id judet
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet_r."'";
$db->setQuery($query);
$judet_r_id = $db->loadResult();

$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$app->setUserState('caroserie', $caroserie);
$anunt2 =& JRequest::getVar( 'anunt2', '', 'post', 'string', JREQUEST_ALLOWHTML );
$app->setUserState('anunt', $anunt2);

$register_anunt = 0;
$avem_city = 0;


$link_redirect_f = JRoute::_('index.php?option=com_sauto&view=add_request2');

if ($titlu_anunt == '') {
	//titlu anunt neintrodus
	$app->redirect($link_redirect_f, JText::_('SAUTO_NO_TITLE_ADDED'));
} else {
	if ($judet == '') {
		//judetul nu este selectat
		$app->redirect($link_redirect_f, JText::_('SAUTO_NO_REGION_ADDED'));
	} else {
		//echo 'judet = > '.$judet.'<br />';
		//obtinem id judet
		$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
		$db->setQuery($query);
		$id_judet = $db->loadResult();
		$app->setUserState('id_judet', $id_judet);
		//echo 'id judet > '.$id_judet.'<br />';
		//verificam localitatea
		//avem localitate noua?
		if ($new_city != '') {
			//avem localitate noua
			//echo 'localitate noua: '.$new_city.'<br />';
			//adaugam in baza de date
			$query = "INSERT INTO #__sa_localitati (`jid`, `localitate`, `published`) VALUES ('".$id_judet."', '".$new_city."', '0')";
			$db->setQuery($query);
			$db->query();
			$localitate_id = $db->insertid();
			$avem_city = 1;
		} else {
			$avem_city = 0;
			if ($city != '') {
				//avem localitate existenta
				//echo 'localitate selectata: '.$city;
				$localitate_id = $city;
				$app->setUserState('city', $city);
			} else {
				//redirectionare
				$app->redirect($link_redirect_f, JText::_('SAUTO_NO_CITY_ADDED'));
			}
		}
		//continuam verificarile
		if ($avem_city == 0) {
			//SautoViewAdding::deleteCity($new_city);
		}
		
		//
		if ($caroserie == '') {
			//nu avem caroseria selectata
			$app->redirect($link_redirect_f, JText::_('SAUTO_NO_CARSERIE_ADDED'));
		} else {
			//avem caroseria
			//verificam daca am adaugat anuntul propriuzis
			if ($anunt2 == '') {
				//nu avem anuntul adaugat
				$app->redirect($link_redirect_f, JText::_('SAUTO_NO_ANUNT_ADDED'));
			} else {
				//avem si anuntul, totul este ok
				$register_anunt = 1;
			}
		}
	}
}

if ($register_anunt == 1) {
//procesam anuntul
	$curentDate = date('Y-m-d H:i:s', $time);
	$expiryDate = date('Y-m-d H:i:s', ($time+2592000));
	//echo '<br />caroserie>>>>'.$caroserie.'<br />';
	//adaug in baza de date
	$query = "INSERT INTO #__sa_anunturi 
	(`titlu_anunt`, `anunt`, `tip_anunt`, `judet`, `city`, `caroserie`, `proprietar`, `data_adaugarii`, `status_anunt`, `raportat`, `pret`, `data_expirarii`, `data_preluare`, `data_returnare`, `judet_r`, `localitate_r`) 
	VALUES 
	('".$titlu_anunt."', '".$anunt2."', '2', '".$id_judet."', '".$localitate_id."', '".$caroserie."', '".$uid."', '".$curentDate."', '1', '0', '".$price."', '".$expiryDate."', '".$data_preluare."', '".$data_returnare."', '".$judet_r_id."', '".$localitate_r."')";
	$db->setQuery($query);
	$db->query();
	$anunt_id = $db->insertid();
###########################prelucrare imagine#############
SautoViewAdding::uploadImg($time, $uid, $anunt_id);
SautoViewAdding::sendMail($anunt_id);
###########################end prelucrare imagine##################
	//echo $query;
	$app->setUserState('titlu_anunt', '');
	$app->setUserState('caroserie', '');
	$app->setUserState('city', '');
	$app->setUserState('anunt2', '');
	$app->setUserState('judet', '');
	$app->setUserState('request', '');
	$app->setUserState('anunt', '');
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect, JText::_('SAUTO_SUCCESS_ADDED'));
}
?>

