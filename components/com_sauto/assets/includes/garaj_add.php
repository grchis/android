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

$user =& JFactory::getUser();
$uid = $user->id;

$document = JFactory::getDocument();
$app =& JFactory::getApplication();

require("javascript.php");
$document->addScriptDeclaration ($js_code1);

$link_form = JRoute::_('index.php?option=com_sauto&view=garaj&task=adding');
?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
	<div>
		<h2><?php echo JText::_('SAUTO_ADD_NEW_IN_GARAJ'); ?></h2>
	</div>

	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_MARCA_AUTO'); ?>
	</div>
	
	
	<div>
		<select name="marca" onChange="javascript:aratMarca(this.value)" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_MARCA'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
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
		<?php echo JText::_('SAUTO_ALEGE_TRANSMISIE'); ?>
	</div>
	
	<div>
		<select name="transmisie" class="sa_select">
			<option value="0"><?php echo JText::_('SAUTO_TIP_TRANSMISIE'); ?></option>
			<option value="1"><?php echo JText::_('SAUTO_TRANSMISIE_MANUALA'); ?></option>
			<option value="2"><?php echo JText::_('SAUTO_TRANSMISIE_AUTOMATA'); ?></option>
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
		<?php echo JText::_('SAUTO_NR_USI'); ?>
	</div>
	<div>
		<select name="nr_usi" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_NR_USI'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_usi ORDER BY `usi` ASC";
			$db->setQuery($query);
			$usi = $db->loadObjectList();
			foreach ($usi as $u) {
				echo '<option value="'.$u->id.'">'.$u->usi.'</option>';
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
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_SERIE_CAROSERIE'); ?>
	</div>
	<div>
		<input type="text" name="serie_caroserie" value="" class="sa_inputbox" />
	</div>

	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_DATA_EXPIRARE_ITP'); ?>
	</div>
	<div>
		<?php echo JHTML::_('calendar', '', 'exp_itp', 'exp_itp', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_DATA_EXPIRARE_RCA'); ?>
	</div>
	<div>
		<?php echo JHTML::_('calendar', '', 'exp_rca', 'exp_rca', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_DATA_EXPIRARE_RVG'); ?>
	</div>
	<div>
		<?php echo JHTML::_('calendar', '', 'exp_rvg', 'exp_rvg', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>
	
	

	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_ADD_IN_GARAJ_BUTTON'); ?>"  class="sauto_button" />
		<?php 
		$link_renunt = JRoute::_('index.php?option=com_sauto&view=garaj');
		echo '<span class="sa_renunta">   '.JText::_('SAUTO_OR').' <a href="'.$link_renunt.'">'.JText::_('SAUTO_RENUNTA').'</a></span>'; ?>
	</div>
</form>

