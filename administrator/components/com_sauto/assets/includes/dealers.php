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
$db = JFactory::getDbo();
$app =& JFactory::getApplication();

$filtrat = $app->getUserState('filtrat');
//$filtrat = 0;
$db_v_nume = '';
$db_v_firma = '';
$db_v_email = '';
$db_v_telefon = '';
$db_v_abonament = '';
if ($filtrat == 0) {
	$query = "SELECT count(*) FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`tip_cont` = '1' AND `p`.`uid` = `u`.`id`";
} else {
	$v_nume = $app->getUserState('v_nume');
	$v_firma = $app->getUserState('v_firma');
	$v_email = $app->getUserState('v_email');
	$v_telefon = $app->getUserState('v_telefon');
	$v_abonament = $app->getUserState('abonament');
	if ($v_nume != '') { $db_v_nume = " AND `p`.`reprezentant` LIKE '%".$v_nume."%'"; }
	if ($v_firma != '') { $db_v_firma = " AND `p`.`companie` LIKE '%".$v_firma."%'"; }
	if ($v_email != '') { $db_v_email = " AND `u`.`email` LIKE '%".$v_email."%'"; }
	if ($v_telefon != '') { $db_v_telefon = " AND `p`.`telefon` LIKE '%".$v_telefon."%'"; }
	if ($v_abonament != '') { $db_v_abonament = " AND `p`.`abonament` = '".$v_abonament."' "; } 
	$query = "SELECT count(*) FROM #__sa_profiles AS `p` JOIN #__users AS `u` 
			ON `p`.`tip_cont` = '1' 
			AND `p`.`uid` = `u`.`id` ".$db_v_nume." ".$db_v_email." ".$db_v_telefon." ".$db_v_firma." ".$db_v_abonament." ";
}
$db->setQuery($query);
$total = $db->loadResult();


if ($v_abonament != '') {
	$val_abn = $v_abonament;
} else {
	$val_abn = '';
}
//echo '>>> '.$total;
?>
<div>
<?php $link_filter = 'index.php?option=com_sauto&task=set_vars'; ?>
<h3>Filtrare firme</h3>
<form action="<?php echo $link_filter; ?>" method="post">
	<input type="hidden" name="type" value="dealer" />
	<div class="sa_inputs">
	<span class="sa_label">Reprezentant</span> <input type="text" name="v_nume" value="<?php echo $v_nume; ?>" /> 
	</div>
	<div class="sa_inputs">
	<span class="sa_label">Firma</span> <input type="text" name="v_firma" value="<?php echo $v_firma; ?>" /> 
	</div>
	<div class="sa_inputs">
	<span class="sa_label">Email</span> <input type="text" name="v_email" value="<?php echo $v_email; ?>" />
	</div>
	<div class="sa_inputs">	
	<span class="sa_label">Telefon</span> <input type="text" name="v_telefon" value="<?php echo $v_telefon; ?>" />
	</div>
	<div class="sa_inputs">	
	<span class="sa_label">Tip abonament</span> 
	<select name="abonament">
		<option value="">Alege abonament</option>
		<?php
		$query = "SELECT * FROM #__sa_abonament";
		$db->setQuery($query);
		$abn = $db->loadObjectList();
		foreach ($abn as $a) {
			echo '<option value="'.$a->id.'"';
				if ($val_abn == $a->id) { echo ' selected '; }
			echo '>'.$a->abonament.'</option>';
		}
		?>
	</select>
	</div>
	<input type="submit" value="Filtreaza" />
</form>
<br />
</div>
<?php
if ($total != 0) {
$total_rezult = $total;
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

$link = JRoute::_('index.php?option=com_sauto&task=dealers');

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

$query = "SELECT `u`.`email`, `p`.`uid`, `p`.`poza`, `p`.`companie`, `p`.`telefon`, `u`.`registerDate`, `j`.`judet`, `l`.`localitate`
			, `p`.`calificative`, `p`.`reprezentant`, `p`.`deleted`   
			FROM #__sa_profiles AS `p` 
			JOIN #__users as `u` 
			JOIN #__sa_judete as `j` 
			JOIN #__sa_localitati as `l` 
			ON `p`.`uid` = `u`.`id` 
			AND `p`.`tip_cont` = '1' 
			AND `p`.`judet` = `j`.`id` 
			AND `p`.`localitate` = `l`.`id` 
			".$db_v_nume.$db_v_email.$db_v_telefon.$db_v_firma." ".$db_v_abonament." 
			ORDER BY `p`.`uid` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();
$image_path = JUri::root().'components/com_sauto/assets/';

?>
<h2>Lista firme</h2>

<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<tbody>
<?php
foreach ($list as $l) {
	if ($style == ' sa-row1 ') { 
		$style = ' sa-row0 '; 
	} else { 
		$style = ' sa-row1 '; 
	}
	echo '<tr class="'.$style.'">';
		echo '<td width="100" valign="top">';
			//obtin poza
			if ($l->poza == '') {
				//fara poza
				echo '<img src="'.$image_path.'images/icon_profile.png" width="70" />';
			} else {
				//cu poza
				echo '<img src="'.$image_path.'users/'.$l->uid.'/'.$l->poza.'" width="70" />';
			}
			
		echo '</td>';
		echo '<td valign="top">';
			echo '<div class="sa_title">';
			$link_profil = 'index.php?option=com_sauto&task=profil&id='.$l->uid;
				echo '<a href="'.$link_profil.'" class="sa_link_title">'.$l->companie.'</a> ('.$l->reprezentant.')';
			echo '</div>';
			echo '<div>E-mail: '.$l->email.'</div>';
			$new_date = explode(" ", $l->registerDate);
			echo '<div>Membru din: '.$new_date[0].'</div>';
			if ($l->deleted == 1) {
				echo '<div class="sa_deleted">Cont sters!</div>';
			}
		echo '</td>';

		echo '<td valign="top">';
			echo '<div>Judet: '.$l->judet.'</div>';
			echo '<div>Localitate: '.$l->localitate.'</div>';
			echo '<div>Telefon: '.$l->telefon.'</div>';
		echo '</td>';
		echo '<td valign="top">';
			
			//total anunturi castigate
			$query = "SELECT count(*) FROM #__sa_anunturi WHERE `uid_winner` = '".$l->uid."'";
			$db->setQuery($query);
			$total_final = $db->loadResult();
			echo '<div>Total anunturi castigate: '.$total_final.'</div>';
			
			//total anunturi active
			$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `firma` = '".$l->uid."' ";
			$db->setQuery($query);
			$total_oferte = $db->loadResult();
			echo '<div>Total oferte facute: '.$total_oferte.'</div>';
			echo '<div>Calificative: '.$l->calificative.'%</div>';
		echo '</td>';
		echo '<td valign="top">';
			echo '<div>';
				echo '<form action="index.php?option=com_sauto&task=edit_dealer" method="post">';
					echo '<input type="hidden" name="uid" value="'.$l->uid.'" />';
					echo '<input type="submit" value="Editare companie" />';
				echo '</form>';
			echo '</div>';
			echo '<div>';
				echo '<form action="index.php?option=com_sauto&task=castigate" method="post">';
					echo '<input type="hidden" name="uid" value="'.$l->uid.'" />';
					echo '<input type="submit" value="Lista anunturi castigate" ';
					if ($total_final == 0) { echo ' disabled '; }
					echo ' />';
				echo '</form>';
			echo '</div>';
			echo '<div>';
				echo '<form action="index.php?option=com_sauto&task=oferte&uid='.$l->uid.'" method="post">';
					echo '<input type="submit" value="Lista oferte facute" ';
					if ($total_oferte == 0) { echo ' disabled '; }
					echo ' />';
				echo '</form>';
			echo '</div>';
		echo '</td>';
	echo '</tr>';	
	}
?>
	</tbody>
</table>

<br /><br />
<?php echo $paginare;
echo '<br /><br />';	
}
