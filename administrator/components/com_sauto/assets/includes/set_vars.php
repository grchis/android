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
$app =& JFactory::getApplication();

$type =& JRequest::getVar( 'type', '', 'post', 'string' );


if ($type == 'anunt') {
$string =& JRequest::getVar( 'string', '', 'post', 'string' );
$app->setUserState('filtrat', '1');
$app->setUserState('string', $string);

$link_redirect = 'index.php?option=com_sauto&task=anunturi';

} elseif ($type == 'user') {
$v_nume =& JRequest::getVar( 'v_nume', '', 'post', 'string' );
$v_email =& JRequest::getVar( 'v_email', '', 'post', 'string' );
$v_telefon =& JRequest::getVar( 'v_telefon', '', 'post', 'string' );
$app->setUserState('filtrat', '1');
$app->setUserState('v_nume', $v_nume);
$app->setUserState('v_email', $v_email);
$app->setUserState('v_telefon', $v_telefon);

$link_redirect = 'index.php?option=com_sauto&task=users';
} elseif ($type == 'dealer') {
$v_nume =& JRequest::getVar( 'v_nume', '', 'post', 'string' );
$v_firma =& JRequest::getVar( 'v_firma', '', 'post', 'string' );
$v_email =& JRequest::getVar( 'v_email', '', 'post', 'string' );
$v_telefon =& JRequest::getVar( 'v_telefon', '', 'post', 'string' );
$abonament =& JRequest::getVar( 'abonament', '', 'post', 'string' );
$app->setUserState('filtrat', '1');
$app->setUserState('v_nume', $v_nume);
$app->setUserState('v_firma', $v_firma);
$app->setUserState('v_email', $v_email);
$app->setUserState('v_telefon', $v_telefon);
$app->setUserState('abonament', $abonament);

$link_redirect = 'index.php?option=com_sauto&task=dealers';
}
//echo 'aaaaa';
$app->redirect($link_redirect);
