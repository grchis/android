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
$url =& JRequest::getVar( 'url', '', 'post', 'string' );
$alert_id =& JRequest::getVar( 'alert_id', '', 'post', 'string' );
//echo 'url nou este '.$url.' si alert id '.$alert_id.'<br />';
//preluam lista de variabile
//verificam daca sunt selectate toate marcile/judetele
$v_categorii = 'cat_m_all_'.$alert_id;
$v_judete = 'cat_j_all_'.$alert_id;
//echo 'toate marcile >>> '.$v_categorii.'<br />';
//echo 'toate judetele >>> '.$v_judete.'<br />';
$categorii =& JRequest::getVar( $v_categorii, '', 'post', 'string' );
//echo 'variabila all categs = '.$categorii.'<br />';
$judete =& JRequest::getVar( $v_judete, '', 'post', 'string' );
//echo 'variabila all region = '.$judete.'<br />';

if ($categorii == 1) {
	//toate marcile
	$db_marci = 'all';
} else {
	$db_marci = '';
	//preluam marci distincte 
	$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1'";
	$db->setQuery($query);
	$marci = $db->loadObjectList();
	foreach ($marci as $m) {
		$v_marc = 'cat_m_'.$alert_id.'_'.$m->id;
		$marc =& JRequest::getVar( $v_marc, '', 'post', 'string' );
		if ($marc == 1) {
			//echo 'marca aleasa >>> '.$m->id.'<br />';
			$db_marci .= $m->id.',';
		}	
	}
}

if ($judete == 1) {
	//toate judetele
	$db_judete = 'all';
} else {
	$db_judete = '';
	//preluam judete distincte
	$query = "SELECT * FROM #__sa_judete";
	$db->setQuery($query);
	$juds = $db->loadObjectList();
	foreach ($juds as $j) {
		$v_jud = 'cat_j_'.$alert_id.'_'.$j->id;
		$jud =& JRequest::getVar( $v_jud, '', 'post', 'string' );
		if ($jud == 1) {
			//echo 'judet ales >>> '.$j->id.'<br />';
			$db_judete .= $j->id.',';
		}	
	}
	
}

//echo 'database marci: '.$db_marci.'<br />';
//echo 'database judete: '.$db_judete.'<br />';

$query = "INSERT INTO #__sa_alert_temp (`uid`, `alert_id`, `lista_marci`, `lista_judete`) VALUES ('".$uid."', '".$alert_id."', '".$db_marci."', '".$db_judete."')";
$db->setQuery($query);
$db->query();

//redirectionam.....
$app =& JFactory::getApplication();
$app->redirect($url);
