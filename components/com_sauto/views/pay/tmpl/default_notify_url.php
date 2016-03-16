<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access

$db = JFactory::getDbo();

				
				
				
//adaugam plata in baza de date
$request = "cmd=_notify-validate";
foreach ($_POST as $varname => $varvalue){
    $email .= "$varname: $varvalue\n";  
    if(function_exists('get_magic_quotes_gpc') and get_magic_quotes_gpc()){  
        $varvalue = urlencode(stripslashes($varvalue));
    }
    else {
        $value = urlencode($value);
    }
    $request .= "&$varname=$varvalue";
}
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://www.sandbox.paypal.com/cgi-bin/webscr");
//curl_setopt($ch,CURLOPT_URL,"https://www.paypal.com");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$request);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,false);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$result = curl_exec($ch);
curl_close($ch);
$txn_id = $_POST['txn_id'];
$item_name = $_POST['custom'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];

switch($result){
    case "VERIFIED":
        // verified payment
        
        $query = "SELECT count(*) FROM #__sa_tranzactii WHERE `txn_id` = '".$txn_id."'";
		$db->setQuery($query);
		$total = $db->loadResult();
		if ($total == 0) {
			$items = explode("-", $item_name);
		$moneda = 'EUR';
			
		##########
		$time = time();
		$data_tr = date('Y-m-d H:i:s', $time);
		if ($items[0] == 'credite') {
			$tip_plata = 'credit';
		} else { $tip_plata = 'abonament'; }
		
		if ($tip_plata == 'credit') {
		//adaug factura si ce mai trebuie
		
		$query = "SELECT * FROM #__sa_serii_facturi WHERE `id` = '1'";
		$db->setQuery($query);
		$serii = $db->loadObject();
		$nr_crt = $serii->nr_crt + 1;
		//adaugam factura
		$fact = 'pp - '.$serii->serie.' - '.$nr_crt;
		
		$query = "INSERT INTO #__sa_facturi (`uid`, `factura`, `status_tr`, `tip_plata`, `credite`, `pret`, `moneda`, `data_tr`) 
		VALUES ('".$items[2]."', '".$fact."', '1', '".$tip_plata."', '".$items[3]."', '".$payment_amount."', '3', '".$data_tr."')";
		$db->setQuery($query);
		$db->query();
		$last_fact = $db->insertid();
		
		//obtinem numarul de credite curent
		$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$items[2]."'";
		$db->setQuery($query);
		$old_credit = $db->loadResult();
		$new_credit = ($old_credit + $items[3]);
		$query = "UPDATE #__sa_financiar SET `credite` = '".$new_credit."' WHERE `uid` = '".$items[2]."'";
		$db->setQuery($query);
		$db->query();
		
		$query = "INSERT INTO #__sa_financiar_det (`uid`, `credite`, `cumparare`, `data_tranz`, `detalii_cumparare`) VALUES ('".$items[2]."', '".$items[3]."', '3', '".$data_tr."', '".$last_fact."')";
		$db->setQuery($query);
		$db->query();
		$tip_tranzactie = $items[0].'-'.$items[1];
		$query = "INSERT INTO #__sa_tranzactii (`txn_id`, `uid`, `tranz_id`, `tip_tranzactie`, `data_tranzactie`, `pret`, `moneda`, `aprobata`) 
		VALUES ('".$txn_id."', '".$items[2]."', '".$last_fact."', '".$tip_tranzactie."', '".$time."', '".$payment_amount."', '3', '1')";
		$db->setQuery($query);
		$db->query();
		//incrementare nr curent
		$query = "UPDATE #__sa_serii_facturi SET `nr_crt` = '".$nr_crt."' WHERE `id` = '1'";
		$db->setQuery($query);
		$db->query();
		} else {
		#################################################################################################
		#################################################################################################
		#################################################################################################
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
		$fact = 'pp - '.$serii->serie.' - '.$nr_crt;
		$credit = 'abonament';
		$query = "INSERT INTO #__sa_facturi (`uid`, `factura`, `status_tr`, `tip_plata`, `credite`, `pret`, `moneda`, `curs_euro`) 
		VALUES ('".$items[2]."', '".$fact."', '1', '".$credit."', '',  '".$payment_amount."', '3', '')";
		$db->setQuery($query);
		$db->query();
		//echo $query.'<hr />';
		$last_fact = $db->insertid();
		
		//$query = "INSERT INTO #__sa_financiar_temp (`tranz_id`, `pret`, `moneda`, `credite`) VALUES ('".$last_fact."', '".$pret."', '".$moneda."', '')";
		//$db->setQuery($query);
		//$db->query();
		//echo $query.'<hr />';
		//adaugam tranzactia
		$tip_tranzactie = $items[0].'-'.$items[1];
		$query = "INSERT INTO #__sa_tranzactii (`tranz_id`, `uid`, `tip_tranzactie`, `data_tranzactie`, `pret`, `moneda`, `fisier`, `curs_euro`, `aprobata`) 
		VALUES ('".$last_fact."', '".$items[2]."', '".$tip_tranzactie."', '".$time."', '".$payment_amount."', '3', '', '', '1')";
		$db->setQuery($query);
		$db->query();
		$query = "SELECT `id` FROM #__sa_abonament WHERE `pret` = '".$payment_amount."'";
		$db->setQuery($query);
		$abonament = $db->loadResult();
		//$time = time();
		
		$query = "UPDATE #__sa_profiles SET `abonament` = '".$abonament."', `data_abonare` = '".$time."' WHERE `uid` = '".$items[2]."'";
		$db->setQuery($query);
		$db->query();
		} 
		
	}
        break;
    case "INVALID":
        // invalid/fake payment
        break;
    default:
        // any other case (such as no response, connection timeout...)
}

