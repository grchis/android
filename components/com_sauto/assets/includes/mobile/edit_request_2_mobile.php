<style type="text/css">
form {
    margin: 0;
    padding-left: 2%;
    padding-right: 2%;
}
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
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
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=editing'); 
$app =& JFactory::getApplication();

$id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );

$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$rezult = $db->loadObject();

?>
<div id="m_visitors" style="background-color:#F9F9F9">
<?php require_once('menu_filter.php');?>
</div>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
	<div>
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL2'); ?></h2>
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_TITLU_ANUNT'); ?>
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="<?php echo $rezult->titlu_anunt; ?>" class="sa_inputbox" />
	</div>
	
	
				<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_REGION_PRELUARE'); ?></div>
			<div>
			<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
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
			
			<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_CITY_PRELUARE'); ?></div>
			<div id="sa_city">
				<?php if ($rezult->judet == '') { ?>
				<select name="none" class="sa_select"><option value=""><?php echo JText::_('SAUTO_FORM_SELECT_CITY'); ?></option></select>
				<?php 
				} else { 
					//obtin localitatile judetului selectat
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$rezult->judet."' AND `published` = '1' ORDER BY `localitate` ASC";
					$db->setQuery($query);
					$cities = $db->loadObjectList();
					echo '<select name="localitate" class="sa_select">';
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
		<?php echo JText::_('SAUTO_DATA_PRELUARE'); ?>
	</div>
	<div>
		<?php 
		$data_p = explode(" ", $rezult->data_preluare);
		echo JHTML::_('calendar', $data_p[0], 'data_preluare', 'data_preluare', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>
	
	
	<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_REGION_RETURNARE'); ?></div>
			<div>
			<select name="judet_r" onChange="javascript:aratOrase3(this.value)" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'"';
								if ($j->id == $rezult->judet_r) { echo ' selected '; }
							echo '>'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
		
		
		<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_CITY_RETURNARE'); ?></div>
			<div id="sa_city2">
				<?php
					//obtin localitatile judetului selectat
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$rezult->judet_r."' AND `published` = '1' ORDER BY `localitate` ASC";
					$db->setQuery($query);
					$cities = $db->loadObjectList();
					echo '<select name="localitate_r" class="sa_select">';
						echo '<option value="">'.JText::_('SAUTO_FORM_SELECT_CITY').'</option>';
						foreach ($cities as $c) {
							echo '<option value="'.$c->id.'"';
								if ($c->id == $rezult->localitate_r) { echo ' selected '; }
							echo '>'.$c->localitate.'</option>';
						}
					echo '</select>'; 
				?> 
				
			</div>
			
			
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_DATA_RETURNARE'); ?>
	</div>
	<div>
		<?php 
		$data_r = explode(" ", $rezult->data_returnare);
		echo JHTML::_('calendar', $data_r[0], 'data_returnare', 'data_returnare', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>
	
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CAROSERIE'); ?>
	</div>
	<div>
		<select name="caroserie" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_CAROSERIE'); ?></option>
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
		<?php echo JText::_('SAUTO_ANUNT'); ?>
	</div>
		<div>
			<textarea name="anunt2" id="anunt2" cols="60" rows="20" style="width: 500px; height: 150px;" class="mce_editable" aria-hidden="true">
				<?php
					echo $rezult->anunt;
				?>
			</textarea>
		</div>
	<br /><br /><br />
	<input type="hidden" name="request" value="2" />
	<input type="hidden" name="anunt_id" value="<?php echo $id; ?>" />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_EDIT_ANUNT_BUTTON'); ?>"  class="sauto_button" />
	</div>
</form>
