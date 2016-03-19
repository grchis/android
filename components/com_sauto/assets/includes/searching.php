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
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(strpos($useragent,'Mobile')){
require_once('/mobile/searching_mobile.php');
}else{
$document = JFactory::getDocument();
require("toggle_js.php");
$document->addScriptDeclaration ($js_code);


$db = JFactory::getDbo();
$firma =& JRequest::getVar( 'firma', '', 'post', 'string' );
$domeniu =& JRequest::getVar( 'domeniu', '', 'post', 'string' );
$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );
$abonament =& JRequest::getVar( 'abonament', '', 'post', 'string' );
//obtin jid
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$jid = $db->loadResult();

//echo 'abonament > '.$abonament.'<br />domeniu > '.$domeniu.'<br />judet id > '.$jid.'<br /> oras > '.$city.' <br />firma > '.$firma.'<hr /><br />';
if ($judet == '') {
	$search_jud = '';
	$search_jud2 = '';
} else {
	$search_jud = " AND `judet` = '".$jid."'";
	$search_jud2 = " AND `p`.`judet` = '".$jid."'";
}


if ($city == '') {
	$search_city = '';
	$search_city2 = '';
} else {
	$search_city = " AND `localitate` = '".$city."'";
	$search_city2 = " AND `p`.`localitate` = '".$city."'";
}

$search_dom = " AND `categorii_activitate` LIKE '%".$domeniu."%' ";
$search_dom2 = " AND `p`.`categorii_activitate` LIKE '%".$domeniu."%' ";
//$search_dom = '';

if ($firma == '') {
	$search_firma = " `companie` != '' ";
} else {
	$search_firma = " `companie` LIKE '%".$firma."%' ";
}

if ($abonament == '') {
	$search_abonament = '';
	$search_abonament2 = '';
	$search_abonament3 = " AND `p`.`abonament` = `ab`.`id`";
} else {
	$search_abonament = " AND `abonament` = '".$abonament."'";
	$search_abonament2 = " AND `p`.`abonament` = '".$abonament."' AND `p`.`abonament` = `ab`.`id`";
	$search_abonament3 = "";
}
//if ($firma == '') {
//		$query = "SELECT count(*) FROM #__sa_profiles WHERE `categorii_activitate` LIKE '%".$domeniu."%' ".$search_jud." ";
//} else {
	$query = "SELECT count(*) FROM #__sa_profiles WHERE ".$search_firma." ".$search_abonament." ".$search_jud." ".$search_dom." ".$search_city." ";
//}

//echo $query;
$db->setQuery($query);
//$db->execute();
$total = $db->loadResult();
//echo '<br />>>>>> '.$total;
$width = 'style="width:800px;"';

if ($total == 0) {
	//nu am gasit nimic
	?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
	<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<?php $link_search = JRoute::_('index.php?option=com_sauto&view=search'); ?>
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_SEARCH_DEALER').'<br /><a href="'.$link_search.'" class="sa_lk_profile">'.JText::_('SA_DEALER_SEARCH_NOW').'</a>'; ?>
		</div>
	</div>
	</div>
	<div style="clear:both;"></div>
</td>
		<td class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				$categ = '';
				echo showAds($pozitionare, $categ);
			echo '</div>';
			//echo '<div>'.$show_side_content.'</div>';	
		?>
		
			</div>
		</td>
	</tr>
</table>
	<?php
} else {
$total_rezult = $total;
//echo '<br />>>>> '.$total_rezult;
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$rezult_pagina = $sconfig->paginare;
//nr de pagini
$nr_pagini=ceil($total_rezult/$rezult_pagina); 

$page =& JRequest::getVar( 'page', '', 'get', 'string' );
if(isset($page) && is_numeric($page)){
    $pagina_curenta=(int)$page;
} else {
    $pagina_curenta=1;
}

if($pagina_curenta > $nr_pagini) {
    $pagina_curenta=$nr_pagini;
} elseif($pagina_curenta < 1) {
    $pagina_curenta=1;
}

$link = JRoute::_('index.php?option=com_sauto&view=search');

$interval=5;
 
if($pagina_curenta > (1+$interval)) {
	$paginare.='<a class="sa_page" href="'.$link.'&page=1">'.JText::_('SA_PRIMA_PAGINA').'</a>';
	$pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'">'.JText::_('SA_BACK_PAGE').'</a>';
} elseif (($pagina_curenta > 1) && ($pagina_curenta <= (1+$interval))) {
    $pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'">'.JText::_('SA_BACK_PAGE').'</a>';
}

for($x=($pagina_curenta - $interval); $x < (($pagina_curenta + $interval) + 1); $x++) {
    if(($x > 0) && ($x <= $nr_pagini)){  
      if($pagina_curenta != $x){
        $paginare.='<a class="sa_page" href="'.$link.'&page='.$x.'">'.$x.'</a>';
      } else {
        $paginare.='<a class="sa_page"><span class="sa_page_current">'.$x.'</span></a>'; 
      }
    }
}


if(($pagina_curenta != $nr_pagini) && ($pagina_curenta < ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">'.JText::_('SA_FORWARD_PAGE').'</a>';
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$nr_pagini.'">'.JText::_('SA_LAST_PAGE').'</a>';
} elseif (($pagina_curenta != $nr_pagini) && ($pagina_curenta >= ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">'.JText::_('SA_FORWARD_PAGE').'</a>';
}


$inceput=($pagina_curenta - 1) * $rezult_pagina;

	$query = "SELECT `p`.`uid`, `p`.`poza`, `p`.`companie`, `p`.`calificative`, `l`.`localitate`, `ab`.`abonament` FROM #__sa_profiles as `p` JOIN #__sa_localitati as `l` JOIN #__sa_abonament as `ab` ON `p`.`companie` LIKE '%".$firma."%' ".$search_abonament2." ".$search_jud2." AND `p`.`localitate` = `l`.`id` ".$search_abonament3." ".$search_dom2." ".$search_city2." ORDER BY `p`.`uid` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
//echo '>>> '.$query;
$db->setQuery($query);
$list = $db->loadObjectList();

//echo '<table class="gym_table" width="100%">';
//echo '<tr class="gym_row"><td class="gym_adm_head_2">'.JText::_('GYM_NR_CRT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_USERNAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_NAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_EMAIL').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ABOMAMENT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ACTIONS').'</td></tr>';
$i=1;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$image_path = JURI::base()."components/com_sauto/assets/users/";
$image = 'icon_profile.png';
$link_search = JRoute::_('index.php?option=com_sauto&view=searching');


?>
<table class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
<div class="sa_phone sa_add_comment sa_cursor sa_hover" onClick="toggle_visibility('search_form');">
<?php echo JText::_('SAUTO_SEARCH_DEALER'); ?>	
</div>

<div id="search_form" style="display:none;">
	<table class="sa_table_class">
		<form action="<?php echo $link_search; ?>" method="post" name="search_form" id="search_form">
		<tr class="sa_table_row">
			<td class="sa_table_cell">
				<?php echo JText::_('SAUTO_SEARCH_COMPANIE'); ?>
			</td>
			<td class="sa_table_cell"><input type="text" name="firma" value="<?php echo $firma; ?>" /></td>
		</tr>
		<tr class="sa_table_row">
			<td valign="top" class="sa_table_cell">
				<?php echo JText::_('SAUTO_SEARCH_DOMENIU_ACTIVITATE'); ?>
			</td>
			<td class="sa_table_cell">
				<select name="domeniu">
					<option value=""><?php echo JText::_('SAUTO_SELECT_ACTIVITATE'); ?></option>
				<?php
				$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
				$db->setQuery($query);
				$tip = $db->loadObjectList();
				foreach ($tip as $t) {
					if ($t->id != 6) {
						$dom_act = $t->id.'-1';
					echo '<option value="'.$dom_act.'"';
						if ($dom_act == $domeniu) { echo ' selected '; }
					echo '>'.$t->tip.'</option>';
					}
				}
				?>
				</select>
			</td>
		</tr>
		<tr class="sa_table_row">
			<td class="sa_table_cell">
				<?php echo JText::_('SAUTO_DISPLAY_JUDET'); ?>
			</td>
			<td class="sa_table_cell">
			<select name="judet">
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_judete";
			$db->setQuery($query);
			$judete = $db->loadObjectList();
			foreach ($judete as $j) {
				echo '<option id="'.$j->id.'"';
					if ($j->id == $jid) { echo ' selected '; }
				echo '>'.$j->judet.'</option>';
			}
			?>
			</select>
			</td>
		</tr>
		<tr class="sa_table_row">
			<td class="sa_table_cell">
				<?php echo JText::_('SAUTO_TIP_VANZATOR'); ?>
			</td>	
			<td class="sa_table_cell">
				<select name="abonament">
					<option value=""><?php echo JText::_('SAUTO_SELECT_ABONAMENT_TYPE'); ?></option>
				<?php
				$query = "SELECT * FROM #__sa_abonament";
				$db->setQuery($query);
				$abon = $db->loadObjectList();
				foreach ($abon as $ab) {
					echo '<option value="'.$ab->id.'"';
						if ($ab->id == $abonament) { echo ' selected '; }
					echo '>'.$ab->abonament.'</option>';
				}
				?>
				</select>
			</td>	
		</tr>
		</form>
		<tr class="sa_table_row">
			<td class="sa_table_cell"></td>
			<td class="sa_table_cell">
				<div class="sa_table_cell sa_phone sa_add_comment sa_cursor sa_hover" onClick="document.forms['search_form'].submit();">
				<span class="sa_oferte_span">
				<?php echo JText::_('SAUTO_SEARCH_BUTTON'); ?>
				</span>
				</div>
			</td>
		</tr>
	</table>
</div>


<div>
<h1><?php echo JText::_('SAUTO_BROWSE_DEALER_LIST'); ?></h1>
</div>	
<table width="100%"  class="sa_table_class" cellpadding="0"  cellspacing="0">
	<?php
	$i=1;
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
		$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->uid);
	?>
	<tr class="sa_table_row <?php echo $style; ?>">
		<td valign="top" class="sa_table_cell">
		<?php 
		if ($l->poza != '') {
				$poza = $image_path.$l->uid.DS.$l->poza;
				$alt = '';
			} else {
				$poza = $img_path.$image;
				$alt = '';
			}
		echo '<img src="'.$poza.'" alt="'.$alt.'" width="50" border="0" />';
		?>
		
		</td>
		<td valign="top" class="sa_table_cell">
			<?php
			echo '<div><a class="sa_public_profile" href="'.$link_profile.'">'.$l->companie.'<a class="sa_public_profile" href="'.$link_profile.'"></a></div>';
			?>
			<div style="display:inline;">
				<div style="float:left;">
				<?php echo JText::_('SAUTO_DISPLAY_CITY').': '.$l->localitate;
				?>
				</div>
				<div style="float:right;">
				<?php echo JText::_('SAUTO_CALIFICATIV_TITLE').': '.$l->calificative.'%'; ?>
				</div>
			</div>
			<div style="clear:both;"></div>
		</td>
		<td valign="top">
			<?php echo JText::_('SAUTO_TIP_VANZATOR').': '.$l->abonament; ?>
		</td>
	</tr>
	
	<?php 
	if ($i == 5) {	
				$style = 'sa-row0'; 
				echo '<tr class="sa_table_row '.$style.'">';
					echo '<td class="sa_table_cell" colspan="3">';
						//echo $rec->cod_reclama;	
						$pozitionare = 'c';
						$categ = '';
						echo showAds($pozitionare, $categ);
					echo '</td>';
				echo '</tr>';	
		}
	$i++;
	} ?>	
</table>
<br /><br />
<?php
if ($total > $rezult_pagina) {
	echo $paginare;
}
echo '<br /><br />';
}
?>
</td>
		<td class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				$categ = '';
				echo showAds($pozitionare, $categ);
			echo '</div>';
		?>
			</div>
		</td>
	</tr>
</table>
<?php } ?>
