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
$user =& JFactory::getUser();
$uid = $user->id;

$db = JFactory::getDbo();
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');



if ($uid == 0) {
	$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
} else {
$rasp_id = $app->getUserState('rasp_id');
$anunt_id = $app->getUserState('anunt_id');
//seteaza oferta ca si castigatoare.....
//obtin raspuns

	//verificam daca este anuntul meu
	$query = "SELECT `proprietar` FROM #__sa_anunturi WHERE `id` = '".$anunt_id."'";
	$db->setQuery($query);
	$proprietar = $db->loadResult();
	if ($proprietar == $uid) {
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
	if (in_array(" 3-1", $alerte)) {
		$baza = JUri::base();
		$oferta = JRoute::_($baza.'index.php?option=com_sauto&view=request_detail&id='.$anunt_id);
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();
		$sender = array( 
			$config->getValue( 'config.mailfrom' ),
			$config->getValue( 'config.fromname' ) );
 
		$mailer->addRecipient($rez->email);
		$body   = "Salut ".$rez->reprezentant."\n";
		$body .= "Oferta facuta a fost aleasa castigatoare, va rugam accesati acest link pentru a vedea mai multe detalii: <a href=\"".$oferta."\">".$oferta."</a>\n";
		$mailer->setSubject('Oferta castigata!');
		$mailer->setBody($body);
		$send = $mailer->Send();
	}
	$link_ok = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$anunt_id);
	$app->redirect($link_ok, JText::_('SAUTO_SUCCESSFULY_SET_WINNER'));


	} else {
		$app->redirect($link_redirect);
	}
}
?>

