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
		//verificam creditele
		$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$credite = $db->loadResult();
		if ($credite < 2) {
			//nu se poate face oferta...
			$link_not_ok = JRoute::_('index.php?option=com_sauto&view=requests');
			$app->redirect($link_not_ok, JText::_('SAUTO_OFERTA_NREFECTUATA_LIPSA_CREDITE'));
		} else {
		//procesam oferta de pret
		$time = time();
		$curentDate = date('Y-m-d H:i:s', $time);
		$id_anunt =& JRequest::getVar( 'id_anunt', '', 'post', 'string' );
		$owner_id =& JRequest::getVar( 'owner_id', '', 'post', 'string' );
		$mesaj =& JRequest::getVar( 'mesaj', '', 'post', 'string' );
		$pret =& JRequest::getVar( 'pret', '', 'post', 'string' );
		$moneda =& JRequest::getVar( 'moneda', '', 'post', 'string' );
		//echo 'acu procesam....<br />';
		//echo 'id anunt > '.$id_anunt.'<br />owner id > '.$owner_id.'<br />mesaju > '.$mesaj.'<br />pretul > '.$pret.'<br />moneda > '.$moneda;
		
		//verificam alertele proprietarului
		$query = "SELECT `p`.`fullname`, `p`.`alerte`, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`uid` = '".$owner_id."' AND `p`.`uid` = `u`.`id`";
		$db->setQuery($query);
		$rez = $db->loadObject();
		//echo '>>>> '.$rez->alerte.'<br />';
		$alerte = explode(",", $rez->alerte);
		//print_r($alerte);
		//echo '<br />';
		if (in_array("s-1_1", $alerte)) {
			$baza = JUri::base();
			$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
			$mailer = JFactory::getMailer();
			$config = JFactory::getConfig();
			$sender = array( 
				$config->get( 'config.mailfrom' ),
				$config->get( 'config.fromname' ) );
 
			$mailer->addRecipient($rez->email);
			
			$text_subiect = JText::sprintf('SA_MAIL_SUBJECT_SALUT', $rez->fullname);
			$text_corp_mail = JText::sprintf('SA_MAIL_OFERTA_NOUA', $oferta);
			$text_titlu_mail = JText::sprintf('SA_MAIL_TITLU_OFERTA');
			$body = $text_subiect;
			//$body   = "Salut ".$rez->fullname."\n";
			$body .= $text_corp_mail;
			//$body .= "Ati primit o oferta noua, va rugam accesati acest link pentru a vedea oferta: <a href=\"".$oferta."\">".$oferta."</a>\n";
			$mailer->isHTML(true);
			$mailer->Encoding = 'base64';
			$mailer->setSubject($text_titlu_mail);
			//$mailer->setSubject('Oferta noua!');
			$mailer->setBody($body);
			$send = $mailer->Send();
		}
		
		
		
		$query = "INSERT INTO #__sa_raspunsuri (`anunt_id`, `proprietar`, `firma`, `mesaj`, `data_adaugarii`, `status_raspuns`, `pret_oferit`, `moneda`) VALUES ('".$id_anunt."', '".$owner_id."', '".$uid."', '".$mesaj."', '".$curentDate."', '0', '".$pret."', '".$moneda."')";
		$db->setQuery($query);
		$db->query();
		$last_rasp_id = $db->insertid();
		//actualizam partea financiara
		$new_credit = $credite - 2;
		$query = "UPDATE #__sa_financiar SET `credite` = '".$new_credit."' WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$db->query();
		$query = "INSERT INTO #__sa_financiar_det (`uid`, `anunt_id`, `raspuns_id`, `credite`) VALUES ('".$uid."', '".$id_anunt."', '".$last_rasp_id."', '2')";
		$db->setQuery($query);
		$db->query();
		//preluam numarul curent de oferte
		$query = "SELECT `oferte` FROM #__sa_anunturi WHERE `id` = '".$id_anunt."'";
		$db->setQuery($query);
		$oferte = $db->loadResult();
		if ($oferte == 0) {
			$new_oferte = 1;
		} else {
			$new_oferte = $oferte + 1;
		}
		$query = "UPDATE #__sa_anunturi SET `oferte` = '".$new_oferte."' WHERE `id` = '".$id_anunt."'";
		$db->setQuery($query);
		$db->query();
		
		
		//verificam alertele firmei
		$query = "SELECT `p`.`reprezentant`, `p`.`alerte`, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`uid` = '".$uid."' AND `p`.`uid` = `u`.`id`";
		$db->setQuery($query);
		$rez = $db->loadObject();
		//echo '>>>> '.$rez->alerte.'<br />';
		$alerte = explode(",", $rez->alerte);
		//print_r($alerte);
		//echo '<br />';
		if (in_array("s-10_1", $alerte)) {
			//verificam numarul de credite....
			if ($new_credit < 5) {
			$baza = JUri::base();
			$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
			$mailer = JFactory::getMailer();
			$config = JFactory::getConfig();
			$sender = array( 
				$config->get( 'config.mailfrom' ),
				$config->get( 'config.fromname' ) );
 
			$mailer->addRecipient($rez->email);
			
			$text_subiect = JText::sprintf('SA_MAIL_SUBJECT_SALUT', $rez->reprezentant);
			$text_corp_mail = JText::sprintf('SA_MAIL_LIMITA_CREDITE', $new_credit);
			$text_corp_mail2 = JText::sprintf('SA_MAIL_LIMITA_CREDITE_2');
			$text_titlu_mail = JText::sprintf('SA_MAIL_TITLU_LIPSA_CREDITE');
			
			$body = $text_subiect;
			//$body   = "Salut ".$rez->reprezentant."\n";
			$body .= $text_corp_mail.$text_corp_mail2;
			//$body .= "Va atentionam ca mai aveti ".$new_credit." credite si nu mai puteti face nici o oferta.\n";
			//$body .= "Pentru a mai putea face oferte va trebui sa mai achizitionati credite.";
			$mailer->isHTML(true);
			$mailer->Encoding = 'base64';
			$mailer->setSubject($text_titlu_mail);
			//$mailer->setSubject('Lipsa credite!');
			$mailer->setBody($body);
			$send = $mailer->Send();
			}
		}
		//redirectionam....
		$link_ok = JRoute::_('index.php?option=com_sauto&view=requests');
		$app->redirect($link_ok, JText::_('SAUTO_OFERTA_EFECTUATA_CU_SUCCES'));
		
		}
	} else {
		//nedefinit, redirectionam la prima pagina
		$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
	} 
}	
