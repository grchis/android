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
$tip_plata =& JRequest::getVar( 'tip_plata', '', 'post', 'string' );
$time = time();
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$app =& JFactory::getApplication();

$serie_prf = $uid.'-'.$time;

if ($tip_plata == 'abonament') {
	//echo 'generare proforma pentru abonament nou';
	$curs_euro =& JRequest::getVar( 'curs_euro', '', 'post', 'string' );
	//echo '>>> '.$curs_euro;
	
	$abonament =& JRequest::getVar( 'abonament', '', 'post', 'string' );
	$pret =& JRequest::getVar( 'pret', '', 'post', 'string' );
	$moneda =& JRequest::getVar( 'moneda', '', 'post', 'string' );
	
	$query = "SELECT * FROM #__sa_serii_facturi WHERE `id` = '1'";
	$db->setQuery($query);
	$serii = $db->loadObject();
	$nr_crt = $serii->nr_crt + 1;
	
	//incrementare nr curent
	$query = "UPDATE #__sa_serii_facturi SET `nr_crt` = '".$nr_crt."' WHERE `id` = '1'";
	$db->setQuery($query);
	$db->query();
	
	//echo $query.'<hr />';
	//serie factura
	$fact = 'op - '.$serii->serie.' - '.$nr_crt;
	$credit = 'abonament';
	
	
	$query = "INSERT INTO #__sa_facturi (`uid`, `factura`, `status_tr`, `tip_plata`, `credite`, `pret`, `moneda`, `curs_euro`, `serie_prf`, `data_prf`, `prf`, `tip_abn`) 
	VALUES ('".$uid."', '".$fact."', '0', '".$credit."', '',  '".$pret."', '".$moneda."', '".$curs_euro."', '".$serie_prf."', '".$time."', '1', '".$abonament."')";
	$db->setQuery($query);
	$db->query();
	
	//echo $query.'<hr />';
	$last_fact = $db->insertid();
		
	//$query = "INSERT INTO #__sa_financiar_temp (`tranz_id`, `pret`, `moneda`, `credite`) VALUES ('".$last_fact."', '".$pret."', '".$moneda."', '')";
	//$db->setQuery($query);
	//$db->query();
	//echo $query.'<hr />';
	
	//adaugam tranzactia
	$query = "INSERT INTO #__sa_tranzactii (`tranz_id`, `uid`, `tip_tranzactie`, `data_tranzactie`, `pret`, `moneda`, `fisier`, `curs_euro`) VALUES ('".$last_fact."', '".$uid."', 'abonament-op', '".$time."', '".$pret."', '".$moneda."', '', '".$curs_euro."')";
	$db->setQuery($query);
	$db->query();
	
	//echo $query;
	//redirectionam
	$link_redirect = JRoute::_('index.php?option=com_sauto&view=facturi');
	$app->redirect($link_redirect, JText::_('SAUTO_SUCCES_GENERATE_PROFORMA'));
} else {
	$pret =& JRequest::getVar( 'pret', '', 'post', 'string' );
		$query = "SELECT * FROM #__sa_serii_facturi WHERE `id` = '1'";
		$db->setQuery($query);
		$serii = $db->loadObject();
		$nr_crt = $serii->nr_crt + 1;
		//adaugam factura
		$fact = 'op - '.$serii->serie.' - '.$nr_crt;

		$credit = 'credit';
		$query = "INSERT INTO #__sa_facturi (`uid`, `factura`, `status_tr`, `tip_plata`, `credite`, `pret`, `moneda`, `serie_prf`, `data_prf`, `prf`) 
		VALUES ('".$uid."', '".$fact."', '0', '".$credit."', '".$pret."', '".$pret."', '1', '".$serie_prf."', '".$time."', '1')";
		$db->setQuery($query);
		$db->query();
		$last_fact = $db->insertid();
		
		$query = "INSERT INTO #__sa_financiar_temp (`tranz_id`, `pret`, `moneda`, `credite`) VALUES ('".$last_fact."', '".$pret."', '1', '".$pret."')";
		$db->setQuery($query);
		$db->query();
		//incrementare nr curent
		$query = "UPDATE #__sa_serii_facturi SET `nr_crt` = '".$nr_crt."' WHERE `id` = '1'";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO #__sa_tranzactii (`tranz_id`, `uid`, `tip_tranzactie`, `data_tranzactie`, `pret`, `moneda`, `fisier`, `curs_euro`) VALUES ('".$last_fact."', '".$uid."', 'credite-op', '".$time."', '".$pret."', '1', '', '')";
		$db->setQuery($query);
		$db->query();
		
		$link_ok = JRoute::_('index.php?option=com_sauto&view=facturi');
		$app->redirect($link_ok, JText::_('SAUTO_SUCCES_GENERATE_PROFORMA'));
}
