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

$model =& JRequest::getVar( 'model', '', 'post', 'string' );
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );

$db = JFactory::getDbo();
$query = "INSERT INTO #__sa_model_auto (`mid`, `model_auto`, `published`) VALUES ('".$marca."', '".$model."', '1')";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=marci';
$app->redirect($redirect, 'Model auto adaugat cu succes');	
