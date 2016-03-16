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
$db = JFactory::getDbo();
switch ($action) {
	case '':
	default:
	?>
	<h3>Adauga promotii pentru firme</h3>
	<h4>Acorda abonamente Kerosen promotionale pentru toate firmele fara abonamente platite</h4>
	<?php
	//get actual date
	$time = time();
	$thisDate = date('Y-m-d', $time);
	$query = "SELECT count(*) FROM #__sa_promotii WHERE `start` <= '".$thisDate."' AND `stop` >= '".$thisDate."'";
	$db->setQuery($query);
	$count = $db->loadResult();
	$link_list = 'index.php?option=com_sauto&task=promo&action=list';
	$lista = ' <a href="'.$link_list.'">Lista promotii</a>';
	if ($count != 0) {
		if ($count == 1) {
			echo '<div>Aveti setata deja o promotie pentru acest interval de timp! '.$lista.'</div>';
		} else {
			echo '<div>Aveti setate '.$count.' promotii pentru acest interval de timp! '.$lista.'</div>';
		}
		
	} else {
		echo '<div>'.$lista.'</div>';
	}
	echo '<hr />';
	?>
	<form action="index.php?option=com_sauto&task=promo&action=save" method="post">
	<table>
		<tr>
			<td>Data de start a promotiei</td>
			<td>
<?php 
echo JHTML::_('calendar', '', 'data_start_promo', 'data_start_promo', '%Y-%m-%d', 
	array('class' => 'inputbox validate-date ')); 
?>	
			</td>
		</tr>
		<tr>
			<td>Data de incheiere a promotiei</td>
			<td>
<?php 
echo JHTML::_('calendar', '', 'data_stop_promo', 'data_stop_promo', '%Y-%m-%d', 
	array('class' => 'inputbox validate-date ')); 
?>	
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
<input type="submit" value="Adauga promotie" />
			</td>
		</tr>
	</table>
	</form>
	<?php
	break;
	case 'list':
	require("promo_list.php");
	break;
	case 'save':
	$data_start =& JRequest::getVar( 'data_start_promo', '', 'post', 'string' );
	$data_stop =& JRequest::getVar( 'data_stop_promo', '', 'post', 'string' );
	
	//adaugam in baza de date
	$query = "INSERT INTO #__sa_promotii (`start`, `stop`) VALUES ('".$data_start."', '".$data_stop."')";
	$db->setQuery($query);
	$db->query();
	//echo 'acu adaug....'.$data_start_promo.' >>> '.$data_stop_promo;
	$app =& JFactory::getApplication();
	$link_redirect = 'index.php?option=com_sauto&task=promo';
	$app->redirect($link_redirect, 'Promotia a fost alocata cu succes');
	break;
}
