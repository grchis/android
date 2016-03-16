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
$user = JFactory::getUser();
$uid = $user->id;
$app = JFactory::getApplication();
$app->logout( $uid );
$link_redirect = JRoute::_('index.php?option=com_sauto');
$app->redirect($link_redirect);
?>

