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
//obtin id anunt
$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$db = JFactory::getDbo();

$query = "SELECT `tip_anunt` FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$tip = $db->loadResult();

switch ($tip) {
	case '1':
	require("save_anunt_1.php");
	break;
	case '2':
	require("save_anunt_2.php");
	break;
	case '3':
	require("save_anunt_3.php");
	break;
	case '4':
	require("save_anunt_4.php");
	break;
	case '5':
	break;
	case '6':
	require("save_anunt_6.php");
	break;
	case '7':
	break;
	case '8':
	require("save_anunt_8.php");
	break;
	case '9':
	require("save_anunt_9.php");
	break;
}
?>

