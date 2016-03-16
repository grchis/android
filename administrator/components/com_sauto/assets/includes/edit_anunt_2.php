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
$link_form = 'index.php?option=com_sauto&task=save_anunt';
?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
	<div>
		<h2>Inchirieri :: Editare anunt</h2>
	</div>
	<div class="sauto_form_label">
		Titlu anunt
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="<?php echo $rezult->titlu_anunt; ?>" class="sa_inputbox" />
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
				<select name="none"><option value="">Alege localitatea</option></select>
				<?php 
				} else { 
					//obtin localitatile judetului selectat
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$rezult->judet."' AND `published` = '1'";
					$db->setQuery($query);
					$cities = $db->loadObjectList();
					echo '<select name="localitate">';
						echo '<option value="">'.JText::_('SAUTO_FORM_SELECT_CITY').'</option>';
						foreach ($cities as $c) {
							echo '<option value="'.$c->id.'"';
								if ($c->id == $rezult->city) { echo ' selected '; }
							echo '>'.$c->localitate.'</option>';
						}
					echo '</select>'; 
				} ?> 
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
			$carr = $db->loadObjectList();
			foreach ($carr as $cr) {
				echo '<option value="'.$cr->id.'"';
					if ($cr->id == $rezult->caroserie) { echo ' selected '; }
				echo '>'.$cr->caroserie.'</option>';
			}
			?>
		</select>
	</div>
	
	<div class="sauto_form_label">
		Anunt
	</div>
	<div>
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('anunt2', $rezult->anunt, '300', '150', '60', '20', false);
			?>
			</div>
	<br /><br /><br />
	<input type="hidden" name="request" value="2" />
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<div>
		<input type="submit" value="Editare anunt"  class="sauto_button" />
	</div>
</form>
