<style type="text/css">
#content9 br{
	display:none;
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
$link_form = JRoute::_('index.php?option=com_sauto&view=adding'); 

$app =& JFactory::getApplication();
$accesorii = $app->getUserState('accesorii');
$subaccesorii = $app->getUserState('subaccesorii');
$marca = $app->getUserState('marca');
$model_auto = $app->getUserState('model_auto');
require("function_load_img_mobile.php");
$multiple_id = 0;
require_once('menu_filter.php');
?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
<div>
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL7'); ?></h2>
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_TITLU_ANUNT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="" class="sa_inputbox" />
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_ALEGE_ACCESORIU'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<select name="acc" onChange="javascript:aratSubacc(this.value)" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_ACCESORIU'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_accesorii WHERE `published` = '1' ORDER BY `accesorii` ASC";
			$db->setQuery($query);
			$acc = $db->loadObjectList();
				foreach ($acc as $a) {
					echo '<option id="'.$a->id.'"';
						if ($a->id == $accesorii) { echo ' selected'; }
					echo '>'.$a->accesorii.'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ALEGE_SUBACCESORIUL'); ?>
	</div>
	
	<div id="sa_subacc">
			<select name="subacc" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_ALEGE_SUBACCESORIUL'); ?></option>
				<?php
				if ($subaccesorii != '') {
					$query = "SELECT * FROM #__sa_subaccesorii WHERE `acc_id` = '".$accesorii."' AND `published` = '1' ORDER BY `subaccesoriu` ASC";
					$db->setQuery($query);
					$sacc = $db->loadObjectList();
					foreach ($sacc as $s) {
						echo '<option value="'.$s->id.'"';
							if ($subaccesorii == $s->id) { echo ' selected'; }
						echo '>'.$s->subaccesoriu.'</option>';
					}
				}
				?>
			</select>
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
						if ($m->id == $marca) { echo ' selected'; }
					echo '>'.$m->marca_auto.'</option>';
				}
			?>
		</select>
	</div>
					
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ALEGE_MODELUL'); ?>
	</div>
	
	<div id="sa_marca">
			<select name="model_auto" class="sa_select">
				<option value=""><?php echo JText::_('SAUTO_ALEGE_MODELUL_DORIT'); ?></option>
				<?php
				if ($marca != '') {
					$query = "SELECT * FROM #__sa_model_auto WHERE `mid` = '".$marca."' AND `published` = '1'";
					$db->setQuery($query);
					$modds = $db->loadObjectList();
					foreach ($modds as $m) {
						echo '<option value="'.$m->id.'"';
							if ($model_auto == $m->id) { echo ' selected'; }
						echo '>'.$m->model_auto.'</option>';
					}
				}
				?>
			</select>
		</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_IMAGINE'); ?>
	</div>
	<div>
	<input type="file" name="image_1" value="" class="sa_inputbox" />
	</div>
	<?php loadImg('', $multiple_id); ?>	
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ANUNT'); ?>
	</div>
	<div>
			<textarea 
				name="anunt7" id="anunt7" cols="60" rows="20" style="width: 500px; height: 150px;" class="mce_editable" aria-hidden="true">
			</textarea>
			</div>
	<div class="sauto_form_label sa_obligatoriu">
		<?php echo JText::_('SAUTO_CAMPURI_OBLIGATORII'); ?>
	</div>
	<br /><br /><br />
	
	<input type="hidden" name="request" value="7" />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_ADD_ANUNT_BUTTON'); ?>"  class="sauto_button" /><?php 		$link_renunt = JRoute::_('index.php?option=com_sauto&view=purge');		echo '<span class="sa_renunta">   '.JText::_('SAUTO_OR').' <a href="'.$link_renunt.'">'.JText::_('SAUTO_RENUNTA').'</a></span>'; ?>
	</div>
</form>

<script type="text/javascript">
		document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);

</script>
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