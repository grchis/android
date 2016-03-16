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
$link_form = JRoute::_('index.php?option=com_sauto&view=search_result'); 

?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
	<div>
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT_SEARCH').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL2'); ?></h2>
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_SEARCH_FROM'); ?>
	</div>
	<div>
		<input type="text" name="string_cautare" value="" class="sa_inputbox" />
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_SEARCH_IN'); ?>
	</div>
	<div>
		<input type="checkbox" name="search_in_1" value="1" />
			<?php echo JText::_('SAUTO_SEARCH_IN_TITLE'); ?>
		<br />
		<input type="checkbox" name="search_in_2" value="1" />
			<?php echo JText::_('SAUTO_SEARCH_IN_DESCRIPTION'); ?>
	</div>
	
	
				<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_REGION'); ?></div>
			<div>
			<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'">'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
			
			<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_CITY'); ?></div>
			<div id="sa_city">
				<select name="none" class="sa_select"><option value=""><?php echo JText::_('SAUTO_FORM_SELECT_CITY'); ?></option></select>
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
				echo '<option value="'.$cr->id.'">'.$cr->caroserie.'</option>';
			}
			?>
		</select>
	</div>
			
	<br /><br /><br />	
	<input type="hidden" name="request" value="2" />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_SEARCH_ANUNT_BUTTON'); ?>"  class="sauto_button" />
	</div>
</form>

