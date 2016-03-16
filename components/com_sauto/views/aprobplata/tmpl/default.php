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
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');

$user =& JFactory::getUser();
$uid = $user->id;
	if ($uid == 0) {
		//vizitator
		$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
	} else {
		//verificare tip utilizator
		$query= "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$tip = $db->loadResult();
		if ($tip == 0) {
			//client
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} elseif ($tip == 1) {
			//dealer
			//bag codul.....
			$id =& JRequest::getVar( 'id', '', 'get', 'string' );
			//echo '>>> '.$id.'<br />';
			//obtin date temporare
			$query = "SELECT `credite` FROM #__sa_financiar_temp WHERE `tranz_id` = '".$id."'";
			$db->setQuery($query);
			$credit = $db->loadResult();
			//echo 'credite factura > '.$credit.'<br />';
			//obtinem numarul de credite curent
			$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$old_credit = $db->loadResult();
			//echo 'credite vechi > '.$old_credit.'<br />';
			//credite noi
			$new_credit = ($old_credit + $credit);
			//echo 'credit actualizat > '.$new_credit.'<br />';
			//actualizam creditele
			$query = "UPDATE #__sa_financiar SET `credite` = '".$new_credit."' WHERE `uid` = '".$uid."'";
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
			$tip_c = explode(" -", $dates->factura);
			if ($tip_c[0] == 'op') {
				$tip_cump = 1;
			} elseif ($tip_c[0] == 'cb') {
				$tip_cump = 2;
			} elseif ($tip_c[0] == 'pp') {
				$tip_cump = 3;
			}
			//adaugam la detalii financiare
			$query = "INSERT INTO #__sa_financiar_det (`uid`, `credite`, `cumparare`, `data_tranz`, `detalii_cumparare`) VALUES ('".$uid."', '".$credit."', '".$tip_cump."', '".$dates->data_tr."', '".$id."')";
			$db->setQuery($query);
			$db->query();
			//echo $query.'<br />';
			//eliminam din temporare
			$query = "DELETE FROM #__sa_financiar_temp WHERE `tranz_id` = '".$id."'";
			$db->setQuery($query);
			$db->query();
			//redirectionam spre lista de facturi
			$link_ok = JRoute::_('index.php?option=com_sauto&view=facturi');
			$app->redirect($link_ok, JText::_('Factura platita cu succes!'));
		} else {
			//nedefinit, redirectionam la prima pagina
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} 
	}
	?> 


