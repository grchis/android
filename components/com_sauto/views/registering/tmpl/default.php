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
$app =& JFactory::getApplication();
$register_type =& JRequest::getVar( 'register_type', '', 'post', 'string' );
//echo '>>>> '.$register_type;
	if ($uid == 0) {
		//vizitator
		//verificam ce tip de cont se inregistreaza
		$register_type =& JRequest::getVar( 'register_type', '', 'post', 'string' );
		if ($register_type == 'customer') {
			//inregistreaza ca si client
			require_once("components/com_sauto/assets/includes/registering_customer.php");
		} elseif ($register_type == 'dealer') {
			//inregistreaza casi firma
			require_once("components/com_sauto/assets/includes/registering_dealer.php");
		} else {
			//redirectionare pe frontpage
			$link_redirect = JRoute::_('index.php?option=com_sauto&view=profile');
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		}
	} else {
	//redirectionare spre pagina de profil
		$link_redirect = JRoute::_('index.php?option=com_sauto&view=profile');
		$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
	}
?> 
