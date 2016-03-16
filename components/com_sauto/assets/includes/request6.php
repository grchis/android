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
require_once('/mobile/request6_mobile.php');
}else{
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=adding'); 
$app =& JFactory::getApplication();

$titlu_anunt = $app->getUserState('titlu_anunt');
$marca = $app->getUserState('marca');
$model_auto = $app->getUserState('model_auto');
$new_marca = $app->getUserState('new_marca');
$an_fabricatie = $app->getUserState('an_fabricatie');
$cilindree = $app->getUserState('cilindree');
$carburant = $app->getUserState('carburant');
$caroserie = $app->getUserState('caroserie');
$serie_caroserie = $app->getUserState('serie_caroserie');
$new_model = $app->getUserState('new_model');
$price = $app->getUserState('price');

require("function_load_img.php");
$multiple_id = 0;

?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
<div>
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL6'); ?></h2>
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_TITLU_ANUNT'); ?>
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="<?php echo $titlu_anunt; ?>" class="sa_inputbox" />
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_MARCA_AUTO'); ?>
	</div>
	
	
	<div>
		<select name="marca" onChange="javascript:aratMarca(this.value)">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_MARCA'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_marca_auto ORDER BY `marca_auto` ASC";
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
		<a onClick="toggle_visibility('add_marca6');" class="sauto_ajax_link">
		<?php echo JText::_('SAUTO_ADD_MARCA_NOUA'); ?>
		</a>	
	</div>
	<?php if ($new_marca == '') { $style_1 = 'display:none;'; } else { $style_1 = 'display:block;'; } ?>
	<div id="add_marca6" style="<?php echo $style_1; ?>">
		<input type="text" name="new_marca" value="<?php echo $new_marca; ?>" class="sa_inputbox" />
	</div>
					
	<div class="sauto_form_label"><?php echo JText::_('SAUTO_ALEGE_MODELUL'); ?></div>
		<div id="sa_marca">
			<select name="model_auto">
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
			<br />
			<div class="sauto_form_label">
				<a onClick="toggle_visibility('add_model6');" class="sauto_ajax_link">
					<?php echo JText::_('SAUTO_ADD_MODEL_NOU'); ?>
				</a>
			</div>
			<?php if ($new_model == '') { $style_2 = 'display:none;'; } else { $style_2 = 'display:block;'; } ?>
			<div id="add_model6" style="<?php echo $style_2; ?>">
				<input type="text" name="new_model" value="<?php echo $new_model; ?>" class="sa_inputbox" />
			</div>
		</div>
					
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_AN_FABRICATIE'); ?>
	</div>
	<div>
		<select name="an_fabricatie">
			<option value=""><?php echo JText::_('SAUTO_SELECT_AN_FABR'); ?></option>
			<?php
			$an = date("Y", mktime());
			for ($i=$an;$i>='1950';$i--) {
				echo '<option value="'.$i.'"';
					if ($i == $an_fabricatie) { echo ' selected';}
				echo '>'.$i.'</option>';
			}
			?>
		</select>
	</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CILINDREE'); ?>
	</div>
	<div>
		<input type="text" name="cilindree" value="<?php echo $cilindree; ?>" class="sa_inputbox" />
	</div>
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CARBURANT'); ?>
	</div>
	<div>
		<select name="carburant">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_CARBURANT'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_carburant ORDER BY `carburant` ASC";
			$db->setQuery($query);
			$carb = $db->loadObjectList();
			foreach ($carb as $c) {
				echo '<option value="'.$c->id.'"';
					if ($c->id == $carburant) { echo ' selected'; }
				echo '>'.$c->carburant.'</option>';
			}
			?>
		</select>
	</div>
		
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_CAROSERIE'); ?>
	</div>
	<div>
		<select name="caroserie">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_CAROSERIE'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_caroserie ORDER BY `caroserie` ASC";
			$db->setQuery($query);
			$caros = $db->loadObjectList();
			foreach ($caros as $cr) {
				echo '<option value="'.$cr->id.'"';
					if ($cr->id == $caroserie) { echo ' selected'; }
				echo '>'.$cr->caroserie.'</option>';
			}
			?>
		</select>
	</div>
				
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_SERIE_CAROSERIE'); ?>
	</div>
	<div>
		<input type="text" name="serie_caroserie" value="<?php echo $serie_caroserie; ?>" class="sa_inputbox" />
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
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('anunt6', '', '300', '150', '60', '20', false);
			?>
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
	<input type="hidden" name="request" value="6" />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_ADD_ANUNT_BUTTON'); ?>"  class="sauto_button" />
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