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

$user =& JFactory::getUser();
$uid = $user->id;

$app =& JFactory::getApplication();
$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );
$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
$db->setQuery($query);
$marca = $db->loadResult();
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$an_fabricatie =& JRequest::getVar( 'an_fabricatie', '', 'post', 'string' );
$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
$nr_usi =& JRequest::getVar( 'nr_usi', '', 'post', 'string' );
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$serie_caroserie =& JRequest::getVar( 'serie_caroserie', '', 'post', 'string' );
$transmisie =& JRequest::getVar( 'transmisie', '', 'post', 'string' );

$exp_itp =& JRequest::getVar( 'exp_itp', '', 'post', 'string' );
$exp_rca =& JRequest::getVar( 'exp_rca', '', 'post', 'string' );
$exp_rvg =& JRequest::getVar( 'exp_rvg', '', 'post', 'string' );

$query = "UPDATE #__sa_garaj SET `marca` = '".$marca."', `model` = '".$model_auto."', `an_fabricatie` = '".$an_fabricatie."', `cilindree` = '".$cilindree."', `carburant` = '".$carburant."', 
`nr_usi` = '".$nr_usi."', `caroserie` = '".$caroserie."', `serie_caroserie` = '".$serie_caroserie."', `transmisie` = '".$transmisie."', `exp_itp` = '".$exp_itp."', `exp_rca` = '".$exp_rca."', 
`exp_rvg` = '".$exp_rvg."' WHERE `id` = '".$id."' AND `owner` = '".$uid."'";
$db->setQuery($query);
$db->query();
$link_redirect = JRoute::_('index.php?option=com_sauto&view=garaj');
$app->redirect($link_redirect, JText::_('SAUTO_SUCCESS_EDIT_PARKED_CAR'));
?>
