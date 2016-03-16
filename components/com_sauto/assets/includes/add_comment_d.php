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

$anunt_id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$proprietar =& JRequest::getVar( 'proprietar', '', 'post', 'string' );
$firma =& JRequest::getVar( 'firma', '', 'post', 'string' );
$mesaj =& JRequest::getVar( 'mesaj', '', 'post', 'string' );
$db = JFactory::getDbo();
$link_redirect = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$anunt_id);
	

//obtin numarul de ordine
$query = "SELECT `ordonare` FROM #__sa_comentarii WHERE `anunt_id` = '".$anunt_id."' AND `proprietar` = '".$proprietar."' AND `companie` = '".$firma."' ORDER BY `ordonare` DESC";
$db->setQuery($query);
$total = $db->loadResult();
if ($total == '') {
	$ordonare = 1;
} else {
	$ordonare = $total + 1;
}
$time = time();
$publishDate = date('Y-m-d H:i:s', $time);



$query = "INSERT INTO #__sa_comentarii (`anunt_id`, `proprietar`, `companie`, `data_adaugarii`, `mesaj`, `published`, `ordonare`, `raspuns`) VALUES ('".$anunt_id."', '".$proprietar."', '".$firma."', '".$publishDate."', '".$mesaj."', '1', '".$ordonare."', '1')";
$db->setQuery($query);
$db->query();
$comm_id = $db->insertid();
###########################prelucrare imagine#############
SautoViewAdd_comment::uploadImg($time, $proprietar, $anunt_id, $comm_id);
###########################end prelucrare imagine##################

	$query = "SELECT `p`.`fullname`, `p`.`alerte`, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`uid` = '".$proprietar."' AND `p`.`uid` = `u`.`id`";
	$db->setQuery($query);
	$rez = $db->loadObject();
	$alerte = explode(",", $rez->alerte);
	if (in_array("s-2_1", $alerte)) {
		$baza = JUri::base();
		$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$anunt_id);
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();
		$sender = array( 
			$config->get( 'config.mailfrom' ),
			$config->get( 'config.fromname' ) );
		
		$text_subiect = JText::sprintf('SA_MAIL_SUBJECT_SALUT', $rez->fullname);
		$text_corp_mail = JText::sprintf('SA_MAIL_COMM_NOU', $oferta);
		$text_titlu_mail = JText::sprintf('SA_MAIL_TITLU_COMM_NOU');
		
		
		$mailer->addRecipient($rez->email);
		$body = $text_subiect; 
		$body .= $text_corp_mail;
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setSubject($text_titlu_mail);
		$mailer->setBody($body);
		$send = $mailer->Send();
	}
		
		
$app->redirect($link_redirect, JText::_('SAUTO_COMMENT_ADD_SUCCESSFULY'));
?>

