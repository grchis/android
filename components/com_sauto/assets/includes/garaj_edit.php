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
$user =& JFactory::getUser();$document = JFactory::getDocument();$app =& JFactory::getApplication();
$uid = $user->id;
//$document->addScriptDeclaration ($js_code1);
$link_form = JRoute::_('index.php?option=com_sauto&view=garaj&task=editing');
//
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
$query = "SELECT count(*) FROM #__sa_garaj WHERE `id` = '".$id."' AND `owner` = '".$uid."'";
$db->setQuery($query);
$total = $db->loadResult();
if ($total == 0) {
	//redirect
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
} else {
$query = "SELECT * FROM #__sa_garaj WHERE `id` = '".$id."' AND `owner` = '".$uid."'";
$db->setQuery($query);
$list = $db->loadObject();
$width = 'style="width:800px;"';
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
	<div>		<h2><?php echo JText::_('SAUTO_EDIT_CAR_IN_GARAJ'); ?></h2>
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
					echo '<option id="'.$m->id.'"';
						if ($list->marca == $m->id) { echo ' selected '; }
					echo '>'.$m->marca_auto.'</option>';
				}
			?>
		</select>
	</div>

					
	<div class="sauto_form_label"><?php echo JText::_('SAUTO_ALEGE_MODELUL'); ?></div>
		<div id="sa_marca">
			<select name="model_auto" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_ALEGE_MODELUL_DORIT'); ?></option>
				<?php
					$query = "SELECT * FROM #__sa_model_auto WHERE `mid` = '".$list->marca."' AND `published` = '1'";
					$db->setQuery($query);
					$modds = $db->loadObjectList();
					foreach ($modds as $mod) {
						echo '<option value="'.$mod->id.'"';
							if ($list->model == $mod->id) { echo ' selected '; }
						echo '>'.$mod->model_auto.'</option>';
					}
				?>
			</select>
		</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ALEGE_TRANSMISIE'); ?>
	</div>
	
	<div>
		<select name="transmisie" class="sa_select">
			<option value="0"><?php echo JText::_('SAUTO_TIP_TRANSMISIE'); ?></option>
			<option value="1" <?php if ($list->transmisie == 1) { echo ' selected '; } ?>><?php echo JText::_('SAUTO_TRANSMISIE_MANUALA'); ?></option>
			<option value="2" <?php if ($list->transmisie == 2) { echo ' selected '; } ?>><?php echo JText::_('SAUTO_TRANSMISIE_AUTOMATA'); ?></option>
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
				echo '<option value="'.$i.'"';
					if ($list->an_fabricatie == $i) { echo ' selected '; }
				echo '>'.$i.'</option>';
			}
			?>
		</select>
	</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CILINDREE'); ?>
	</div>
	<div>
		<input type="text" name="cilindree" value="<?php echo $list->cilindree; ?>" class="sa_inputbox" />
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
				echo '<option value="'.$c->id.'"';
					if ($list->carburant == $c->id) { echo ' selected '; }
				echo '>'.$c->carburant.'</option>';
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
				echo '<option value="'.$u->id.'"';
					if ($list->nr_usi == $u->id) { echo ' selected '; }
				echo '>'.$u->usi.'</option>';
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
				echo '<option value="'.$cr->id.'"';
					if ($list->caroserie == $cr->id) { echo ' selected '; }
				echo '>'.$cr->caroserie.'</option>';
			}
			?>
		</select>
	</div>
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_SERIE_CAROSERIE'); ?>
	</div>
	<div>
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="text" name="serie_caroserie" value="<?php echo $list->serie_caroserie; ?>" class="sa_inputbox" />
	</div>

	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_DATA_EXPIRARE_ITP'); ?>
	</div>
	<div>
		<?php 
		if ($list->exp_itp == '0000-00-00') { $exp_itp = ''; } else { $exp_itp = $list->exp_itp; }
		echo JHTML::_('calendar', $exp_itp, 'exp_itp', 'exp_itp', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_DATA_EXPIRARE_RCA'); ?>
	</div>
	<div>
		<?php 
		if ($list->exp_rca == '0000-00-00') { $exp_rca = ''; } else { $exp_rca = $list->exp_rca; }
		echo JHTML::_('calendar', $exp_rca, 'exp_rca', 'exp_rca', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_DATA_EXPIRARE_RVG'); ?>
	</div>
	<div>
		<?php 
		if ($list->exp_rvg == '0000-00-00') { $exp_rvg = ''; } else { $exp_rvg = $list->exp_rvg; }
		echo JHTML::_('calendar', $exp_rvg, 'exp_rvg', 'exp_rvg', '%Y-%m-%d', array('class' => 'inputbox required validate-date sa_inputbox')); ?>
	</div>

	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_EDIT_IN_GARAJ_BUTTON'); ?>"  class="sauto_button" />
		<?php 
		$link_renunt = JRoute::_('index.php?option=com_sauto&view=garaj');
		echo '<span class="sa_renunta">   '.JText::_('SAUTO_OR').' <a href="'.$link_renunt.'">'.JText::_('SAUTO_RENUNTA').'</a></span>'; ?>
	</div>
</form>
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
<?php } ?>
