<?php
/**
 * @package    sauto
 * @subpackage Base
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

$login_article =& JRequest::getVar( 'login_article', '', 'post', 'string' );

$request_article =& JRequest::getVar( 'request_article', '', 'post', 'string' );
$link_suport =& JRequest::getVar( 'link_suport', '', 'post', 'string' );
$search_req_right_article =& JRequest::getVar('search_req_right_article', '', 'post', 'string');
$search_req_bottom_article =& JRequest::getVar('search_req_bottom_article', '', 'post', 'string'); 

$alerts_article =& JRequest::getVar( 'alerts_article', '', 'post', 'string' );
$alert_det_article =& JRequest::getVar( 'alert_det_article', '', 'post', 'string' );
$alerte_clienti =& JRequest::getVar( 'alerte_clienti', '', 'post', 'string' );
$alerte_dealer =& JRequest::getVar( 'alerte_dealer', '', 'post', 'string' );

$login_module =& JRequest::getVar( 'login_module', '', 'post', 'string' );
$login_module2 =& JRequest::getVar( 'login_module2', '', 'post', 'string' );
$login_module3 =& JRequest::getVar( 'login_module3', '', 'post', 'string' );
$login_module4 =& JRequest::getVar( 'login_module4', '', 'post', 'string' );
$google_play =& JRequest::getVar( 'google_play', '', 'post', 'string' );
//$tutorial_client =& JRequest::getVar( 'tutorial_client', '', 'post', 'string', JREQUEST_ALLOWHTML  );
//$tutorial_firma =& JRequest::getVar( 'tutorial_firma', '', 'post', 'string', JREQUEST_ALLOWHTML  );
$tutorial_firma = $_POST['tutorial_firma'];
$tutorial_client = $_POST['tutorial_client'];
$custom_register =& JRequest::getVar( 'custom_register', '', 'post', 'string' );
$custom_register_client =& JRequest::getVar( 'custom_register_client', '', 'post', 'string' );
$custom_register_firma =& JRequest::getVar( 'custom_register_firma', '', 'post', 'string' );
$enable_captcha =& JRequest::getVar( 'enable_captcha', '', 'post', 'string' );
$public_key =& JRequest::getVar( 'public_key', '', 'post', 'string' );
$private_key =& JRequest::getVar( 'private_key', '', 'post', 'string' );
$link_terms =& JRequest::getVar( 'link_terms', '', 'post', 'string' );
$max_size =& JRequest::getVar( 'max_size', '', 'post', 'string' );
$valid_ext =& JRequest::getVar( 'valid_ext', '', 'post', 'string' );
$mime_types =& JRequest::getVar( 'mime_types', '', 'post', 'string' );
$id_article_all =& JRequest::getVar( 'id_article_all', '', 'post', 'string' );



$db = JFactory::getDbo();
$query = "UPDATE #__sa_configurare SET `login_article` = '".$login_article."', `login_module` = '".$login_module."', `tutorial_client` = '".$tutorial_client."', `tutorial_firma` = '".$tutorial_firma."', `custom_register` = '".$custom_register."', `custom_register_client` = '".$custom_register_client."', `custom_register_firma` = '".$custom_register_firma."', `enable_captcha` = '".$enable_captcha."', `public_key` = '".$public_key."', `private_key` = '".$private_key."', `link_terms` = '".$link_terms."', `max_size` = '".$max_size."', `valid_ext` = '".$valid_ext."', `mime_types` = '".$mime_types."', `alerts_article` = '".$alerts_article."', `alert_det_article` = '".$alert_det_article."', `alerte_clienti` = '".$alerte_clienti."', `alerte_dealer` = '".$alerte_dealer."', `request_article` = '".$request_article."', `link_suport` = '".$link_suport."', `search_req_right_article` = '".$search_req_right_article."', `search_req_bottom_article` = '".$search_req_bottom_article."', `login_module2` = '".$login_module2."', `id_article_all` = '".$id_article_all."', `login_module3` = '".$login_module3."', `login_module4` = '".$login_module4."', `google_play` = '".$google_play."' WHERE `id` = '1'";
$db->setQuery($query);
$db->query();

//preluam tip anunt input
$query = "SELECT * FROM #__sa_tip_anunt";
$db->setQuery($query);
$tips = $db->loadObjectList();
foreach ($tips as $t) {
	$input = "article_id_".$t->id;
	$input =& JRequest::getVar( $input, '', 'post', 'string' );
	$query = "UPDATE #__sa_tip_anunt SET `article_id` = '".$input ."' WHERE `id` = '".$t->id."'"; 
	$db->setQuery($query);
	$db->query();
}
$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=config';
$app->redirect($redirect, 'Optiunile componentei au fost salvate cu succes');	
