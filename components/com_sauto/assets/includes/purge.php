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
$link_redirect = JRoute::_('index.php?option=com_sauto');

$app->setUserState('titlu_anunt', '');
$app->setUserState('an_fabricatie', '');
$app->setUserState('cilindree', '');
$app->setUserState('carburant', '');
$app->setUserState('marca', '');
$app->setUserState('nr_usi', '');
$app->setUserState('caroserie', '');
$app->setUserState('serie_caroserie', '');
$app->setUserState('stare', '');
$app->setUserState('anunt1', '');
$app->setUserState('model_auto', '');
$app->setUserState('new_model', '');
$app->setUserState('model_auto', '');
$app->setUserState('request', '');

$app->setUserState('city', '');
$app->setUserState('anunt2', '');
$app->setUserState('judet', '');

$app->setUserState('anunt3', '');

$app->setUserState('anunt4', '');

$app->setUserState('anunt5', '');

$app->setUserState('anunt8', '');

$app->setUserState('anunt9', '');
$app->setUserState('anunt', '');

$app->setUserState('buget_min', '');
$app->setUserState('buget_max', '');
$app->setUserState('buget_moneda', '');

$app->setUserState('precompletat', '');	
$app->setUserState('transmisie', '');	
$link_redirect = JRoute::_('index.php?option=com_sauto&view=add_request');
$app->redirect($link_redirect);	
