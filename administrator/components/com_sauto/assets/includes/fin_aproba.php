<?php
/**
 * @package    sauto
 * @subpackage Base
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$time = time();
$db = JFactory::getDbo();
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
//obtin tipul tranzactiei
$query = "SELECT `tip_tranzactie`, `uid` FROM #__sa_tranzactii WHERE `tranz_id` = '".$id."'";
$db->setQuery($query);
$tip = $db->loadObject();


if ($tip->tip_tranzactie == 'abonament-op') {

	$query = "UPDATE #__sa_facturi SET `status_tr` = '1' WHERE `id` = '".$id."'";
	$db->setQuery($query);
	$db->query();

	$query = "UPDATE #__sa_tranzactii SET `aprobata` = '1', `new_upload` = '0' WHERE `tranz_id` = '".$id."'";
	$db->setQuery($query);
	$db->query();

	//setam ca abonat.....
	$query = "SELECT `pret`, `uid` FROM #__sa_facturi WHERE `id` = '".$id."'";
	$db->setQuery($query);
	$details = $db->loadObject();

	$query = "SELECT `id` FROM #__sa_abonament WHERE `pret` = '".$details->pret."'";
	$db->setQuery($query);
	$abonament = $db->loadResult();
	
	$query = "UPDATE #__sa_profiles SET `abonament` = '".$abonament."', `data_abonare` = '".$time."' WHERE `uid` = '".$details->uid."'";
	$db->setQuery($query);
	$db->query();
} elseif ($tip->tip_tranzactie == 'credite-op') {
	$query = "SELECT `credite` FROM #__sa_financiar_temp WHERE `tranz_id` = '".$id."'";
	$db->setQuery($query);
	$credit = $db->loadResult();
	//obtinem numarul de credite curent
	$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$tip->uid."'";
	$db->setQuery($query);
	$old_credit = $db->loadResult();
	//credite noi
	$new_credit = ($old_credit + $credit);
	//actualizam creditele
	$query = "UPDATE #__sa_financiar SET `credite` = '".$new_credit."' WHERE `uid` = '".$tip->uid."'";
	$db->setQuery($query);
	$db->query();
	//modificam statusul facturii
	$query = "UPDATE #__sa_facturi SET `status_tr` = '1', `pret` = '".$credite."', `moneda` = '1' WHERE `id` = '".$id."'";
	$db->setQuery($query);
	$db->query();
	//obtinem tipul tranzactiei si data
	$query = "SELECT `factura`, `data_tr` FROM #__sa_facturi WHERE `id` = '".$id."'";
	$db->setQuery($query);
	$dates = $db->loadObject();
	$tip_cump = 1;

	//adaugam la detalii financiare
	$query = "INSERT INTO #__sa_financiar_det (`uid`, `credite`, `cumparare`, `data_tranz`, `detalii_cumparare`) VALUES ('".$tip->uid."', '".$credit."', '".$tip_cump."', '".$dates->data_tr."', '".$id."')";
	$db->setQuery($query);
	$db->query();
	//eliminam din temporare
	$query = "DELETE FROM #__sa_financiar_temp WHERE `tranz_id` = '".$id."'";
	$db->setQuery($query);
	$db->query();
	$query = "UPDATE #__sa_tranzactii SET `aprobata` = '1', `new_upload` = '0' WHERE `tranz_id` = '".$id."'";
	$db->setQuery($query);
	$db->query();
}
$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=financiar';
$app->redirect($redirect, 'Plata a fost aprobata');	
