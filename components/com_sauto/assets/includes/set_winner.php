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

$app =& JFactory::getApplication();

$db = JFactory::getDbo();

$anunt_id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$rasp_id =& JRequest::getVar( 'rasp_id', '', 'post', 'string' );
//echo 'anunt id > '.$anunt_id.' si raspunsul > '.$rasp_id.'<br />';
//obtin raspuns
$query = "SELECT * FROM #__sa_raspunsuri WHERE `id` = '".$rasp_id."'";
$db->setQuery($query);
$raspuns = $db->loadObject();
$query = "UPDATE #__sa_raspunsuri SET `status_raspuns` = '1' WHERE `id` = '".$rasp_id."'";
$db->setQuery($query);
$db->query();

$time = time();
$data_castigare = date('Y-m-d H:i:s', $time);

$query = "UPDATE #__sa_anunturi SET `is_winner` = '1', `uid_winner` = '".$raspuns->firma."', `pret_winner` = '".$raspuns->pret_oferit."', `moneda_winner` = '".$raspuns->moneda."', `data_castigare` = '".$data_castigare."' WHERE `id` = '".$anunt_id."'";
$db->setQuery($query);
$db->query();
	//alerte....
	$query = "SELECT `p`.`reprezentant`, `p`.`alerte`, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`uid` = '".$raspuns->firma."' AND `p`.`uid` = `u`.`id`";
	$db->setQuery($query);
	$rez = $db->loadObject();
	$alerte = explode(",", $rez->alerte);
	if (in_array("s-6_1", $alerte)) {
		$baza = JUri::base();
		$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$anunt_id);
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();
		$sender = array( 
			$config->get( 'config.mailfrom' ),
			$config->get( 'config.fromname' ) );
		
		$text_subiect = JText::sprintf('SA_MAIL_SUBJECT_SALUT', $rez->reprezentant);
		$text_corp_mail = JText::sprintf('SA_MAIL_OFERTA_CASTIGATA', $oferta);
		$text_titlu_mail = JText::sprintf('SA_MAIL_TITLU_OFERTA_CASTIGATA');
		
		
		$mailer->addRecipient($rez->email);
		$body = $text_subiect; 
		$body .= $text_corp_mail;
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setSubject($text_titlu_mail);
		$mailer->setBody($body);
		$send = $mailer->Send();
	}
$link_redirect = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$anunt_id);
$app->redirect($link_redirect, JText::_('SAUTO_SUCCESSFULY_SET_WINNER'));
?>

