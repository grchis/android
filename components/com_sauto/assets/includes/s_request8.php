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
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT_SEARCH').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL8'); ?></h2>
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
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_MARCA_AUTO'); ?>
	</div>
	
	
	<div>
		<select name="marca" onChange="javascript:aratMarca(this.value)" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_MARCA'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_marca_auto ORDER BY `marca_auto` ASC";
			$db->setQuery($query);
			$marc = $db->loadObjectList();
				foreach ($marc as $m) {
					echo '<option id="'.$m->id.'">'.$m->marca_auto.'</option>';
				}
			?>
		</select>
	</div>
					
	<div class="sauto_form_label"><?php echo JText::_('SAUTO_ALEGE_MODELUL'); ?></div>
		<div id="sa_marca">
			<select name="model_auto" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_ALEGE_MODELUL_DORIT'); ?></option>
			</select>
		</div>
					
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_AN_FABRICATIE'); ?>
	</div>
	<div>
		<select name="an_fabricatie" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_SELECT_AN_FABR'); ?></option>
			<?php
			$an = date("Y", mktime());
			for ($i=$an;$i>='1950';$i--) {
				echo '<option value="'.$i.'">'.$i.'</option>';
			}
			?>
		</select>
	</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CILINDREE'); ?>
	</div>
	<div>
		<input type="text" name="cilindree" value="" class="sa_inputbox" />
	</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CARBURANT'); ?>
	</div>
	<div>
		<select name="carburant" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_CARBURANT'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_carburant ORDER BY `carburant` ASC";
			$db->setQuery($query);
			$carb = $db->loadObjectList();
			foreach ($carb as $c) {
				echo '<option value="'.$c->id.'">'.$c->carburant.'</option>';
			}
			?>
		</select>
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
			$caros = $db->loadObjectList();
			foreach ($caros as $cr) {
				echo '<option value="'.$cr->id.'">'.$cr->caroserie.'</option>';
			}
			?>
		</select>
	</div>
	

	<br /><br /><br />
	<input type="hidden" name="request" value="8" />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_SEARCH_ANUNT_BUTTON'); ?>"  class="sauto_button" />
	</div>
</form>

