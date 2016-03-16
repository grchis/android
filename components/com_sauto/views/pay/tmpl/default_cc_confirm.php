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
			
######################
#includem fisierele necesare
require_once("mobilpay/abstract.php");
require_once("mobilpay/card.php");
require_once("mobilpay/invoice.php");
require_once("mobilpay/address.php");
require_once("mobilpay/notify.php");

$errorCode 		= 0;
$errorType		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_NONE;
$errorMessage	= '';

			
if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') == 0)
{	
	
	
	if(isset($_POST['env_key']) && isset($_POST['data']))
	{
		#calea catre cheia privata
		#cheia privata este generata de mobilpay, accesibil in Admin -> Conturi de comerciant -> Detalii -> Setari securitate
		$privateKeyFilePath = '/home/rsit5498/public_html/final/components/com_sauto/views/pay/tmpl/certificates/private.key';
		try
		{
		########################		
		#urmatoare linie creaza problema.......
		$objPmReq = Mobilpay_Payment_Request_Abstract::factoryFromEncrypted($_POST['env_key'], $_POST['data'], $privateKeyFilePath);
		#uncomment the line below in order to see the content of the request
		//print_r($objPmReq);
		$errorCode = $objPmReq->objPmNotify->errorCode;
		// action = status only if the associated error code is zero
		
			if ($errorCode == "0") {
		    	switch($objPmReq->objPmNotify->action)
		    	{
				#orice action este insotit de un cod de eroare si de un mesaj de eroare. Acestea pot fi citite folosind $cod_eroare = $objPmReq->objPmNotify->errorCode; respectiv $mesaj_eroare = $objPmReq->objPmNotify->errorMessage;
				#pentru a identifica ID-ul comenzii pentru care primim rezultatul platii folosim $id_comanda = $objPmReq->orderId;
				case 'confirmed':
					#cand action este confirmed avem certitudinea ca banii au plecat din contul posesorului de card si facem update al starii comenzii si livrarea produsului
				//update DB, SET status = "confirmed/captured"
				
				###########################
				#adaugare cod nou
				$payment_currency = $objPmReq->invoice-currency;
				$item_name = $objPmReq->invoice->details;
				$payment_amount = $objPmReq->invoice->amount;
				$items = explode("-", $item_name);

				$moneda = 1;	
				##########
				$time = time();
				$data_tr = date('Y-m-d H:i:s', $time);
		
				//adaugam factura
				
					if ($items[0] == 'credite') {	$tip_plata = 'credit';
					} else { $tip_plata = 'abonament'; }
		
					if ($tip_plata == 'credit') {
					$query = "SELECT * FROM #__sa_serii_facturi WHERE `id` = '1'";
					$db->setQuery($query);
					$serii = $db->loadObject();
					
					$nr_crt = $serii->nr_crt + 1;
					$fact = 'cc - '.$serii->serie.' - '.$nr_crt;
					$query = "INSERT INTO #__sa_facturi (`uid`, `factura`, `status_tr`, `tip_plata`, `credite`, `pret`, `moneda`, `data_tr`) 
					VALUES ('".$items[2]."', '".$fact."', '1', '".$tip_plata."', '".$items[3]."', '".$payment_amount."', '1', '".$data_tr."')";
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
		
		
					$query = "INSERT INTO #__sa_financiar_det (`uid`, `credite`, `cumparare`, `data_tranz`, `detalii_cumparare`) 
					VALUES ('".$items[2]."', '".$items[3]."', '3', '".$data_tr."', '".$last_fact."')";
					$db->setQuery($query);
					$db->query();
					$tip_tranzactie = $items[0].'-'.$items[1];
					$query = "INSERT INTO #__sa_tranzactii (`obj_id`, `uid`, `tranz_id`, `tip_tranzactie`, `data_tranzactie`, `pret`, `moneda`, `aprobata`) 
					VALUES ('".$objPmReq->orderId."', '".$items[2]."', '".$last_fact."', '".$tip_tranzactie."', '".$time."', '".$payment_amount."', '1', '1')";
					$db->setQuery($query);
					$db->query();
					//incrementare nr curent
					$query = "UPDATE #__sa_serii_facturi SET `nr_crt` = '".$nr_crt."' WHERE `id` = '1'";
					$db->setQuery($query);
					$db->query();
					########################################################
					} else {
					$query = "SELECT * FROM #__sa_serii_facturi WHERE `id` = '1'";
					$db->setQuery($query);
					$serii = $db->loadObject();
					$nr_crt = $serii->nr_crt + 1;
					//incrementare nr curent
					$query = "UPDATE #__sa_serii_facturi SET `nr_crt` = '".$nr_crt."' WHERE `id` = '1'";
					$db->setQuery($query);
					$db->query();
					//serie factura
					$fact = 'cc - '.$serii->serie.' - '.$nr_crt;
					$credit = 'abonament';
					$query = "INSERT INTO #__sa_facturi (`uid`, `factura`, `status_tr`, `tip_plata`, `credite`, `pret`, `moneda`) 
					VALUES ('".$items[2]."', '".$fact."', '1', '".$credit."', '',  '".$payment_amount."', '1')";
					$db->setQuery($query);
					$db->query();
					$last_fact = $db->insertid();
		
					//adaugam tranzactia
					$tip_tranzactie = $items[0].'-'.$items[1];
					$query = "INSERT INTO #__sa_tranzactii (`obj_id`, `uid`, `tranz_id`, `tip_tranzactie`, `data_tranzactie`, `pret`, `moneda`, `aprobata`) 
					VALUES ('".$objPmReq->orderId."', '".$items[2]."', '".$last_fact."', '".$tip_tranzactie."', '".$time."', '".$payment_amount."', '1', '1')";
					$db->setQuery($query);
					$db->query();
					
					$query = "SELECT `id` FROM #__sa_abonament WHERE `pret` = '".$items[4]."'";
					$db->setQuery($query);
					$abonament = $db->loadResult();
		
					$query = "UPDATE #__sa_profiles SET `abonament` = '".$abonament."', `data_abonare` = '".$time."' WHERE `uid` = '".$items[2]."'";
					$db->setQuery($query);
					$db->query();
					}
	
				###########################
			
				$errorMessage = $objPmReq->objPmNotify->errorMessage;
				
				$query = "INSERT INTO #__sa_mobilpay (`orderId`, `errorCode`, `errorType`, `errorMessage`, `status`) 
				VALUES ('".$objPmReq->orderId."', '".$errorCode."', '".$errorType."', '".$errorMessage."', 'confirmed')";
				$db->setQuery($query);
				$db->query();
			    break;
				case 'confirmed_pending':
				$errorMessage = $objPmReq->objPmNotify->errorMessage;
				$query = "INSERT INTO #__sa_mobilpay (`orderId`, `errorCode`, `errorType`, `errorMessage`, `status`) 
				VALUES ('".$objPmReq->orderId."', '".$errorCode."', '".$errorType."', '".$errorMessage."', 'confirmed_pending')";
				$db->setQuery($query);
				$db->query();
					#cand action este confirmed_pending inseamna ca tranzactia este in curs de verificare antifrauda. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
				//update DB, SET status = "pending"
				
			    break;
				case 'paid_pending':
					#cand action este paid_pending inseamna ca tranzactia este in curs de verificare. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
				//update DB, SET status = "pending"
				$errorMessage = $objPmReq->objPmNotify->errorMessage;
				$query = "INSERT INTO #__sa_mobilpay (`orderId`, `errorCode`, `errorType`, `errorMessage`, `status`) 
				VALUES ('".$objPmReq->orderId."', '".$errorCode."', '".$errorType."', '".$errorMessage."', 'paid_pending')";
				$db->setQuery($query);
				$db->query();
			    break;
				case 'paid':
					#cand action este paid inseamna ca tranzactia este in curs de procesare. Nu facem livrare/expediere. In urma trecerii de aceasta procesare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
				//update DB, SET status = "open/preauthorized"
				$errorMessage = $objPmReq->objPmNotify->errorMessage;
				$query = "INSERT INTO #__sa_mobilpay (`orderId`, `errorCode`, `errorType`, `errorMessage`, `status`) 
				VALUES ('".$objPmReq->orderId."', '".$errorCode."', '".$errorType."', '".$errorMessage."', 'paid')";
				$db->setQuery($query);
				$db->query();
			    break;
				case 'canceled':
					#cand action este canceled inseamna ca tranzactia este anulata. Nu facem livrare/expediere.
				//update DB, SET status = "canceled"
				$errorMessage = $objPmReq->objPmNotify->errorMessage;
				$query = "INSERT INTO #__sa_mobilpay (`orderId`, `errorCode`, `errorType`, `errorMessage`, `status`) 
				VALUES ('".$objPmReq->orderId."', '".$errorCode."', '".$errorType."', '".$errorMessage."', 'canceled')";
				$db->setQuery($query);
				$db->query();
			    break;
				case 'credit':
					#cand action este credit inseamna ca banii sunt returnati posesorului de card. Daca s-a facut deja livrare, aceasta trebuie oprita sau facut un reverse. 
				//update DB, SET status = "refunded"
				$errorMessage = $objPmReq->objPmNotify->errorMessage;
				$query = "INSERT INTO #__sa_mobilpay (`orderId`, `errorCode`, `errorType`, `errorMessage`, `status`) 
				VALUES ('".$objPmReq->orderId."', '".$errorCode."', '".$errorType."', '".$errorMessage."', 'credit')";
				$db->setQuery($query);
				$db->query();
			    break;
				default:
				$errorType		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
			    $errorCode 		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_ACTION;
			    $errorMessage 	= 'mobilpay_refference_action paramaters is invalid';
			    $query = "INSERT INTO #__sa_mobilpay (`orderId`, `errorCode`, `errorType`, `errorMessage`, `status`) 
				VALUES ('".$objPmReq->orderId."', '".$errorCode."', '".$errorType."', '".$errorMessage."', 'default')";
				$db->setQuery($query);
				$db->query();
			    break;
		    	}
			} else {
			//update DB, SET status = "rejected"
			$errorMessage = $objPmReq->objPmNotify->errorMessage;
			$query = "INSERT INTO #__sa_mobilpay (`orderId`, `errorCode`, `errorType`, `errorMessage`, `status`) 
			VALUES ('".$objPmReq->orderId."', '".$errorCode."', '".$errorType."', '".$errorMessage."', 'rejected')";
			$db->setQuery($query);
			$db->query();
			}
		}
		catch(Exception $e)
		{
			$errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_TEMPORARY;
			$errorCode		= $e->getCode();
			$errorMessage 	= $e->getMessage();
		}
	} else {
		$errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
		$errorCode		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_POST_PARAMETERS;
		$errorMessage 	= 'mobilpay.ro posted invalid parameters';
	}
} else {
	$errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
	$errorCode		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_POST_METHOD;
	$errorMessage 	= 'invalid request metod for payment confirmation';
}


//header('Content-type: application/xml');
JResponse::setHeader('Content-Type', 'application/xml', true);
//JResponse::setHeader('Content-Disposition', 'inline; filename="groups.xml"', true);
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
if($errorCode == 0)
{
	echo "<crc>{$errorMessage}</crc>";
}
else
{
	echo "<crc error_type=\"{$errorType}\" error_code=\"{$errorCode}\">{$errorMessage}</crc>";
}
//////////////////


