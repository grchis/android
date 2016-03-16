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

$plata_pentru =& JRequest::getVar( 'plata_pentru', '', 'post', 'string' );
$procesator =& JRequest::getVar( 'procesator', '', 'post', 'string' );
//echo 'procesare prin '.$procesator.'<br />';
//echo 'platim pentru '.$plata_pentru.'<br />';

if ($procesator == 1) {
	//procesare prin OP
	if ($plata_pentru == 'abonament') {
		require("pay_op_abn.php");
	} elseif ($plata_pentru == 'puncte') {
		require("pay_op_credit.php");
	}
	//echo 'procesam cu op<br />';
} elseif ($procesator == 2) {
	//procesare cu cardul
	if ($plata_pentru == 'abonament') {
		require("pay_cc_abn.php");
	} elseif ($plata_pentru == 'puncte') {
		require("pay_cc_credit.php");
	}
	//echo 'cu cardul....<br />';
} elseif ($procesator == 3) {
	//procesam cu paypal
	if ($plata_pentru == 'abonament') {
		require("pay_pp_abn.php");
	} elseif ($plata_pentru == 'puncte') {
		require("pay_pp_credit.php");
	}
	//echo 'prin paypal....<br />';
}
?>

