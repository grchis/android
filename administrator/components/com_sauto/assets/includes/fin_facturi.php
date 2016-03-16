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
$link_this = JRoute::_('index.php?option=com_sauto&task=financiar&action=facturi');

$app =& JFactory::getApplication();
$an =& JRequest::getVar( 'an', '', 'post', 'string' );
$luna =& JRequest::getVar( 'luna', '', 'post', 'string' );
$plata =& JRequest::getVar( 'plata', '', 'post', 'string' );
$metpl =& JRequest::getVar( 'metpl', '', 'post', 'string' );

if ($an != '') {
	$app->setUserState('an', $an);
}
if ($luna != '') {
	$app->setUserState('luna', $luna);
}
if ($plata != '') {
	$app->setUserState('plata', $plata);
}
if ($metpl != '') {
	$app->setUserState('metpl', $metpl);
}

$ck_an = $app->getUserState('an');
if ($ck_an == 0) {
	$db_an = "";
} else {
	$ck_luna = $app->getUserState('luna');
	if ($ck_luna == 0) {
		$db_an = " AND `data_tr` LIKE '".$ck_an."-%'";
	} else {
		if (strlen($ck_luna) == 1) { $ck_luna_db = '0'.$ck_luna; }
		//echo '>>>> '.$ck_luna;
		$db_an = " AND `data_tr` LIKE '".$ck_an."-".$ck_luna_db."-%'";
	}
}
$ck_plata = $app->getUserState('plata');
if ($ck_plata == 0) {
	$db_plata = "";
} else {
	if ($ck_plata == 1) { 
		$ck_pl_db = 'credit';
	} elseif ($ck_plata == 2) {
		$ck_pl_db = 'abonament';
	}
	$db_plata = " AND `tip_plata` = '".$ck_pl_db."'";
}
$ck_metpl = $app->getUserState('metpl');
if ($ck_metpl == 0) {
	$db_metpl = "";
} else {
	if ($ck_metpl == 1) { 
		$ck_pl_db = 'op';
	} elseif ($ck_metpl == 2) {
		$ck_pl_db = 'cc';
	} elseif ($ck_metpl == 3) {
		$ck_pl_db = 'pp';
	}
	$db_metpl = " AND `factura` LIKE '".$ck_pl_db." - sauto - %'";
}



$db = JFactory::getDbo();
$query = "SELECT count(*) FROM #__sa_facturi WHERE `id` != '0' ".$db_an." ".$db_plata." ".$db_metpl;
$db->setQuery($query);
$toate = $db->loadResult();
echo '<h3>Facturi emise: '.$toate.'</h3>';

//obtin anul curent
$year = date("Y");
$year_start = 2014;
//echo '>>> '.$year;
$month = array(1 => 'Ianuarie', 2 => 'Februarie', 3 => 'Martie', 4 => 'Aprilie', 5 => 'Mai', 6 => 'Iunie', 7 => 'Iulie', 8 => 'August', 9 => 'Septembrie', 10 => 'Octombrie', 11 => 'Noiembrie', 12 => 'Decembrie');


?>
<table cellpadding="5" cellspacing="5"  class="sa_table_class">
	<tr>
		<td>Filtreaza dupa: </td>
		<td>
			<?php echo 'An '; ?>
		</td>
		<td>
			<form action="<?php echo $link_this; ?>" method="post">
			<select name="an" onchange="this.form.submit()">
				<option value="0">Toti anii</option>
			<?php 
			for ($i=$year;$i>=$year_start;$i--) {
				echo '<option value="'.$i.'" ';
					if ($ck_an == $i) {
						echo ' selected '; 
					}
				echo '>'.$i.'</option>';
			}
			?>
			</select>
			</form>
		</td>
		<td>
			<?php echo 'Luna '; ?>
		</td>
		<td>
			<form action="<?php echo $link_this; ?>" method="post">
			<select name="luna" onchange="this.form.submit()">
				<option value="0">Toate lunile</option>
			<?php 
			for ($i=1;$i<13;$i++) {
				echo '<option value="'.$i.'" ';
					if ($ck_luna == $i) {
						echo ' selected ';
					}
				echo '>'.$month[$i].'</option>';
			}
			?>
			</select>
			</form>
		</td>
		<td>
			<?php echo 'Plata pentru '; ?>
		</td>
		<td>
			<form action="<?php echo $link_this; ?>" method="post">
			<select name="plata" onchange="this.form.submit()">
				<option value="0">Tipul platii</option>
			<?php 
			for ($i=1;$i<3;$i++) {
				echo '<option value="'.$i.'" ';
					if ($ck_plata == $i) {
						echo ' selected ';
					}
				echo '>';
					if ($i == 1) {
						echo 'Credit';
					} elseif ($i == 2) {
						echo 'Abonament';
					}
				echo '</option>';
			}
			?>
			</select>
			</form>
		</td>
		<td>
			<?php echo 'Metoda platii '; ?>
		</td>
		<td>
			<form action="<?php echo $link_this; ?>" method="post">
			<select name="metpl" onchange="this.form.submit()">
				<option value="0">Metoda de plata</option>
			<?php 
			for ($i=1;$i<4;$i++) {
				echo '<option value="'.$i.'" ';
					if ($ck_metpl == $i) {
						echo ' selected ';
					}
				echo '>';
					if ($i == 1) {
						echo 'Ordin de plata';
					} elseif ($i == 2) {
						echo 'Credit card';
					} elseif ($i == 3) {
						echo 'PayPal';
					}
				echo '</option>';
			}
			?>
			</select>
			</form>
		</td>
		<td>
			<?php $link_graph = JRoute::_('index.php?option=com_sauto&task=financiar&action=grafice'); ?>
			<a href="<?php echo $link_graph; ?>">Vizualizare grafice</a>
		</td>
	</tr>
</table>
<br /><br />
<?php
if ($toate != 0) {
	$total_rezult = $toate;
$rezult_pagina = '10';
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

$link = JRoute::_('index.php?option=com_sauto&task=financiar&action=facturi');

$interval=5;
 
if($pagina_curenta > (1+$interval)) {
	$paginare.='<a class="sa_page" href="'.$link.'&page=1"><<</a>';
	$pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'"><</a>';
} elseif (($pagina_curenta > 1) && ($pagina_curenta <= (1+$interval))) {
    $pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'"><</a>';
}

for($x=($pagina_curenta - $interval); $x < (($pagina_curenta + $interval) + 1); $x++) {
    if(($x > 0) && ($x <= $nr_pagini)){  
      if($pagina_curenta != $x){
        $paginare.='<a class="sa_page" href="'.$link.'&page='.$x.'">'.$x.'</a>';
      } else {
        $paginare.='<a class="sa_page" style="background-color:#ffffff; color:#000000;">'.$x.'</a>'; 
      }
    }
}


if(($pagina_curenta != $nr_pagini) && ($pagina_curenta < ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">></a>';
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$nr_pagini.'">>></a>';
} elseif (($pagina_curenta != $nr_pagini) && ($pagina_curenta >= ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">></a>';
}


$inceput=($pagina_curenta - 1) * $rezult_pagina;

$query = "SELECT * FROM #__sa_facturi WHERE `id` != '0' ".$db_an." ".$db_plata." ".$db_metpl." ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
$i=1;

?>

<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<thead>
			<th class="sa_table_head" width="70">Nr. Crt.</th>
			<th class="sa_table_head">Factura</th>
			<th class="sa_table_head">Cumparator</th>
			<th class="sa_table_head">Data tranz.</th>
			<th class="sa_table_head">Valoare</th>
			<th class="sa_table_head">Tip plata</th>
			<th class="sa_table_head">Actiuni</th>
		</thead>
		<tbody>
<?php
foreach ($list as $l) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	echo '<tr class="'.$style.'">';
		echo '<td class="sa_table_data">'.$i.'</td>';
		echo '<td class="sa_table_data">';
		$link_fact = JRoute::_('index.php?option=com_sauto&task=financiar&action=factura&id='.$l->id);
			echo '<a href="'.$link_fact.'">'.$l->factura.'</a>';
		echo '</td>';
		echo '<td class="sa_table_data">';
			$query = "SELECT `companie` FROM #__sa_profiles WHERE `uid` = '".$l->uid."'";
			$db->setQuery($query);
			$owner = $db->loadResult();
			$link_firm = JRoute::_('index.php?option=com_sauto&task=profil&id='.$l->uid);
			echo '<a href="'.$link_firm.'">'.$owner.'</a>';
		echo '</td>';
		echo '<td class="sa_table_data">'.$l->data_tr.'</td>';
		echo '<td class="sa_table_data">';
			if ($l->tip_plata == 'abonament') {
				echo $l->pret.' Euro';
			} else {
				echo $l->credite.' lei';
			}
		echo '</td>';
		echo '<td class="sa_table_data">';
			echo $l->tip_plata;
		echo '</td>';
		echo '<td class="sa_table_data">';
		$link_sent = JRoute::_('index.php?option=com_sauto&task=financiar&action=sent&id='.$l->id);
		$link_del = JRoute::_('index.php?option=com_sauto&task=financiar&action=del&id='.$l->id);
			if ($l->original == 1) {
				echo '<a href="'.$link_sent.'">Trimite!</a>';
				echo  ' | ';
			}
			
			echo '<a href="'.$link_del.'">Sterge!</a>';
		echo '</td>';
	echo '</tr>';
$i++;
}
?>
</tbody>
</table>
<br /><br />
<?php echo $paginare;
echo '<br /><br />';
}
?>

