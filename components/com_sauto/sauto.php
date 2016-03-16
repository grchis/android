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
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

//JHTML::_('behavior.mootools');
$document = '';
$document = JFactory::getDocument();
$document->addStyleSheet( 'components/com_sauto/assets/style.css' );

//
$app = JFactory::getApplication();
$sa_data_set = $app->getUserState('sa_data_set');
$db = JFactory::getDbo();
$user = JFactory::getUser();
$uid = $user->id;

if ($uid != 0) {
	$query = "SELECT `data_0`, `tip_cont`, `categorii_activitate`, `alerte` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$rezult = $db->loadObject();
	
	if ($sa_data_set != 1) { 
		$last_visit = $user->lastvisitDate;
		//obtin data_0
		
		$data_0 = $rezult->data_0;
		//actualizare data
		$query = "UPDATE #__sa_profiles SET `data_1` = '".$data_0."', `data_0` = '".$last_visit."' WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$db->query();
		$app->setUserState('sa_data_set', '1');
	}
	
	//verificam tipul de cont
	if ($rezult->tip_cont == 1) {
		//verificam daca sunt adaugate categoriile
		if ($rezult->categorii_activitate == '') {
			//$view =& JRequest::getVar( 'view', '', 'get', 'string' );
			//if ($view != 'setalert') {
			//$type = 'd';
			//$path_popup = JPATH_COMPONENT.DS.'assets'.DS.'popup.php';
			//require($path_popup);
			//}
			//redirectionam spre pagina de setare a categoriilor de activitate
			$permit = 0;
			$view =& JRequest::getVar( 'view', '', 'get', 'string' );
			$task =& JRequest::getVar( 'task', '', 'get', 'string' );
			//echo '>>> '.$permit;
			if ($view == 'edit_profile') {
				if ($task == 'alert_enable') {
					$permit = 1;
				} elseif ($task == 'alert_save') {
					$permit = 1;
				}				
			}
			if ($view == 'alerts') {
				$permit = 1;
			}
			if ($permit == 0) {
				$link_redirect = JRoute::_('index.php?option=com_sauto&view=alerts');
				$app->redirect($link_redirect);
			}
		}
	}
} 
//
 
	if ($uid != 0) {
		$feedback_ok = $app->getUserState('feedback_ok');
		if ($feedback_ok != 1) {
			echo verficFeedback($uid);
		}
	} 
require_once JPATH_COMPONENT.DS.'controller.php';
$controller = JFactory::getApplication()->input->get('controller');

if($controller)
{
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';

    if(file_exists($path))
    {
        require_once $path;
    }
    else
    {
        $controller = '';
    }
}

//-- Create the controller
$classname = 'sautoController'.$controller;
$controller = new $classname;

//-- Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

//-- Redirect if set by the controller
$controller->redirect();

function showAds($pozitionare, $categorie) {
	$content  = '';
	$db = JFactory::getDbo();
	if ($pozitionare == 'l') {
		$total = totalAds($pozitionare, $categorie);
	} elseif ($pozitionare == 'c') {
		$total = totalAds($pozitionare, $categorie);
		if ($total > 1) { $total = 1; }
	}
	if ($total >= 3) {
		$total = 3;
		$query = "SELECT * FROM #__sa_reclame WHERE `pozitionare` = '".$pozitionare."' AND `lista` = '".$categorie."' AND `published` = '1' AND `maxim_afisari` > `afisari_curente` ORDER BY rand() LIMIT ".$total." ";
		$rest = 0;
	} elseif ($total == 2) {
		$query = "SELECT * FROM #__sa_reclame WHERE `pozitionare` = '".$pozitionare."' AND `lista` = '".$categorie."' AND `published` = '1' AND `maxim_afisari` > `afisari_curente` ORDER BY rand() LIMIT ".$total." ";
		$rest = 1;
	} elseif ($total == 1) {
		$query = "SELECT * FROM #__sa_reclame WHERE `pozitionare` = '".$pozitionare."' AND `lista` = '".$categorie."' AND `published` = '1' AND `maxim_afisari` > `afisari_curente` ORDER BY rand() LIMIT ".$total." ";
		if ($pozitionare == 'l') {
			$rest = 2;
		} elseif ($pozitionare == 'c') {
			$rest = 0;
		}
	} else {
		if ($pozitionare == 'l') {
			$rest = 3;
		} elseif ($pozitionare == 'c') {
			$rest = 1;
		}
	}if ($total != 0) {
	$db->setQuery($query);
	$recls = $db->loadObjectList(); 
	foreach ($recls as $r) {
		$content .= '<div>';
		$content .= $r->cod_reclama;	
		$content .= '</div>';
		if ($r->necontorizat == 0) {
			$new_afisari2 = $r->afisari_curente + 1;
			$query = "UPDATE #__sa_reclame SET `afisari_curente` = '".$new_afisari2."' WHERE `id` = '".$r->id."'";
			$db->setQuery($query);
			$db->query();
		}
	}
	if ($rest != 0) {
		$query = "SELECT * FROM #__sa_reclame WHERE `pozitionare` = '".$pozitionare."' AND `lista` = '0' AND `published` = '1' AND `maxim_afisari` > `afisari_curente` ORDER BY rand() LIMIT ".$rest." ";
		$db->setQuery($query);
		$recls = $db->loadObjectList(); 
		foreach ($recls as $r) {
			$content .= '<div>';
			$content .= $r->cod_reclama;	
			$content .= '</div>';

			if ($r->necontorizat == 0) {
				$new_afisari2 = $r->afisari_curente + 1;
				$query = "UPDATE #__sa_reclame SET `afisari_curente` = '".$new_afisari2."' WHERE `id` = '".$r->id."'";
				$db->setQuery($query);
				$db->query();
			}
		}
	}}
	return $content;
}

function totalAds ($pozitionare, $categorie) {
	$db = JFactory::getDbo();
	if (($categorie == 0) OR ($categorie == '')) {
		$query = "SELECT count(*) FROM #__sa_reclame WHERE `pozitionare` = '".$pozitionare."' AND `published` = '1' AND `maxim_afisari` > `afisari_curente`";
	} else {
		$query = "SELECT count(*) FROM #__sa_reclame WHERE `pozitionare` = '".$pozitionare."' AND `lista` = '".$categorie."' AND `published` = '1' AND `maxim_afisari` > `afisari_curente`";
	}
	$db->setQuery($query);
	$total = $db->loadResult();
	return $total;
}

function verficFeedback($uid) {
	//$rezult = 'verific daca am calificative de acordat';
	//obtin tipul de utilizator
	$db = JFactory::getDbo();
	$query = "SELECT `fullname`, `reprezentant`, `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$conts = $db->loadObject();
	if ($conts->tip_cont == 0) {
		//client
		$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$uid."'  AND `is_winner` = '1'";
		$nume = $conts->fullname;
	} else {
		//firma 
		$query = "SELECT count(*) FROM #__sa_anunturi WHERE `uid_winner` = '".$uid."'";
		$nume = $conts->reprezentant;
	}
	$db->setQuery($query);
	$feeds1 = $db->loadResult();
	$query = "SELECT count(*) FROM #__sa_calificativ WHERE `poster_id` = '".$uid."'";
	$db->setQuery($query);
	$feeds2 = $db->loadResult();
	$total = $feeds1-$feeds2;
	//$rezult = '>>>> 1 > '.$feeds1.' si 2 > '.$feeds2;
	if ($total != 0) {
$rezult .= '<div id="light" class="white_content">';
	$rezult .= '<span style="text-indent:20px;">';
		$rezult .= JText::sprintf('SAUTO_SALUT_POPUP', $nume);
	$rezult .= '</span>.<br /><br />';
	$rezult .= JText::sprintf('SAUTO_MESAJ_POPUP', $total); 
	$rezult .= '<br /><br /><br /><br /><br />';
	$add_feedback = JRoute::_('index.php?option=com_sauto&view=final_request');
	$rezult .= '<a href="'.$add_feedback.'" class="sa_add_new_request"  />';
		$rezult .= JText::_('SAUTO_OFER_FEEDBACK_POPUP');
	$rezult .= '</a> ';
	//$rezult .= '<form method="post" action="'.$add_feedback.'">';
		//$rezult .= '<input type="submit" value="'.JText::_('SAUTO_OFER_FEEDBACK_POPUP').'" />';
	//$rezult .= '</form>';
	$rezult .= '<span style="position:relative;top:-1px;">';
		$rezult .= ' '.JText::_('SAUTO_OR').' ';
		$rezult .= ' <a href="javascript:void(0)" onclick="document.getElementById(\'light\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'">';
			$rezult .= JText::_('SAUTO_INCHIDE_POPUP');
		$rezult .= '</a>';
	$rezult .= '</span>';
	$rezult .= '</div>';
    $rezult .= '<div id="fade" class="black_overlay"></div>';

		//$rezult .= 'Salut. Iti reamintim ca mai ai de oferit '.$total.' calificative!';
		$app =& JFactory::getApplication();
		$app->setUserState('feedback_ok', '1');
	} else {
		$rezult = '';
	}
	return $rezult;
}