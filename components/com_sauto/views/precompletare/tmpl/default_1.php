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
$garaj =& JRequest::getVar( 'garaj', '', 'post', 'string' );
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
		
//obtin datele 
$query = "SELECT * FROM #__sa_garaj WHERE `owner` = '".$uid."' AND `id` = '".$garaj."'";
$db->setQuery($query);
$list = $db->loadObject();

$app =& JFactory::getApplication();

$app->setUserState('request', '1');


$app->setUserState('marca', $list->marca);
$app->setUserState('model_auto', $list->model);
$app->setUserState('an_fabricatie', $list->an_fabricatie);
$app->setUserState('cilindree', $list->cilindree);
$app->setUserState('carburant', $list->carburant);
$app->setUserState('nr_usi', $list->nr_usi);
$app->setUserState('caroserie', $list->caroserie);
$app->setUserState('serie_caroserie', $list->serie_caroserie);
$app->setUserState('precompletat', '1'); 

$link_redirect_f = JRoute::_('index.php?option=com_sauto&view=add_request2');
$app->redirect($link_redirect_f, JText::_('SAUTO_ANUNT_PRECOMPLETAT'));
?>

