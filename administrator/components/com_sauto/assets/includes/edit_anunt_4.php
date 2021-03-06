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
//obtin id anunt
$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$db = JFactory::getDbo();

$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$rezult = $db->loadObject();
$image_path = JURI::root()."components".DS."com_sauto".DS."assets".DS."users".DS.$rezult->proprietar.DS;
$link_form = 'index.php?option=com_sauto&task=save_anunt';
?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
	<div>
		<h2>Auto rulate :: Editare anunt</h2>
	</div>
	<div class="sauto_form_label">
		Titlu anunt
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="<?php echo $rezult->titlu_anunt; ?>" class="sa_inputbox" />
	</div>
	
	<div class="sauto_form_label">
		Marca auto
	</div>
	
	
	<div>
		<select name="marca" onChange="javascript:aratMarca(this.value)">
			<option value="">Marca auto</option>
			<?php
			$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
			$db->setQuery($query);
			$marc = $db->loadObjectList();
				foreach ($marc as $m) {
					echo '<option id="'.$m->id.'"';
						if ($m->id == $rezult->marca_auto) { echo ' selected'; }
					echo '>'.$m->marca_auto.'</option>';
				}
			?>
		</select>
	</div>

					
	<div class="sauto_form_label">Model auto</div>
		<div id="sa_marca">
			<select name="model_auto">
				<option value="">Alege model</option>
				<?php
				if ($rezult->marca_auto != '') {
					$query = "SELECT * FROM #__sa_model_auto WHERE `mid` = '".$rezult->marca_auto."' AND `published` = '1'";
					$db->setQuery($query);
					$modds = $db->loadObjectList();
					foreach ($modds as $m) {
						echo '<option value="'.$m->id.'"';
							if ($rezult->model_auto == $m->id) { echo ' selected'; }
						echo '>'.$m->model_auto.'</option>';
					}
				}
				?>
			</select>

		</div>
					
	<div class="sauto_form_label">Judet</div>
	<div>
			<select name="judet" onChange="javascript:aratOrase(this.value)">
				<option value="">Alege judet</option>
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'"';
								if ($j->id == $rezult->judet) { echo ' selected '; }
							echo '>'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
			<div class="sauto_form_label">Localitate</div>
			<div id="sa_city">
				<?php if ($rezult->judet == '') { ?>
				<select name="none"><option value="">Alege localitate</option></select>
				<?php 
				} else { 
					//obtin localitatile judetului selectat
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$rezult->judet."' AND `published` = '1'";
					$db->setQuery($query);
					$cities = $db->loadObjectList();
					echo '<select name="localitate">';
						echo '<option value="">Alege localitate</option>';
						foreach ($cities as $c) {
							echo '<option value="'.$c->id.'"';
								if ($c->id == $rezult->city) { echo ' selected '; }
							echo '>'.$c->localitate.'</option>';
						}
					echo '</select>'; 
				} ?> 
			</div>
							
	<div class="sauto_form_label">
		An fabricatie
	</div>
	<div>
		<select name="an_fabricatie">
			<option value="">Alege an fabricatie</option>
			<?php
			$an = date("Y", mktime());
			for ($i=$an;$i>='1950';$i--) {
				echo '<option value="'.$i.'"';
					if ($i == $rezult->an_fabricatie) { echo ' selected';}
				echo '>'.$i.'</option>';
			}
			?>
		</select>
	</div>
					
	<div class="sauto_form_label">
		Cilindree
	</div>
	<div>
		<input type="text" name="cilindree" value="<?php echo $rezult->cilindree; ?>" class="sa_inputbox" /> cm<sup>3</sup>
	</div>
					
	<div class="sauto_form_label">
		Carburant
	</div>
	<div>
		<select name="carburant">
			<option value="">Alege carburant</option>
			<?php
			$query = "SELECT * FROM #__sa_carburant ORDER BY `carburant` ASC";
			$db->setQuery($query);
			$carb = $db->loadObjectList();
			foreach ($carb as $c) {
				echo '<option value="'.$c->id.'"';
					if ($c->id == $rezult->carburant) { echo ' selected'; }
				echo '>'.$c->carburant.'</option>';
			}
			?>
		</select>
	</div>
		
	<div class="sauto_form_label">
		Nr. usi
	</div>
	<div>
		<select name="nr_usi">
			<option value="">Alege nr. usi</option>
			<?php
			$query = "SELECT * FROM #__sa_usi ORDER BY `usi` ASC";
			$db->setQuery($query);
			$usi = $db->loadObjectList();
			foreach ($usi as $u) {
				echo '<option value="'.$u->id.'"';
					if ($u->id == $rezult->nr_usi) { echo ' selected'; }
				echo '>'.$u->usi.'</option>';
			}
			?>
		</select>
	</div>
				
	<div class="sauto_form_label">
		Caroserie
	</div>
	<div>
		<select name="caroserie">
			<option value="">Alege caroserie</option>
			<?php
			$query = "SELECT * FROM #__sa_caroserie ORDER BY `caroserie` ASC";
			$db->setQuery($query);
			$caros = $db->loadObjectList();
			foreach ($caros as $cr) {
				echo '<option value="'.$cr->id.'"';
					if ($cr->id == $rezult->caroserie) { echo ' selected'; }
				echo '>'.$cr->caroserie.'</option>';
			}
			?>
		</select>
	</div>
	<?php
	$query = "SELECT count(*) FROM #__sa_poze WHERE `id_anunt` = '".$rezult->id."'";
	$db->setQuery($query);
	$all_pics = $db->loadResult();
	if ($all_pics != 0) {
	?>
	<div class="sauto_form_label">
		Imagini anunt
	</div>
	<?php
	}
		//for ($i=1;$i<=$sconfig->max_img_anunt;$i++) {
		$query = "SELECT * FROM #__sa_poze WHERE `id_anunt` = '".$rezult->id."' ORDER BY `id` ASC";
		$db->setQuery($query);
		$pics = $db->loadObjectList();
		foreach ($pics as $p) {
			echo '<div><img src="'.$image_path.$p->poza.'" width="70" /></div>';
			echo '<div><input type="checkbox" name="delete_pic_'.$p->id.'" value="1" />Sterge imagine</div>';
			//echo '>>>> '.$p->poza.'<br />';
	/*<div>
		<input type="file" name="image_<?php echo $i; ?>" value="" class="sa_inputbox" />
	</div>
	*/ 
	} 
	?>
			
	
	<div class="sauto_form_label">
		Anunt
	</div>
	<div>
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('anunt4', $rezult->anunt, '300', '150', '60', '20', false);
			?>
			</div>
	<br /><br /><br />
	<input type="hidden" name="request" value="4" />
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<div>
		<input type="submit" value="Editare anunt"  class="sauto_button" />
	</div>
</form>
