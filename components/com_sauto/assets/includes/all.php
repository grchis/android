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
require_once('/mobile/all_mobile.php');
}else{
$id =& JRequest::getVar( 'id', '', 'get', 'string' );


//start script
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$id."'";
$db->setQuery($query);
$total = $db->loadResult();
$width = 'style="width:800px;"';
//echo $query;
if ($total == 0) {
	//nu ai anunturi
	$link_home = JRoute::_('index.php?option=com_sauto');
	?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
	<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_ALL_REQUESTS_OF_CUSTOMER'); ?>
		<br />
		<a href="<?php echo $link_home; ?>"><?php echo JText::_('SA_GO_HOME_LINK'); ?></a>
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
################################################
$total_rezult = $total;
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

$link = JRoute::_('index.php?option=com_sauto&view=requests');

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

$query = "SELECT * FROM #__sa_anunturi WHERE `proprietar` = '".$id."' ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();


$image_path = JURI::base()."components/com_sauto/assets/users/";

//verificam nivelul de acces
$query = "SELECT `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$types = $db->loadResult();
$view_phone = 0;
	//verificam abonamentul
	if ($types == 3) {
		$view_phone = 1;
	}

	 
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
<div style="display:inline;">
	<div style="float:left;">
<table <?php echo $width; ?> class="sa_table_class">
	<?php
	$i=1;
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
		$image = 'anunt_type_'.$l->tip_anunt.'.png';
		$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td width="15%" valign="top" class="sa_table_cell"><center>';
			echo '<div><a href="'.$link_categ.'" class="sa_lk_profile">'.JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt).'</a></div>';
			//verificare poze
			$query = "SELECT `poza`,`alt` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."'";
			$db->setQuery($query);
			$pics = $db->loadObject();
			if ($pics->poza != '') {
				$poza = $image_path.$l->proprietar."/".$pics->poza;
				$alt = $pics->alt;
			} else {
				$poza = $img_path.$image;
				$alt = '';
			}
			echo '<div><a href="'.$link_categ.'" class="sa_lk_profile"><img src="'.$poza.'" alt="'.$alt.'" width="80" border="0" /></a></div>';

			echo '</center></td>';
			echo '<td width="45%" valign="top" class="sa_table_cell">';
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
			$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=delete&id='.$l->id);
			echo '<div class="sa_request_title"><a href="'.$link_anunt.'" class="sa_link_request">'.$l->titlu_anunt.'</a></div>';
			$data_add = explode(" ",$l->data_adaugarii);
			echo '<div>'.JText::_('SAUTO_SHOW_DATE').' '.$data_add[0].'</div>';
			echo '<div>'.substr(strip_tags($l->anunt), 0, 50).' ...</div>';
			//substr(strip_tags($l->$def_desc), 0, 50)
			if ($l->marca_auto != 0) {
				echo '<div style="display:inline;">';
				//obtin marca si modelul
				$query = "SELECT `marca_auto`, `published` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
				$db->setQuery($query);
				$marca = $db->loadObject();
				$query = "SELECT `model_auto`, `published` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
				$db->setQuery($query);
				$model = $db->loadObject();
				//print_r($model);
					echo '<div style="position:relative;float:left;">'.JText::_('SAUTO_SHOW_MARCA').' ';
						if ($marca->published == 1) {
							echo $marca->marca_auto;
						} else {
							echo JText::_('SAUTO_MARCA_NEPUBLICATA');
						}
					echo '</div>';
					echo '<div style="position:relative;float:right;">'.JText::_('SAUTO_SHOW_MODEL').' ';
						if ($model->published == 1) {
							echo $model->model_auto;
						} else {
							echo JText::_('SAUTO_MODEL_NEPUBLICAT');
						}
					echo '</div>';
				echo '</div><div style="clear:both;"></div>';
			}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell">';
			$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet`, `p`.`abonament` FROM #__sa_profiles as `p` JOIN #__sa_judete as `j` ON `p`.`uid` = '".$l->proprietar."' AND `p`.`judet` = `j`.`id`";
			$db->setQuery($query);
			//echo $query;
			$userd = $db->loadObject();
			//print_r($userd);
			$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
			echo '<div class="sa_request_title"><a href="'.$link_profile.'" class="sa_link_request">'.$userd->fullname.'</a></div>';
			echo '<div>'.JText::_('SAUTO_DISPLAY_JUDET').': '.$userd->judet.'</div>';
			
			echo '<div class="sa_table_cell sa_phone sa_phone_oferte">';
			echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />';
			echo '<span class="sa_phone_span">';
				//afisam telefonul
				if ($view_phone == 0) {
					echo JText::_('SAUTO_TELEFON_ASCUNS');
				} else {
					echo $userd->telefon;
				}
								
			echo '</span>';
			echo '</div>';
			echo '<br />';
			echo '<div class="sa_table_cell sa_phone sa_phone_oferte sa_padding">';
			echo '<span class="sa_oferte_span">';
				$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `proprietar` = '".$l->proprietar."' AND `anunt_id` = '".$l->id."'";
				$db->setQuery($query);
				$oferte = $db->loadResult();
				if ($oferte == 1) {
					echo JText::_('SAUTO_O_OFERTA');
				} elseif ($oferte == 0) {
					echo JText::_('SAUTO_FARA_OFERTE');
				} else {
					echo $oferte.' '.JText::_('SAUTO_NR_OFERTE');
				}
			echo '</span>';
			echo '</div>';
			echo '</td>';
		echo '</tr>';
		//echo '<tr class="sa_table_row"><td colspan="3" height="10" class="sa_table_cell"><hr /></td></tr>';
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
	}
	?>
</table>
	</div>
	<div style="float:right;" class="sa_allrequest_r">
	<?php
	//incarcam module in functie de pagina accesata
	echo '<div>'.$show_side_content.'</div>';	
	?>

	<?php
	echo '<div>'.$show_side_reclama.'</div>';	
	?>
	</div>
</div>
<div style="clear:both;"></div>
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
<?php 
}
?>
