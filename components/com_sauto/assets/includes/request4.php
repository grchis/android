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
require_once('/mobile/request4_mobile.php');
}else{
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();

//obtin date de profil
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->loadObject();

$link_form = JRoute::_('index.php?option=com_sauto&view=adding'); 
$app =& JFactory::getApplication();

$titlu_anunt = $app->getUserState('titlu_anunt');
$marca = $app->getUserState('marca');
$model_auto = $app->getUserState('model_auto');
$an_fabricatie = $app->getUserState('an_fabricatie');
$cilindree = $app->getUserState('cilindree');
$carburant = $app->getUserState('carburant');
$nr_usi = $app->getUserState('nr_usi');
$caroserie = $app->getUserState('caroserie');
$stare = $app->getUserState('stare');
$anunt = $app->getUserState('anunt');

$buget_min = $app->getUserState('buget_min');
$buget_max = $app->getUserState('buget_max');
$buget_moneda = $app->getUserState('buget_moneda');

require("function_load_img.php");
$multiple_id = 0;
?>
<form action="<?php echo $link_form; ?>" method="post" enctype="multipart/form-data">
<div>
		<h2><?php echo JText::_('SAUTO_TIP_ANUNT').' '.JText::_('SAUTO_TIP_ANUNT_DETAIL4'); ?></h2>
	</div>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_TITLU_ANUNT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<input type="text" name="titlu_anunt" value="<?php echo $titlu_anunt; ?>" class="sa_inputbox" />
	</div>
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_MARCA_AUTO'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	
	<div>
		<select name="marca" onChange="javascript:aratMarca(this.value)" class="sa_select">
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
		<?php echo JText::_('SAUTO_ALEGE_MODELUL'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
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
		<?php echo JText::_('SAUTO_FORM_REGION'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div>
			<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select">
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'"';
								if ($j->id == $profil->judet) { echo ' selected '; }
							echo '>'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
			
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_CITY'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	
	<div id="sa_city">
				<?php if ($profil->judet == '') { ?>
				<select name="none" class="sa_select"><option value=""><?php echo JText::_('SAUTO_FORM_SELECT_CITY'); ?></option></select>
				<?php 
				} else { 
					//obtin localitatile judetului selectat
					$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$profil->judet."' AND `published` = '1' ORDER BY `localitate` ASC";
					$db->setQuery($query);
					$cities = $db->loadObjectList();
					echo '<select name="localitate" class="sa_select">';
						echo '<option value="">'.JText::_('SAUTO_FORM_SELECT_CITY').'</option>';
						foreach ($cities as $c) {
							echo '<option value="'.$c->id.'"';
								if ($c->id == $profil->localitate) { echo ' selected '; }
							echo '>'.$c->localitate.'</option>';
						}
					echo '</select>'; 
				} ?> 
				
			</div>
			
					
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_AN_FABRICATIE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<select name="an_fabricatie" class="sa_select">
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
		<select name="carburant" class="sa_select">
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
		<?php echo JText::_('SAUTO_NR_USI'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
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
					if ($u->id == $nr_usi) { echo ' selected'; }
				echo '>'.$u->usi.'</option>';
			}
			?>
		</select>
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
		<?php echo JText::_('SAUTO_STARE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<select name="stare" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_STARE'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_stare_auto ORDER BY `stare` ASC";
			$db->setQuery($query);
			$stare_q = $db->loadObjectList();
			foreach ($stare_q as $st) {
				echo '<option value="'.$st->id.'"';
					if ($st->id == $stare) { echo ' selected'; }
				echo '>'.$st->stare.'</option>';
			}
			?>
		</select>
	</div>
	
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_STATUS_ACTE'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<select name="status" class="sa_select">
			<option value=""><?php echo JText::_('SAUTO_ALEGE_STATUS'); ?></option>
			<?php
			$query = "SELECT * FROM #__sa_status_acte WHERE `published` = '1' ORDER BY `status` ASC";
			$db->setQuery($query);
			$status = $db->loadObjectList();
			foreach ($status as $sts) {
				echo '<option value="'.$sts->id.'"';
					//if ($sts->id == $stare) { echo ' selected'; }
				echo '>'.$sts->status.'</option>';
			}
			?>
		</select>
	</div>
	
	
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_BUGET_ALOCAT'); ?>
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
		<?php echo JText::_('SAUTO_INTRE').' '; ?>
		<input type="text" name="buget_min" value="<?php echo $buget_min; ?>" size="18" />
		<?php echo ' '.JText::_('SAUTO_SI').' '; ?>
		<input type="text" name="buget_max" value="<?php echo $buget_max; ?>" size="18" />
		<select name="buget_moneda">
			<?php
			$query = "SELECT * FROM #__sa_moneda WHERE `published` = '1'";
			$db->setQuery($query);
			$monede = $db->loadObjectList();
			foreach ($monede as $mons) {
				echo '<option value="'.$mons->id.'"';
					if ($buget_moneda == $mons->id) { echo ' selected '; }
				echo '>'.$mons->m_scurt.'</option>';
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
		<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
	</div>
	<div>
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('anunt4', $anunt, '500', '150', '60', '20', false);
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
	<br /><br />	*/ ?>	
	<input type="hidden" name="request" value="4" />
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