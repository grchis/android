<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
//defined('_JEXEC') || die('=;)');
/*echo '>>>> 1';
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
$path_b = $_SERVER[ 'DOCUMENT_ROOT' ].'/final';
define( 'JPATH_BASE', $path_b );
echo '<br />'.JPATH_BASE;

require_once( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
require_once( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
require_once( JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php' );

$mainframe =& JFactory::getApplication('site');

$app =& JFactory::getApplication();
$jinput = JFactory::getApplication()->input;
$cf = $jinput->get('cod_fiscal','','');

//$cf =& JRequest::getVar( 'cod_fiscal', '', 'post', 'string' );
$app->setUserState('cod_fiscal', $cf);

$result = simplexml_load_file('http://openapi.ro/api/companies/'.$cf.'.xml');
$g_firma = $result->name;
$app->setUserState('company_name', $g_firma);
$g_adresa  = $result->address;
$app->setUserState('sediu', $g_adresa);
$g_city = $result->city;
$app->setUserState('city', $g_city);
$g_phone = $result->phone;
$app->setUserState('phone', $g_phone);
$var = 'registration-id';
$g_reg = $result->$var;
$app->setUserState('nr_reg', $g_reg);
$g_region = $result->state;
$app->setUserState('judet', $g_region);
$g_zip = $result->zip;
$app->setUserState('cp', $g_zip);
echo '>>>>';
$link_redirect = JRoute::_('index.php?option=com_sauto&view=register_dealer');
$app->redirect($link_redirect); 
?>

