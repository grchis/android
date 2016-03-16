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
require_once('/mobile/edit_request_7_mobile.php');
}else{
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=editing'); 
$app =& JFactory::getApplication();
$user =& JFactory::getUser();
$uid = $user->id;
$id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );

$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$id."'";
$db->setQuery($query);
$rezult = $db->loadObject();
$editor =& JFactory::getEditor();
$image_path = JURI::base()."components/com_sauto/assets/users/".$uid."/";
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
		<input type="text" name="titlu_anunt" value="<?php echo $rezult->titlu_anunt; ?>" class="sa_inputbox" />
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
						if ($a->id == $rezult->accesorii_auto) { echo ' selected'; }
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
					$query = "SELECT * FROM #__sa_subaccesorii WHERE `acc_id` = '".$rezult->accesorii_auto."' AND `published` = '1' ORDER BY `subaccesoriu` ASC";
					$db->setQuery($query);
					$sacc = $db->loadObjectList();
					foreach ($sacc as $s) {
						echo '<option value="'.$s->id.'"';
							if ($rezult->subaccesorii_auto == $s->id) { echo ' selected'; }
						echo '>'.$s->subaccesoriu.'</option>';
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
						if ($m->id == $rezult->marca_auto) { echo ' selected'; }
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
					$query = "SELECT * FROM #__sa_model_auto WHERE `mid` = '".$rezult->marca_auto."' AND `published` = '1'";
					$db->setQuery($query);
					$modds = $db->loadObjectList();
					foreach ($modds as $m) {
						echo '<option value="'.$m->id.'"';
							if ($rezult->model_auto == $m->id) { echo ' selected'; }
						echo '>'.$m->model_auto.'</option>';
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
		<?php echo JText::_('SAUTO_IMAGINI_ANUNT'); ?>
	</div>
	<?php
	}
		//for ($i=1;$i<=$sconfig->max_img_anunt;$i++) {
		$query = "SELECT * FROM #__sa_poze WHERE `id_anunt` = '".$rezult->id."' ORDER BY `id` ASC";
		$db->setQuery($query);
		$pics = $db->loadObjectList();
		foreach ($pics as $p) {
			echo '<div><img src="'.$image_path.$p->poza.'" width="70" /></div>';
			echo '<div><input type="checkbox" name="delete_pic_'.$p->id.'" value="1" />'.JText::_('SAUTO_DELETE_IMAGINE_ANUNT').'</div>';
			//echo '>>>> '.$p->poza.'<br />';
	/*<div>
		<input type="file" name="image_<?php echo $i; ?>" value="" class="sa_inputbox" />
	</div>
	*/ 
	} 
	//verificam daca avem maxim 4 poze
	if ($all_pics < 5) {
		//incarcam o poza
		echo '<div class="sauto_form_label">';
		echo JText::_('SAUTO_ADD_NEW_IMAGINE');
		echo '</div>';
		echo '<div>';
		echo '<input type="file" name="image_1" value="" class="sa_inputbox" />';
		echo '</div>';
	}
	?>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_ANUNT'); ?>
	</div>
	<div>
			<?php
			echo $editor->display('anunt7', $rezult->anunt, '500', '150', '60', '20', false);
			?>
			</div>
	<br /><br /><br />	
	<input type="hidden" name="request" value="7" />
	<input type="hidden" name="anunt_id" value="<?php echo $id; ?>" />
	<div>
		<input type="submit" value="<?php echo JText::_('SAUTO_EDIT_ANUNT_BUTTON'); ?>"  class="sauto_button" />
	</div>
</form>
<?php } ?>