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
//preluare variabile din sesiune
$app =& JFactory::getApplication();
$id_anunt = $app->getUserState('id_anunt');
$mesaj = $app->getUserState('mesaj');
$pret = $app->getUserState('pret');
$moneda = $app->getUserState('moneda');
//
//echo '>>>> '.$id_anunt.'<br /> >>>> '.$mesaj.'<br /> >>>> '.$pret.' >>> '.$moneda;
//verificam daca sunt suficiente credite
$user =& JFactory::getUser();
$uid = $user->id;
$db = JFactory::getDbo();
//echo $uid.' .....<br />';
$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$credite = $db->loadResult();
if ($credite > 2) {
	//adauga oferta
	//preiau ofertele curente
	$query = "SELECT `oferte`, `proprietar` FROM #__sa_anunturi WHERE `id` = '".$id_anunt."'";
	$db->setQuery($query);
	$list = $db->loadObject();
	$new_oferte = $list->oferte + 1;
	//echo '>>>> '.$list->oferte.' >>> '.$new_oferte.' >>> '.$list->proprietar;
	
	$time = time();
	$curentDate = date('Y-m-d H:i:s', $time);
	
	//verificam alertele proprietarului
		$query = "SELECT `p`.`fullname`, `p`.`alerte`, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`uid` = '".$list->proprietar."' AND `p`.`uid` = `u`.`id`";
		$db->setQuery($query);
		$rez = $db->loadObject();
		//echo '>>>> '.$rez->alerte.'<br />';
		$alerte = explode(",", $rez->alerte);
		//print_r($alerte);
		//echo '<br />';
		if (in_array("1-1", $alerte)) {
			$baza = JUri::base();
			$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
			$mailer = JFactory::getMailer();
			$config = JFactory::getConfig();
			$sender = array( 
				$config->get( 'config.mailfrom' ),
				$config->get( 'config.fromname' ) );
 
			$mailer->addRecipient($rez->email);

			$body   = "Salut ".$rez->fullname."<br />";
			$body .= "Ati primit o oferta noua, va rugam accesati acest link pentru a vedea oferta: <a href=\"".$oferta."\">".$oferta."</a><br />";
			$mailer->isHTML(true);
			$mailer->Encoding = 'base64';
			$mailer->setSubject('Oferta noua!');			
			$mailer->setBody($body);
			$send = $mailer->Send();
		}
			
	//scadem 2 credite
	
	//adaugam oferta noua
	$query = "INSERT INTO #__sa_raspunsuri (`anunt_id`, `proprietar`, `firma`, `mesaj`, `data_adaugarii`, `status_raspuns`, `pret_oferit`, `moneda`) VALUES ('".$id_anunt."', '".$list->proprietar."', '".$uid."', '".$mesaj."', '".$curentDate."', '0', '".$pret."', '".$moneda."')";
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
	if (in_array(" 5-1", $alerte)) {
		//verificam numarul de credite....
		if ($new_credit < 2) {
		$baza = JUri::base();
		$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();
		$sender = array( 
			$config->get( 'config.mailfrom' ),
			$config->get( 'config.fromname' ) );
 
		$mailer->addRecipient($rez->email);

		$body   = "Salut ".$rez->reprezentant."<br />";
		$body .= "Va atentionam ca mai aveti ".$new_credit." credite si nu mai puteti face nici o oferta.<br />";
		$body .= "Pentru a mai putea face oferte va trebui sa mai achizitionati credite.";
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setSubject('Lipsa credite!');
		$mailer->setBody($body);
		$send = $mailer->Send();
		}
	}
	
	//redirectionam....
	$link_ok = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
	$app->redirect($link_ok, JText::_('SAUTO_OFERTA_EFECTUATA_CU_SUCCES'));
	$app->setUserState('id_anunt', '');
	$app->setUserState('mesaj', '');
	$app->setUserState('pret', '');
	 $app->setUserState('moneda', '');
} else {
	//nu se poate oferta...
	$link_ok = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
	$app->redirect($link_ok, JText::_('SAUTO_OFERTA_NEEFECTUATA_LIPSA_CREDITE'));
}
?>

