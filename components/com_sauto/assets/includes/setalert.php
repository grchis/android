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
$db = JFactory::getDbo();

$user =& JFactory::getUser();
$uid = $user->id;

//echo 'acu setez domenii de activitate.....<br />';
/*
$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
$db->setQuery($query);
$acts = $db->loadObjectList();
$new_act = '';
foreach ($acts as $a) {
	$var = 'act_'.$a->id;
	$value =& JRequest::getVar( $var, '', 'post', 'string' );
		if ($value != '') {
			$new_act .= $a->id.'-1,'; 
		}
}
*/
//$query = "SELECT * FROM #__sa_alert_temp WHERE `uid` = '".$uid."'";
$query = "SELECT count(*) FROM #__sa_tip_anunt WHERE `published` = '1'";
$db->setQuery($query);
$all = $db->loadResult();
$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
$db->setQuery($query);
$list = $db->loadObjectList();
$new_act = '';
$i=1;
foreach ($list as $l) {
	//echo $i.'>>>> '.$l->id.'<br />';
	//verificam daca este ceva setat
	$query = "SELECT count(*) FROM #__sa_alert_temp WHERE `alert_id` = '".$l->id."' AND `uid` = '".$uid."'";
	$db->setQuery($query);
	$total = $db->loadResult();
	//echo '>>>> '.$total.'<br />';
	if ($total == 1) {
		$new_act .= $l->id.'-1';
		if ($i<$all) { $new_act .= ','; }
	} 
	$i++;
}
//echo 'activitati noi '.$new_act.'<br />';
$query = "UPDATE #__sa_profiles SET `categorii_activitate` = '".$new_act."' WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$db->query();
//mutam alertele setate
$query = "SELECT * FROM #__sa_alert_temp WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$process = $db->loadObjectList();
foreach ($process as $p) {
	$query = "INSERT INTO #__sa_alert_details (`uid`, `alert_id`, `lista_marci`, `lista_judete`) VALUES ('".$uid."', '".$p->alert_id."', '".$p->lista_marci."', '".$p->lista_judete."')";
	$db->setQuery($query);
	$db->query();
	//echo $query.'<br /><br />';
}
$query = "DELETE FROM #__sa_alert_temp WHERE `uid` = '".$uid."'"; 
$db->setQuery($query);
$db->query();
	//redirectionare la prima pagina
	$app =& JFactory::getApplication();
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect, JText::_('SAUTO_ALERT_SET_SUCCESS'));
