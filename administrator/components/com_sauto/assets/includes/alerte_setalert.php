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

$type =& JRequest::getVar( 'type', '', 'get', 'string' );

switch($type) {
	case 'dealer':
	require("alerte_setalert_dealer.php");
	break;
	case 'customer':
	require("alerte_setalert_customer.php");
	break;
}
