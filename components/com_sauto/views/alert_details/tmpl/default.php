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
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');
?>

<div id="wrapper9">
<h1><?php echo $this->site_title; ?></h1>
	<div id="side_bar">
	<?php 
	$user =& JFactory::getUser();
	$uid = $user->id;
		if ($uid == 0) {
			//vizitator
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} else {
			//verificare tip utilizator
			$query= "SELECT `tip_cont`, `categorii_activitate` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$prf = $db->loadObject();
			if ($prf->tip_cont == 0) {
				//client
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			} elseif ($prf->tip_cont == 1) {
				//dealer
				require_once("components/com_sauto/assets/includes/menu_d.php");
			} else {
				//nedefinit, redirectionam la prima pagina
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			} 
		}
	?> 
	</div>
				
	<div id="content9">
		<?php
		//verificare tip utilizator
		//obtin domeniile de activitate
		//echo '>>>> '.$prf->categorii_activitate;
		$cats = explode(",", $prf->categorii_activitate);
		$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
		$db->setQuery($query);
		$tip = $db->loadObjectList();
		echo '<table class="sa_table_class" width="100%">';
			echo '<tr>';
				echo '<td class="sa_factura_header">'.JText::_('SAUTO_DEALER_DOMENIU_ACT').'</td>';
				echo '<td class="sa_factura_header">'.JText::_('SAUTO_MARCA').'</td>';
				echo '<td class="sa_factura_header">'.JText::_('SAUTO_DISPLAY_JUDET').'</td>';
				echo '<td class="sa_factura_header">'.JText::_('SAUTO_EDIT_REQUEST').'</td>';
			echo '</tr>';
		JHTML::_('behavior.tooltip');
		foreach ($tip as $t) {
			$valoare = $t->id.'-1';
			if (in_array($valoare, $cats)) {
				if ($style == ' sa-row1 ') { 
					$style = ' sa-row0 '; 
				} else { 
					$style = ' sa-row1 '; 
				}
				echo '<tr class="sa_table_row '.$style.'">';
				//obtinen restul de alerte
				$query = "SELECT `lista_marci`, `lista_judete` FROM #__sa_alert_details WHERE `uid` = '".$uid."' AND `alert_id` = '".$t->id."'";
				$db->setQuery($query);
				//echo $query;
				$alert = $db->loadObject();
				//print_r($alert);
				//echo '>>>>> '.$t->tip.'<br />';
				//echo '>>>> '.$alert->lista_marci.' >>>> '.$alert->lista_judete.'<br />';
				echo '<td class="sa_table_cell">'.$t->tip.'</td>';
				echo '<td class="sa_table_cell">';
					if ($alert->lista_marci == 'all') {
						echo JText::_('SAUTO_TOATE_MARCILE');
					} elseif ($alert->lista_marci == '') {
						echo '';
					} else {
						$l_marci = '';
						//obtin lista marcilor
						$arr = explode(",", $alert->lista_marci);
						$elem = (count($arr)) - 1;
						$query = "SELECT * FROM #__sa_marca_auto";
						$db->setQuery($query);
						$marci = $db->loadObjectList();
						$i = 1;
						foreach ($marci as $m) {
							if (in_array($m->id, $arr)) {
								$l_marci .= $m->marca_auto;
								if ($i < $elem) { $l_marci .= ', '; }
								$i++;
							}
						}
						echo '<a href="#">'.JHTML::tooltip($l_marci, JText::_('SAUTO_MARCI_AUTO_SELECTATE'), '', JText::_('SAUTO_VEZI_MARCILE')).'</a>';
					}
				echo '</td>';
				echo '<td class="sa_table_cell">';
					if ($alert->lista_judete == 'all') {
						echo JText::_('SAUTO_TOATE_JUDETELE');
					} else {
						$l_judete = '';
						//obtin lista judetelor
						$arr = explode(",", $alert->lista_judete);
						$elem = (count($arr)) - 1;
						$query = "SELECT * FROM #__sa_judete";
						$db->setQuery($query);
						$judet = $db->loadObjectList();
						$i = 1;
						foreach ($judet as $j) {
							if (in_array($j->id, $arr)) {
								$l_judete .= $j->judet;
								if ($i < $elem) { $l_judete .= ', '; }
								$i++;
							}
						}
						echo '<a href="#">'.JHTML::tooltip($l_judete, JText::_('SAUTO_JUDETE_SELECTATE'), '', JText::_('SAUTO_VEZI_JUDETELE')).'</a>';
					}
				echo '</td>';
				echo '<td class="sa_table_cell">';
					$link_editare = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_edit&id='.$t->id);
					echo '<a href="'.$link_editare.'">'.JText::_('SAUTO_EDIT_REQUEST').'</a>';
				echo '</td>';
				echo '</tr>';
				//echo '<tr class="sa_table_row '.$style.'">';
				//echo '<td class="sa_table_cell" colspan="4">';
				//	echo 'input...';
				//echo '</td>';
				//echo '</tr>';
			}	
		}
		echo '<tr>';
		echo '<td colspan="4">';
		echo '<form action="" method="post">';
			echo '<div>';
				echo '<input type="radio" name="alerta" value="0" /> '.JText::_('SAUTO_ALERTA_DEZACTIVATA');
			echo '</div>';
			echo '<div>';
				echo '<input type="radio" name="alerta" value="1" /> '.JText::_('SAUTO_ALERTA_FIECARE_ANUNT');
			echo '</div>';
			echo '<div>';
				echo '<input type="radio" name="alerta" value="2" /> '.JText::_('SAUTO_ALERTA_50_ANUNT');
			echo '</div>';
			echo '<div>';
				echo '<input type="radio" name="alerta" value="3" /> '.JText::_('SAUTO_ALERTA_ZILNICA');
			echo '</div>';
			echo '<div>';
				echo '<input type="submit" value="'.JText::_('SAUTO_SETEAZA_ALERTA').'" />';
			echo '</div>';
		echo '</form>';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		?> 						
	</div>
				
					
</div>


