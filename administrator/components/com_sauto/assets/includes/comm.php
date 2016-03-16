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
$db = JFactory::getDbo();
$uid =& JRequest::getVar( 'uid', '', 'post', 'string' );
$tip_cont =& JRequest::getVar( 'tip_cont', '', 'post', 'string' );

if ($tip_cont == 0) {
	//client
	require("comm_client.php");
} elseif ($tip_cont == 1) {
	//dealer
	require("comm_dealer.php");
}
