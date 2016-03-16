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
		//adaugam creditele
		$credite =& JRequest::getVar( 'credite', '', 'post', 'string' );
		$procesator =& JRequest::getVar( 'procesator', '', 'post', 'string' );
		
		//echo 'nr credite > '.$credite.' de la '.$procesator;
		//obtinem nr curent de credite
		#$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$uid."'";
		#$db->setQuery($query);
		#$old_credite = $db->loadResult();
		#$new_credit = $credite + $old_credite;
		//
		#$query = "UPDATE #__sa_financiar SET `credite` = '".$new_credit."' WHERE `uid` = '".$uid."'";
		#$db->setQuery($query);
		#$db->query();
		//obtin seria facturii
		$query = "SELECT * FROM #__sa_serii_facturi WHERE `id` = '1'";
		$db->setQuery($query);
		$serii = $db->loadObject();
		$nr_crt = $serii->nr_crt + 1;
		//adaugam factura
		if ($procesator == 1) {
			$fact = 'op - '.$serii->serie.' - '.$nr_crt;
		} elseif ($procesator == 2) {
			$fact = 'cb - '.$serii->serie.' - '.$nr_crt;
		} elseif ($procesator == 3) {
			$fact = 'pp - '.$serii->serie.' - '.$nr_crt;
		}
					$credit = 'credit';
		$query = "INSERT INTO #__sa_facturi (`uid`, `factura`, `status_tr`, `tip_plata`, `credite`, `pret`, `moneda`) VALUES ('".$uid."', '".$fact."', '0', '".$credit."', '".$credite."', '', '')";
		$db->setQuery($query);
		$db->query();
		$last_fact = $db->insertid();
		
		$query = "INSERT INTO #__sa_financiar_temp (`tranz_id`, `pret`, `moneda`, `credite`) VALUES ('".$last_fact."', '".$credite."', '1', '".$credite."')";
		$db->setQuery($query);
		$db->query();
		//incrementare nr curent
		$query = "UPDATE #__sa_serii_facturi SET `nr_crt` = '".$nr_crt."' WHERE `id` = '1'";
		$db->setQuery($query);
		$db->query();
		/*
		
		* */
		$link_ok = JRoute::_('index.php?option=com_sauto&view=edit_profile&type=fn');
		$app->redirect($link_ok, JText::_('SAUTO_CREDIT_INCARCAT_CU_SUCCES'));
	} else {
		//nedefinit, redirectionam la prima pagina
		$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
	} 
}	
