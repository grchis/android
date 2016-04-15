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

<div id="m_visitors">
    <form action="<?php echo $link_form; ?>" class="mobile-form" method="post" class="form-validate" enctype="multipart/form-data">
        <?php echo JHtml::_( 'form.token' ); ?>
        <p class="field-name"><?php echo JText::_('SAUTO_FORM_COMPANY_NAME'); ?></p>
        <input type="text" name="email" value="<?php echo $profil->companie; ?>" class="input-field" readonly/>

        <p class="field-name"><?php echo JText::_('SAUTO_FORM_REPREZ_NAME'); ?></p>
        <input type="text" name="rnames" value="<?php echo $profil->reprezentant; ?>" class="required input-field" />

        <p class="field-name"><?php echo JText::_('SAUTO_FORM_EMAIL'); ?></p>
        <input type="text" name="email" value="<?php echo $profil->email; ?>" class="required validate-email input-field" />

        <p class="field-name"><?php echo JText::_('SAUTO_FORM_NEW_PASS1'); ?></p>
        <input type="password" name="new_pass1" value="" class="input-field" />

        <p class="field-name"><?php echo JText::_('SAUTO_FORM_NEW_PASS2'); ?></p>
        <input type="password" name="new_pass2" value="" class="input-field" />

        <p class="field-name"><?php echo JText::_('SAUTO_FORM_PHONE'); ?></p>
        <input type="text" name="phone" value="<?php echo $profil->telefon; ?>" class="required input-field" />

        <p class="field-name"><?php echo JText::_('SAUTO_FORM_COD_FISCAL'); ?></p>
        <input type="text" name="email" value="<?php echo $profil->cod_fiscal; ?>" class="input-field" readonly/>

        <p class="field-name"><?php echo JText::_('SAUTO_FORM_NR_REG'); ?></p>
        <input type="text" name="email" value="<?php echo $profil->nr_registru; ?>" class="input-field" readonly/>

        <p class="field-name"><?php echo JText::_('SAUTO_FORM_SEDIU'); ?></p>
        <textarea name="sediu" id="sediu" cols="60" rows="20" style="width: 100%; height: 150px;" >
        </textarea>

        <?php
        if ($profil->poza == '') {
            //fara avatar
            echo '<p class="field-name no-avatar">'.JText::_('SAUTO_FORM_NO_AVATAR_ADDED').'</p>';
        } else {
            //avatar
            $path = JUri::base().'components/com_sauto/assets/users/'.$uid.'/';
            echo '<img class="avatar-pic" src="'. $path.$profil->poza .'" />';
        }
        ?>

        <div id="avatar-loader">Choose an avatar</div>
        <input id="hidden-file" type="file" name="image" value="" >

        <div id="submit" >Submit</div>
    </form>
    <?php
    $cats = explode(",", $profil->categorii_activitate);
    $query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
    $db->setQuery($query);
    $tip = $db->loadObjectList();
    ?>

    <div class="domain-container">
        <div class="domain-header">
            <div class="domain-status"> <?php echo JText::_('SAUTO_STATUS_TRANZ'); ?> </div>
            <div class="domain-description"> <?php echo JText::_('SAUTO_DEALER_DOMENIU_ACT'); ?> </div>
        </div>

        <div class="domain-content">
            <?php
            $cats = explode(",", $prf->categorii_activitate);
            foreach ($tip as $t) {
                $link_alerts_edit = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_edit&id=' . $t->id);
                $link_alerts_enable = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_enable&id=' . $t->id);
                $valoare = $t->id . '-1';
                $link = in_array($valoare, $cats) ? $link_alerts_edit : $link_alerts_enable;

                echo"<div class=\"domain-option\"><a href=\"" . $link . "\">";
                //pun imaginea daca e acceptat sau nu
                if (in_array($valoare, $cats)) {
                    echo "<div class=\"domain-status\"><img src=\"" . $img_path . "check_yes.png\" width=\"40px\" /></div>";
                } else {
                    echo "<div class=\"domain-status\"><img src=\"" . $img_path . "check_no.png\" width=\"40px\" /></div>";
                }

                echo '<div class="domain-description">' . $t->tip . '</div>';
                echo "</a></div>";
            }
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
        document.getElementById('avatar-loader').addEventListener("click", triggerHiddenFileInput);

        document.getElementById('submit').addEventListener("click", submitForm);

        function triggerHiddenFileInput(event){
            event.preventDefault();
            event.stopPropagation();

            document.getElementById('hidden-file').click();
        }

        function submitForm(event)
        {
            event.preventDefault();
            event.stopPropagation();
            var form = document.getElementsByTagName('form')[0];
            form.submit();
        }

        if (document.getElementsByTagName('h1')[0])
        {
            document.getElementsByTagName('h1')[0].remove();
        }
        if (document.getElementById("side_bar"))
        {
            document.getElementById("side_bar").remove();
        }
        if(document.getElementsByTagName('center')[0])
        {
            document.getElementsByTagName('center')[0].remove();
        }
        if(document.getElementById('gkTopBar'))
        {
            document.getElementById('gkTopBar').remove();
        }
        if(document.getElementById('m_table'))
        {
            document.getElementById('m_table').remove();
        }
        document.write('<style type="text/css" >#content9{width: 100% !important;' +
            'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
            'width: 100% !important;}</style>'
        );
</script>

<style type="text/css">
    .avatar-pic{
        width: 50%;
        margin-left: 25%;
        margin-bottom: 15px;
    }

    #hidden-file{
        display: none;
    }

    form.mobile-form, .domain-container{
        margin-left: 25px;
        margin-right: 5%;
        margin-top: 5%;
    }
    #avatar-loader{
        margin: 0px auto;
        margin-bottom: 25px;
        padding-top: 10px;
        text-align: center;
        height: 50px;
        background-color: #509EFF;
        color: white;
        font-size: 2.4em;
        padding-bottom: 10px;
    }
    p{
        margin: 0;
        font-size: 1.5em;
    }
    input.input-field, .read-only-value {
        margin-bottom: 25px;
        width: 99%;
    }
    p.field-name.no-avatar{
        font-size: 1.5em;
        text-align: center;
        margin-bottom: 20px;
        margin-top: 15px;
    }
    }
    .domain-option{
        margin-top: 15px;
    }
    .domain-status{
        display: inline-block;
        width: 20%;
        font-size: 1.4em;
        vertical-align: top;
    }
    .domain-description{
        display: inline-block;
        font-size: 1.6em;
        width: 78%;
        vertical-align: top;
    }
    textarea{
        margin-bottom: 25px;;
    }
</style>