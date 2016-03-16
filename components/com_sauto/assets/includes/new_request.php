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
$step =& JRequest::getVar( 'step', '', 'get', 'string' );
switch ($step) {
	case '1':
	default:
	require("new_request_1.php");
	break;
	case '2':
	require("new_request_2.php");
	break;
	case '3':
	require("new_request_3.php");
	break;
}
?>

