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
require_once('/mobile/edit_profile_d_profil_mobile.php');
}else{
$app =& JFactory::getApplication();
$app->setUserState('url_alert', 'profil');

$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();

$user =& JFactory::getUser();
$uid = $user->id;
$email = $user->email;
	
$query = "SELECT `p`.*, `u`.`email` FROM #__sa_profiles AS `p` JOIN #__users AS `u` ON `p`.`uid` = '".$uid."' AND `p`.`uid` = `u`.`id`";
$db->setQuery($query);
$profil = $db->loadObject();
$link_form = JRoute::_('index.php?option=com_sauto&view=editing_profile');

$img_path = JURI::base()."components/com_sauto/assets/images/";
?>
<form action="<?php echo $link_form; ?>" method="post" class="form-validate" enctype="multipart/form-data" id="m_table">
<?php echo JHtml::_( 'form.token' ); ?>
		<table width="100%" class="sa_table_class">
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<?php echo JText::_('SAUTO_FORM_COMPANY_NAME'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>	
						<?php echo $profil->companie; ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<?php echo JText::_('SAUTO_FORM_REPREZ_NAME'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>	
<input type="text" name="rnames" value="<?php echo $profil->reprezentant; ?>" class="required sa_inputbox" />
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<?php echo JText::_('SAUTO_FORM_EMAIL'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>
<input type="text" name="email" value="<?php echo $profil->email; ?>" class="required validate-email sa_inputbox" />
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<a onClick="toggle_visibility('change_pass');" class="sauto_ajax_link">
							<?php echo JText::_('SAUTO_FORM_CHANGE_PASSWORD'); ?>
						</a>	
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div id="change_pass" style="display:none;">
						<div class="sauto_form_label">
							<?php echo JText::_('SAUTO_FORM_NEW_PASS1'); ?>
						</div>
						<div>
							<input type="password" name="new_pass1" value="" class="sa_inputbox" />
						</div>
						<div class="sauto_form_label">
							<?php echo JText::_('SAUTO_FORM_NEW_PASS2'); ?>
						</div>
						<div>
							<input type="password" name="new_pass2" value="" class="sa_inputbox" />
						</div>		
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<?php echo JText::_('SAUTO_FORM_PHONE'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>
	<input type="text" name="phone" value="<?php echo $profil->telefon; ?>" class="required sa_inputbox" />
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<?php echo JText::_('SAUTO_FORM_COD_FISCAL'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>
						<?php echo $profil->cod_fiscal; ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<?php echo JText::_('SAUTO_FORM_NR_REG'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>
						<?php echo $profil->nr_registru; ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<?php echo JText::_('SAUTO_FORM_REGION'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>
						<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select">
							<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
							<?php
							$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
							$db->setQuery($query);
							$judete = $db->loadObjectList();
								foreach ($judete as $j) {
									echo '<option id="'.$j->id.'" ';
									if ($j->id == $profil->judet) { echo ' selected '; }
									echo '>'.$j->judet.'</option>';
								}
							?>
						</select>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<?php echo JText::_('SAUTO_FORM_CITY'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
				<div id="sa_city">
				<select name="city" class="sa_select">
					<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_CITY'); ?></option>
					<?php if ($profil->judet != '') {
						//aleg orasele
						$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$profil->judet."' AND `published` = '1'";
						$db->setQuery($query);
						$cities = $db->loadObjectList();
						foreach ($cities as $c) {
							echo '<option value="'.$c->id.'"';
								if ($profil->localitate == $c->id) { echo ' selected '; }
							echo '>'.$c->localitate.'</option>';
						}
					}  ?> 
				</select>
			</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_SEDIU'); ?></div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>
			<?php
			$editor =& JFactory::getEditor();
			echo $editor->display('sediu', $profil->sediu, '500', '150', '60', '20', false);
			?>
			</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
						<?php echo JText::_('SAUTO_DEALER_DOMENIU_ACT'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<?php
					//echo '>>>> '.$profil->categorii_activitate.'<br />';
					$cats = explode(",", $profil->categorii_activitate);
					$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
					$db->setQuery($query);
					$tip = $db->loadObjectList();
					?>
					<table class="sa_table_class" style="width:500px;">
					<tr>
						<td class="sa_factura_header"><?php echo JText::_('SAUTO_STATUS_TRANZ'); ?></td>
						<td class="sa_factura_header"><?php echo JText::_('SAUTO_DEALER_DOMENIU_ACT'); ?></td>
						<td class="sa_factura_header"><?php echo JText::_('SAUTO_EDIT_REQUEST'); ?></td>
					</tr>
					<?php
					foreach ($tip as $t) {
$link_alerts_edit = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_edit&id='.$t->id);
$link_alerts_enable = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_enable&id='.$t->id);
						$valoare = $t->id.'-1';
						echo '<tr class="sa_table_row">';
							echo '<td class="sa_table_cell">';
							if (in_array($valoare, $cats)) { 
								echo '<img src="'.$img_path.'check_yes.png" width="22" />'; 
							} else { 
								echo '<img src="'.$img_path.'check_no.png" width="22" />'; 
							}
							echo '</td>';	
							echo '<td class="sa_table_cell"v>'.$t->tip.'</td>';
							echo '<td class="sa_table_cell">';
							if (in_array($valoare, $cats)) { 
								echo '<a href="'.$link_alerts_edit.'">'.JText::_('SA_ALERTS_EDIT').'</a>'; 
							} else { 
								echo '<a href="'.$link_alerts_enable.'">'.JText::_('SA_ALERTS_ENABLE').'</a>'; 
							}
							echo '</td>';
						echo '</tr>';
					}
					echo '</table>';
					?>
				</td>
			</tr>

			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label">
					<?php echo JText::_('SAUTO_FORM_AVATAR'); ?>
					</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>
		<?php
		if ($profil->poza == '') {
			//fara avatar
			echo JText::_('SAUTO_FORM_NO_AVATAR_ADDED');
		} else {
			//avatar
			$path = JUri::base().'components/com_sauto/assets/users/'.$uid.'/';
			echo '<img src="'.$path.$profil->poza.'" width="150" border="0" />';
		}
		?>
	</div>
				</td>
			</tr>
			
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_NEW_AVATAR'); ?></div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
					<div>
		<input type="file" name="image" value="" />
	</div>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
				<?php if ($profil->poza != '') { ?>
	<div class="sauto_form_label">
		<?php echo JText::_('SAUTO_FORM_DELETE_AVATAR').' '; ?>
		<input type="checkbox" name="delete_avatar" value="1" />
	</div>
	<?php } ?>
				</td>
			</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell">
				<div class="sauto_form_label">
		<a onClick="toggle_visibility('delete_cont');" class="sauto_ajax_link">
			<?php echo JText::_('SAUTO_DELETE_ACCOUNT'); ?>
		</a>
	</div>
	<div id="delete_cont" style="display:none;">
		<input type="checkbox" name="delete_cont" value="1" />
		<?php echo JText::_('SAUTO_DELETE_THIS_ACCOUNT'); ?>
		<div class="sauto_warning"><?php echo JText::_('SAUTO_DELETE_ACCOUNT_WARNING'); ?></div>
	</div>
				</td>
			</tr>
	
			<tr class="sa_table_row">
				<td class="sa_table_cell">
				<input type="hidden" name="register_type" value="dealer" />
			<div><input type="submit" value="<?php echo JText::_('SAUTO_FORM_UPDATE_PROFILE_BUTTON'); ?>" class="sauto_button validate" /></div>
				</td>
			</tr>
		</table>
</form>
<?php } ?>