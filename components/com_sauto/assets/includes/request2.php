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
require_once('/mobile/request2_mobile.php');
}else{
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=adding'); 
$app =& JFactory::getApplication();

$titlu_anunt = $app->getUserState('titlu_anunt');
$id_judet = $app->getUserState('id_judet');
$new_city = $app->getUserState('new_city');
$city = $app->getUserState('city');
$caroserie = $app->getUserState('caroserie');
$anunt = $app->getUserState('anunt');

?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
	<div>
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL2'); ?></h2>
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_TITLU_ANUNT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="<?php echo $titlu_anunt; ?>" class="sa_inputbox" />
	</div>
	
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_REGION_PRELUARE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div>
			<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'"';
								if ($j->id == $id_judet) { echo ' selected '; }
							echo '>'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
			
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_CITY_PRELUARE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div id="sa_city">
				<?php if ($id_judet == '') { ?>
				<select name="none" class="sa_select"><option value=""><?php echo JText::_('SAUTO_FORM_SELECT_CITY'); ?></option></select>
				<?php 
				} else { 
					//obtin localitatile judetului selectat
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$id_judet."' AND `published` = '1' ORDER BY `localitate` ASC";
					$db->setQuery($query);
					$cities = $db->loadObjectList();
					echo '<select name="localitate_r">';
						echo '<option value="">'.JText::_('SAUTO_FORM_SELECT_CITY').'</option>';
						foreach ($cities as $c) {
							echo '<option value="'.$c->id.'"';
								if ($c->id == $city) { echo ' selected '; }
							echo '>'.$c->localitate.'</option>';
						}
					echo '</select>'; 
				} ?> 
				
			</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_DATA_PRELUARE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<?php echo JHTML::_('calendar', '', 'data_preluare', 'data_preluare', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_REGION_RETURNARE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div>
			<select name="judet_r" onChange="javascript:aratOrase3(this.value)" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'"';
								if ($j->id == $id_judet) { echo ' selected '; }
							echo '>'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
		
		
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_CITY_RETURNARE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div id="sa_city2">
				<?php
					//obtin localitatile judetului selectat
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$id_judet."' AND `published` = '1' ORDER BY `localitate` ASC";
					$db->setQuery($query);
					$cities = $db->loadObjectList();
					echo '<select name="city" class="sa_select">';
						echo '<option value="">'.JText::_('SAUTO_FORM_SELECT_CITY').'</option>';
						foreach ($cities as $c) {
							echo '<option value="'.$c->id.'"';
								if ($c->id == $city) { echo ' selected '; }
							echo '>'.$c->localitate.'</option>';
						}
					echo '</select>'; 
				?> 
				
			</div>
			
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_DATA_RETURNARE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<?php echo JHTML::_('calendar', '', 'data_returnare', 'data_returnare', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>
	
	
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CAROSERIE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
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
					if ($cr->id == $caroserie) { echo ' selected '; }
				echo '>'.$cr->caroserie.'</option>';
			}
			?>
		</select>
	</div>
			
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ANUNT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('anunt2', $anunt, '500', '150', '60', '20', false);
			?>
			</div>
	<div class="sauto_form_label sa_obligatoriu">
		<?php echo JText::_('SAUTO_CAMPURI_OBLIGATORII'); ?>
	</div>
	
	<br /><br /><br />
	<?php /*
	<div class="sauto_form_label">
	<?php echo JText::_('SAUTO_FORM_PRICE'); ?>
	</div>
	<div>
		<input type="type="text" name="price" value="<?php echo $price; ?>" />
	</div>
	<br /><br />*/ ?>	
	<input type="hidden" name="request" value="2" />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_ADD_ANUNT_BUTTON'); ?>"  class="sauto_button" />
		<?php 
		$link_renunt = JRoute::_('index.php?option=com_sauto&view=purge');
		echo '<span class="sa_renunta">   '.JText::_('SAUTO_OR').' <a href="'.$link_renunt.'">'.JText::_('SAUTO_RENUNTA').'</a></span>'; ?>
	</div>
</form>
<?php } ?>
<script type="text/javascript">
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>');
	var isMobile = navigator.userAgent.contains('Mobile');
	if (!isMobile) {
		document.getElementById('m_visitors').remove();
	} else {
		document.getElementById('side_bar').remove();
		document.getElementById('gkTopBar').remove();
		document.getElementById('content9').style.all = "none";
		
	}
</script>