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

$action =& JRequest::getVar( 'action', '', 'get', 'string' );

switch ($action) {
	case 'dealer':
	require("alerte_dealer.php");
	break;
	case 'customer':
	require("alerte_customer.php");
	break;
	case 'set_alert':
	require("alerte_setalert.php");
	break;
	case 'alert_edit':
	require("alerte_alert_edit.php");
	break;
	case 'alert_enable':
	require("alerte_alert_enable.php");
	break;
	case 'alert_save':
	require("alerte_alert_save.php");
	break;
	case 'zalert':
	require("alerte_zalert.php");
	break;
}
?>
