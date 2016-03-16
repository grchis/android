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
				$id =& JRequest::getVar( 'id', '', 'get', 'string' );
				
				//verificam firma....
				$query = "SELECT `cod_fiscal` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
				$db->setQuery($query);
				$cf = $db->loadResult();
				
				$query = "SELECT `cod_fiscal` FROM #__sa_profiles WHERE `uid` = '".$id."'";
				$db->setQuery($query);
				$cf2 = $db->loadResult();
				if ($cf == $cf2) {
					//updatam datele
					
					$query = "UPDATE #__users SET `block` = '0' WHERE `id` = '".$id."'";
					$db->setQuery($query);
					$db->query();
					//echo $query;
					//trimitem link userului sa-l anuntam ca i s-a deblocat contul
					//obtinem datele userului
					$query = "SELECT`email` FROM #__users WHERE `id` = '".$id."'";
					$db->setQuery($query);
					$email = $db->loadResult();
					//echo $query;
					$mailer = JFactory::getMailer();
					$config = JFactory::getConfig();
					$sender = array( 
						$config->getValue( 'config.mailfrom' ),
						$config->getValue( 'config.fromname' ) );
			
					$text_subiect = JText::sprintf('SA_MAIL_SUBJECT_APROVE_FIL');
					$text_corp_mail = JText::sprintf('SA_MAIL_FIL_APROVED');
					$text_titlu_mail = JText::sprintf('SA_MAIL_TITLU_APROVE_FIL');
	
					$mailer->addRecipient($email);
					$body = $text_subiect;
					$body .= $text_corp_mail;
					$mailer->setSubject($text_titlu_mail);
					$mailer->setBody($body);
					//echo $body;
					$send = $mailer->Send();
		
					$link_ok = JRoute::_('index.php?option=com_sauto&view=edit_profile#t6');
					$app->redirect($link_ok, JText::_('SAUTO_SUCCESS_ACTIVATE_FILIALA'));
				} else {
					$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
				}
			} else {
				//nedefinit, redirectionam la prima pagina
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			} 
		}
	?> 



