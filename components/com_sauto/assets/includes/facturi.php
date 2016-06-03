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
require_once('/mobile/facturi_mobile.php');
}else{
$document = JFactory::getDocument();
require("toggle_js.php");
$document->addScriptDeclaration ($js_code);

$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."' ";
$db->setQuery($query);
//$db->execute();
$total = $db->loadResult();
$width = 'style="width:800px;"';
if ($total == 0) {
	//nu ai anunturi
	?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
	<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<?php $link_add = JRoute::_('index.php?option=com_sauto&view=edit_profile&type=fn'); ?>
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_PAYMENTS').'<br /><a href="'.$link_add.'" class="sa_lk_profile">'.JText::_('SA_DEALER_ADD_NEW_PAYMENT').'</a>'; ?>
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
//echo '>>>> '.$total;
$total_rezult = $total;
$rezult_pagina = '30';
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

$link = JRoute::_('index.php?option=com_sauto&view=facturi');

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

$query = "SELECT `f`.*, `t`.`new_upload` FROM #__sa_facturi AS `f` JOIN #__sa_tranzactii AS `t` ON `f`.`uid` = '".$uid."' AND `f`.`id` = `t`.`tranz_id` ORDER BY `f`.`id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";

$db->setQuery($query);
$list = $db->loadObjectList();

$i=1;	
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
<table width="100%" class="sa_table_class" cellpadding="0"  cellspacing="0">
	<thead>
		<th valign="top"><?php echo JText::_('SAUTO_FACT_NR_CRT'); ?></th>
		<th valign="top"><?php echo JText::_('SAUTO_DATA_TRANZ'); ?></th>
		<th valign="top"><?php echo JText::_('SAUTO_FACT_FACTURA'); ?></th>
		<th valign="top"><?php echo JText::_('SAUTO_FACT_TIP_PLATA'); ?></th>
		<th valign="top">
			<?php echo JText::_('SAUTO_CREDITE_TRANZ').' /<br />'.JText::_('SAUTO_VALOARE_FACT'); ?>
		</th>
		<th valign="top"><?php echo JText::_('SAUTO_STATUS_TRANZ'); ?></th>
		<th valign="top"><?php echo JText::_('SAUTO_FACT_DESCARCA'); ?></th>
		<th valign="top"><?php echo JText::_('SAUTO_FACT_ORIGINALA'); ?></th>
		<th valign="top"><?php echo JText::_('SAUTO_TIP_SERVICIU'); ?></th>
	</thead>
	<tbody>
	<?php
	$link_form = JRoute::_('index.php?option=com_sauto&view=pay&task=load_file'); 
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
		} else { 
			$style = ' sa-row1 '; 
		}	
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td valign="top" class="sa_table_cell">'.$i.'</td>';
			$data = explode(" ", $l->data_tr);
			//data tranzactie
			echo '<td valign="top" class="sa_table_cell">'.$data[0].'</td>';
			//serie factura/proforma
			echo '<td valign="top" class="sa_table_cell">';
				if ($l->prf == 1) {
					//proforma
					echo $l->serie_prf;
				} else {
					//factura
					echo $l->factura;
				}
				//.$l->factura.
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell" valign="top" class="sa_table_cell">';
				$tip_plata = explode(" - ", $l->factura);
				if ($tip_plata[0] == 'op') {
					echo JText::_('SA_TIP_PLATA_OP');
				} elseif ($tip_plata[0] == 'pp') {
					echo JText::_('SA_TIP_PLATA_PP');
				} elseif ($tip_plata[0] == 'cc') {
					echo JText::_('SA_TIP_PLATA_CC');
				}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell"vv>';
				if ($l->tip_plata == 'credit') {
					echo $l->credite;
				} else {
					echo $l->pret.' ';
						if ($tip_plata[0] == 'pp') {
							echo JText::_('SA_MONEDA_EURO');
						} else {
							echo JText::_('SA_MONEDA_LEI');
						}
				}
			echo '</td>';
			echo  '<td valign="top" class="sa_table_cell">';
				if ($l->status_tr == 1) { 
					echo '<div class="sa_fact_green">'.JText::_('SA_FACT_STATUS_PLATIT').'</div>';
				} else {
					echo '<div class="sa_fact_red">'.JText::_('SA_FACT_STATUS_NEPLATIT').'</div>';
					
				}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell"v>';
				if ($l->status_tr == 1) {
					$link_factura = JRoute::_('index.php?option=com_sauto&view=factura&type=fact&id='.$l->id);
					echo '<a href="'.$link_factura.'">'.JText::_('SA_FACT_LINK_FACTURA').'</a>';
				} else {
					$link_factura = 'index.php?option=com_sauto&view=factura&type=prf&id='.$l->id;
					echo '<a href="'.$link_factura.'">'.JText::_('SA_FACT_LINK_PROFORMA').'</a>';
				}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell">';
				if ($l->status_tr == 1) {
					if ($l->original == 2) {
						echo '<div class="sa_fact_tr">'.JText::_('SAUTO_ORIGINAL_TRIMIS').'</div>';
					} elseif ($l->original == 1) {
						echo '<div class="sa_fact_sol">'.JText::_('SAUTO_ORIGINAL_SOLICITAT').'</div>';
					} else  { 
						$link_original = JRoute::_('index.php?option=com_sauto&view=facturi&task=original');
						echo '<form action="'.$link_original.'" method="post">';
						echo '<input type="checkbox" name="original" value="1" onChange="this.form.submit()" /> '.JText::_('SAUTO_SOLICIT');
						echo '<input type="hidden" name="id" value="'.$l->id.'" />';
						echo '<input type="hidden" name="return" value="lista" />';
						echo '</form>';
					}
				}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell">';
				/*if ($l->status_tr == 0) {
					$link_aprob = JRoute::_('index.php?option=com_sauto&view=aprobplata&id='.$l->id);
					echo '<a href="'.$link_aprob.'">aproba plata</a>';
				}*/
				echo $l->tip_plata;
			echo '</td>';
		echo '</tr>';
		if ($l->status_tr == 0) { 
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td valign="top" class="sa_table_cell" colspan="9">';
			if ($l->new_upload == 0) {
				echo '<form method="post" action="'.$link_form.'" enctype="multipart/form-data">';
				echo '<input type="hidden" name="id_factura" value="'.$l->id.'" />'; 
				
				echo JText::_('SAUTO_FISIER_PLATA').' ';
				echo '<input type="file" name="image" value="" /> ';
				echo ' <input type="submit" value="'.JText::_('SAUTO_EFECTUARE_PLATA').'" style="float:right;"/></form>';
			} else {
				echo JText::_('SA_FISIER_INCARCAT'); 	
			} 
			echo '</td>';
		echo '</tr>';
		}
		$i++;
	}
	?>
	</tbody>
</table>
<?php
echo '<br /><br />';
if ($total > $rezult_pagina) {
	echo $paginare;
}
echo '<br /><br />';
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
			//echo '<div>'.$show_side_content.'</div>';	
		?>
		
			</div>
		</td>
	</tr>
</table>
<?php	
}
}