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
$app =& JFactory::getApplication();
$db = JFactory::getDbo();
$uid =& JRequest::getVar( 'uid', '', 'get', 'string' );

$link_redirect = 'index.php?option=com_sauto&task=alerte&action=dealer&uid='.$uid;
$alert_id =& JRequest::getVar( 'alert_id', '', 'post', 'string' );
$alert_type =& JRequest::getVar( 'alert_type', '', 'post', 'string' );


$nou =& JRequest::getVar( 'nou', '', 'post', 'string' );
$sh =& JRequest::getVar( 'sh', '', 'post', 'string' );


$v_categorii = 'cat_m_all_'.$alert_id;
$v_judete = 'cat_j_all_'.$alert_id;

$categorii =& JRequest::getVar( $v_categorii, '', 'post', 'string' );
$judete =& JRequest::getVar( $v_judete, '', 'post', 'string' );

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

if ($alert_type == 'enable') {
	//echo '>>>> '.$db_marci.'<br />';
	//echo '>>>> '.$db_judete.'<br />';
	//verific daca sunt alte categorii de activitate
	$query = "SELECT `categorii_activitate` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$cats = $db->loadResult();
	if ($cats == '') {
		$db_cats = $alert_id.'-1,';
	} else {
		$db_cats = $cats.$alert_id.'-1,';
	}
	//echo '>>>> '.$db_cats.'<br />';
	$query ="UPDATE #__sa_profiles SET `categorii_activitate` = '".$db_cats."' WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$db->query(); 
	//inseram detaliile alertelor
	$query = "INSERT INTO #__sa_alert_details (`uid`, `alert_id`, `lista_marci`, `lista_judete`, `nou`, `sh`) 
			VALUES ('".$uid."', '".$alert_id."', '".$db_marci."', '".$db_judete."', '".$nou."', '".$sh."')";
	$db->setQuery($query);
	$db->query(); 
	//redirectionam
	
	$app->redirect($link_redirect, JText::_('SAUTO_DOMENIU_ACT_SET_SUCCESS'));
} elseif ($alert_type == 'edit') {
	$query = "UPDATE #__sa_alert_details 
		SET `lista_marci` = '".$db_marci."', 
			`lista_judete` = '".$db_judete."', 
			`nou` = '".$nou."', 
			`sh` = '".$sh."' 
			WHERE `uid` = '".$uid."' AND `alert_id` = '".$alert_id."'";
	$db->setQuery($query);
	$db->query();
	$app->redirect($link_redirect, JText::_('SAUTO_DOMENIU_ACT_EDIT_SUCCESS'));
} elseif ($alert_type == 'delete') {
	$delete =& JRequest::getVar( 'delete', '', 'post', 'string' );
	if ($delete != 1) {
		$link_redirect2 = 'index.php?option=com_sauto&task=alerte&action=alert_edit&uid='. $uid.'&id='.$alert_id;
		$app->redirect($link_redirect2, JText::_('SAUTO_DOMENIU_ACT_NOT_DELETED'));
	} else {
		//eliminam din detalii
		$query = "DELETE FROM #__sa_alert_details WHERE `uid` = '".$uid."' AND `alert_id` = '".$alert_id."'";
		$db->setQuery($query);
		$db->query();
		//eliminam din profil
		//obtin lista curenta
		$query = "SELECT `categorii_activitate` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$categs = $db->loadResult();
		$value = $alert_id.'-1';
		$array = explode(",", $categs);
			if (($key = array_search($value, $array)) !== false) {
				unset($array[$key]);
			}
			$db_categ = '';
		foreach ($array as $value) {
			if ($value != '') {
				$db_categ .= $value.',';
			}
		}
		$query = "UPDATE #__sa_profiles SET `categorii_activitate` = '".$db_categ."' WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$db->query();
		//echo $query;
		$app->redirect($link_redirect, JText::_('SAUTO_DOMENIU_ACT_DELETED'));
	}
}

?>

