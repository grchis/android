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
	//preiau variabile
	$calificativ_value =& JRequest::getVar( 'calificativ_value', '', 'post', 'string' );
	$calificativ_mess =& JRequest::getVar( 'calificativ_mess', '', 'post', 'string' );
	$poster_id =& JRequest::getVar( 'poster_id', '', 'post', 'string' );
	$dest_id =& JRequest::getVar( 'dest_id', '', 'post', 'string' );
	$id_anunt =& JRequest::getVar( 'id_anunt', '', 'post', 'string' );
	$type =& JRequest::getVar( 'type', '', 'post', 'string' );
	$redirect =& JRequest::getVar( 'redirect', '', 'post', 'string' );

	if ($redirect == 'detail') {
		$link_ok = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
	} elseif ($redirect == 'final') {
		$link_ok = JRoute::_('index.php?option=com_sauto&view=final_request');
	}
	
	//verificam daca sunt setate variabilele
	if ($calificativ_mess == '') {
		//fara mesaj, redirectionam...
		$app->redirect($link_ok, JText::_('SAUTO_CALIFICATIV_FARA_MESAJ'));
	} else {
		//verificam restul....
		if ($calificativ_value == '') {
			//fara calificativ setat, redirtectionam
			$app->redirect($link_ok, JText::_('SAUTO_CALIFICATIV_FARA_CALIFICATIV'));
		} 
	}
	$query= "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$tip = $db->loadResult();
	if ($tip == 0) {
		//client
		//verificam alertele....
		$query = "SELECT `p`.`reprezentant`, `p`.`alerte`, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`uid` = '".$dest_id."' AND `p`.`uid` = `u`.`id`";
		$db->setQuery($query);
		$rez = $db->loadObject();
		$alerte = explode(",", $rez->alerte);
		if (in_array("s-7_1", $alerte)) {
			$baza = JUri::base();
			$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
			$mailer = JFactory::getMailer();
			$config = JFactory::getConfig();
			$sender = array( 
				$config->get( 'config.mailfrom' ),
				$config->get( 'config.fromname' ) );
 
			$mailer->addRecipient($rez->email);

			$text_subiect = JText::sprintf('SA_MAIL_SUBJECT_SALUT', $rez->reprezentant);
			$text_corp_mail = JText::sprintf('SA_MAIL_CALIFICATIV_PRIMIT', $oferta);
			$text_titlu_mail = JText::sprintf('SA_MAIL_TITLU_CALIFICATIV_NOU');
		
		
			//$body   = "Salut ".$rez->reprezentant."\n";
			$body = $text_subiect; 
			//$body .= "Ati primit un calificativ nou, va rugam accesati acest link pentru a vedea calificativul primit: <a href=\"".$oferta."\">".$oferta."</a>\n";
			$body .= $text_corp_mail;
			//$mailer->setSubject('Calificativ nou!');
			$mailer->setSubject($text_titlu_mail);
			$mailer->setBody($body);
			$send = $mailer->Send();
		}
		set_calificativ($calificativ_value, $calificativ_mess, $poster_id, $dest_id, $id_anunt);
		$app->redirect($link_ok, JText::_('SAUTO_CALIFICATIV_ACORDAT'));
	} elseif ($tip == 1) {
		//dealer
		//verificam alertele....
		$query = "SELECT `p`.`fullname`, `p`.`alerte`, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`uid` = '".$dest_id."' AND `p`.`uid` = `u`.`id`";
		$db->setQuery($query);
		$rez = $db->loadObject();
		$alerte = explode(",", $rez->alerte);
		if (in_array("s-3_1", $alerte)) {
			$baza = JUri::base();
			$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$id_anunt);
			$mailer = JFactory::getMailer();
			$config = JFactory::getConfig();
			$sender = array( 
				$config->get( 'config.mailfrom' ),
				$config->get( 'config.fromname' ) );
 
			$mailer->addRecipient($rez->email);

			$text_subiect = JText::sprintf('SA_MAIL_SUBJECT_SALUT', $rez->fullname);
			$text_corp_mail = JText::sprintf('SA_MAIL_CALIFICATIV_PRIMIT', $oferta);
			$text_titlu_mail = JText::sprintf('SA_MAIL_TITLU_CALIFICATIV_NOU');
			
			//$body   = "Salut ".$rez->fullname."\n";
			$body = $text_subiect; 
			//$body .= "Ati primit un calificativ nou, va rugam accesati acest link pentru a vedea calificativul primit: <a href=\"".$oferta."\">".$oferta."</a>\n";
			$body .= $text_corp_mail;
			//$mailer->setSubject('Calificativ nou!');
			$mailer->setSubject($text_titlu_mail);
			$mailer->setBody($body);
			$send = $mailer->Send();
		}
		set_calificativ($calificativ_value, $calificativ_mess, $poster_id, $dest_id, $id_anunt);
		$app->redirect($link_ok, JText::_('SAUTO_CALIFICATIV_ACORDAT'));
	} else {
		//nedefinit, redirectionam la prima pagina
		$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
	} 
}


function set_calificativ($calificativ_value, $calificativ_mess, $poster_id, $dest_id, $id_anunt) {
	$db = JFactory::getDbo();
	$query = "INSERT INTO #__sa_calificativ (`poster_id`, `dest_id`, `anunt_id`, `mesaj`, `tip`) VALUES ('".$poster_id."', '".$dest_id."', '".$id_anunt."', '".$calificativ_mess."', '".$calificativ_value."')";
	$db->setQuery($query);
	$db->query();
	//obtin calificativul curent
	$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$dest_id."' AND `tip` = 'p'";
	$db->setQuery($query);
	$poz = $db->loadResult();
	$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$dest_id."' AND `tip` = 'x'";
	$db->setQuery($query);
	$neg = $db->loadResult();
	$neg2 = $poz + $neg;
	$feeds = $poz/$neg2;
	$feeds = round(100*$feeds,2);
	//update profil
	$query = "UPDATE #__sa_profiles SET `calificative` = '".$feeds."' WHERE `uid` = '".$dest_id."'";
	$db->setQuery($query);
	$db->query();
}		
		
?>

