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
$user =& JFactory::getUser();
$uid = $user->id;

$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');
$anunt_id = $app->getUserState('anunt_id');
if ($anunt_id != '') {

//prelucram datele din db.....
$db = JFactory::getDbo();
//preiau anuntul nou adaugat
$query = "SELECT * FROM #__sa_temporar WHERE `id` = '".$anunt_id."'";
$db->setQuery($query);
$l = $db->loadObject();

//adaug anuntul nou la locul lui
$query = "INSERT INTO #__sa_anunturi (`titlu_anunt`, `anunt`, `tip_anunt`, `marca_auto`, `model_auto`, `an_fabricatie`, `cilindree`, `carburant`, `nr_usi`, `caroserie`, `serie_caroserie`, `stare`, `proprietar`, `data_adaugarii`, `data_expirarii`, `status_anunt`, `raportat`, `judet`, `city`, `start_city`, `stop_city`, `accesorii_auto`, `subaccesorii_auto`, `pret`, `uid_winner`, `pret_winner`, `moneda_winner`, `is_winner`, `oferte`, `nou`, `sh`, `transmisie`, `buget_min`, `buget_max`, `buget_moneda`, `data_preluare`, `data_returnare`, `judet_r`, `localitate_r`) VALUES ('".$l->titlu_anunt."', '".$l->anunt."', '".$l->tip_anunt."', '".$l->marca_auto."', '".$l->model_auto."', '".$l->an_fabricatie."', '".$l->cilindree."', '".$l->carburant."', '".$l->nr_usi."', '".$l->caroserie."', '".$l->serie_caroserie."', '".$l->stare."', '".$uid."', '".$l->data_adaugarii."', '".$l->data_expirarii."', '".$l->status_anunt."', '".$l->raportat."', '".$l->judet."', '".$l->localitate."', '".$l->start_city."', '".$l->stop_city."', '".$l->accesorii_auto."', '".$l->subaccesorii_auto."', '".$l->pret."', '".$l->uid_winner."', '".$l->pret_winner."', '".$l->moneda_winner."', '".$l->is_winner."', '".$l->oferte."', '".$l->nou."', '".$l->sh."', '".$l->transmisie."', '".$l->buget_min."', '".$l->buget_max."', '".$l->buget_moneda."', '".$l->data_preluare."', '".$l->data_returnare."', '".$l->judet_r."', '".$l->localitate_r."')";
$db->setQuery($query);
$db->query();

if ($l->garaj == 1) {
//adaugam masina in garaj
$query = "INSERT INTO #__sa_garaj (`owner`, `marca`, `model`, `an_fabricatie`, `cilindree`, `carburant`, `nr_usi`, `caroserie`, `serie_caroserie`, `transmisie`) 
	VALUES ('".$uid."', '".$l->marca_auto."', '".$l->model_auto."', '".$l->an_fabricatie."', '".$l->cilindree."', '".$l->carburant."', '".$l->nr_usi."', '".$l->caroserie."', '".$l->serie_caroserie."', '".$l->transmisie."')";
	$db->setQuery($query);
	$db->query();
}
//sterg din temporar....
$query = "DELETE FROM #__sa_temporar WHERE `id` = '".$anunt_id."'";
$db->setQuery($query);
$db->query();

$app->setUserState('request', '');
$app->setUserState('anunt_id', '');
$app->setUserState('titlu_anunt', '');
$app->setUserState('accesorii', '');
$app->setUserState('marca', '');
$app->setUserState('model_auto', '');
$app->setUserState('subaccesorii', '');
$app->setUserState('anunt7', '');
$app->setUserState('anunt', '');
$app->setUserState('an_fabricatie', '');
$app->setUserState('cilindree', '');
$app->setUserState('carburant', '');
$app->setUserState('nr_usi', '');
$app->setUserState('caroserie', '');
$app->setUserState('serie_caroserie', '');
$app->setUserState('stare', '');
$app->setUserState('anunt1', '');
$app->setUserState('city', '');
$app->setUserState('anunt2', '');
$app->setUserState('judet', '');
$app->setUserState('buget_min', '');
$app->setUserState('buget_max', '');
$app->setUserState('buget_moneda', '');	
$app->setUserState('anunt6', '');


$app->redirect($link_redirect, JText::_('SAUTO_ADDED_AND_PUBLISHED'));
} else {
$app->redirect($link_redirect);	
}
?>

