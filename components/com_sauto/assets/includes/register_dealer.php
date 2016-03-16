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
$link_redirect = JUri::base().'components/com_sauto/assets/ajax/orase.php';
$document = JFactory::getDocument ();

require("javascript2.php");
$document->addScriptDeclaration ($js_code2);

require("verific_email2.php");
$document->addScriptDeclaration ($js_code_email);

require("cod_fiscal.php");
$document->addScriptDeclaration ($js_code5);

$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
//get article
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->login_article."'";
$db->setQuery($query);
$login_article = $db->loadResult();
$link_form = JRoute::_('index.php?option=com_sauto&view=registering');
JHTML::_('behavior.formvalidation');
$app =& JFactory::getApplication();
//print_r($_SESSION['firma']);
//echo '<pre>';
//var_dump($_SESSION);
//echo '</pre>';
$cod_fiscal = $app->getUserState('cod_fiscal');
$query = "SELECT * FROM #__sa_temp_firme WHERE `cui` = '".$cod_fiscal."'";
$db->setQuery($query);
$firms = $db->loadObject();

if ($firms->cui != '') {
	$pr_en = 1;
}
//print_r($firms);
if ($firms->firma != '') {
	$company_name = $firms->firma;
	$fill = $app->setUserState('filiala', '');
} else {
	$company_name = $app->getUserState('company_name');
}

if ($firms->nr_reg != '') {
	$nr_reg = $firms->nr_reg;
} else {
	$nr_reg = $app->getUserState('nr_reg');
}

if ($firms->sediu != '') {
	$sediu = $firms->sediu;
} else {
	$sediu = $app->getUserState('sediu');
}

if ($firms->phone != '') {
	$phone = $firms->phone;
} else {
	$phone = $app->getUserState('phone');
}

$rnames = $app->getUserState('rnames');
$email = $app->getUserState('email');
$pswd = $app->getUserState('pswd');

//obtin id judet
if ($firms->judet != '') {
	if ($firms->judet = "Municipiul București") {
		$judet = '9';
		//obtin loalitatea
		
	} else {
		
	}
	//verific si localitatea
	if ($firms->city != '') {
		$query = "SELECT `id` FROM #__sa_localitati WHERE `jid` = '".$judet."'";
		$db->setQuery($query);
		$city = $db->loadResult();
	} else {
		$city = $app->getUserState('city');
	}
} else {

}

if ($firms->cp != '') {
	$cp = $firms->cp;
} else {
	$cp = $app->getUserState('cp');
}

if ($email != '') {
	$v_mail = $email;
} else {
	//$v_mail = JText::_('SAUTO_EMAIL_CONFIDENTIAL');
	$v_mail = '';
}

$img_path = JURI::base()."components/com_sauto/assets/images/";
?>
<form action="<?php echo $link_form; ?>" method="post" class="form-validate" name="reg_form">
	<?php echo 
	JHtml::_( 'form.token' ); 
	?>
<table class="sa_table_class" width="100%">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" width="50%">
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_REPREZ_NAME'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div>	
			<input type="text" name="rnames" value="<?php echo $rnames; ?>" class="required sa_inputbox" />
			</div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_EMAIL'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div class="sauto_form_important">
				<?php echo JText::_('SAUTO_FORM_EMAIL_IMPORTANT'); ?>
			</div>
			
			
			<div>
				<input type="text" 
					name="email" 
					value="<?php echo $v_mail; ?>" 
					class="required validate-email sa_inputbox" 
					onKeyUp="javascript:verificEmail(this.value)" 
					onClick="select()"
					/>
			</div>
			
			
			<div id="sa_email_d"></div>
			
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_PASSWORD'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>			
			<div><input type="password" name="pass1" value="<?php echo $pswd; ?>" class="required sa_inputbox" /></div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_PASSWORD_RE'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>			
			<div><input type="password" name="pass2" value="<?php echo $pswd; ?>" class="required sa_inputbox" /></div>
						
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_COD_FISCAL'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div class="sauto_form_important">
				<?php echo JText::_('SAUTO_FORM_CF_IMPORTANT'); ?>
			</div>
			
			<div>	
			<input type="text" 
					name="cod_fiscal" 
					value="<?php echo $cod_fiscal; ?>" 
					class="required sa_inputbox"  
					onKeyUp="javascript:verificCui(this.value)"
					/>
			</div>
			
			
			
			<div id="sa_cf">
			<?php
			$fill = $app->getUserState('filiala');
			if ($fill == 1) {
				echo '<div>'.JText::_('SA_ESTE_FILIALA').' <input type="checkbox" name="filiala" value="1" checked /></div>';
			}			
			?>
			</div>
			
			
			<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_PRECOMPLETARE_FIRMA'); ?></div>
			<div><?php echo JText::_('SAUTO_FORM_PRECOMPLETARE_DETAIL'); ?></div>
			<div>
			<?php $link_form2 = JRoute::_('index.php?option=com_sauto&view=process&task=precompletare'); ?>
			<input type="submit" value="<?php echo JText::_('SAUTO_FORM_PRECOMPLETARE_ACUM'); ?>" class="sauto_button " onclick="reg_form.action='<?php echo $link_form2; ?>'; return true;" />
			</div>
			<?php /*<div class="sa_table_cell sa_phone sa_add_comment sa_cursor sa_hover">	
			<?php echo JText::_('SAUTO_FORM_PRECOMPLETARE_ACUM'); ?>
			</div>*/ ?>
			<br /><br />
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_COMPANY_NAME'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div>
				
			<input type="text" name="company_name" value="<?php echo $company_name; ?>" class="sa_inputbox" 
				<?php //if ($pr_en == 1) { echo ' disabled '; } ?>
			/>
			</div>
			
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_NR_REG'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div>
				
			<input type="text" name="nr_reg" value="<?php echo $nr_reg; ?>" class="sa_inputbox" 
				<?php //if ($pr_en == 1) { echo ' disabled '; } ?>
			/>
			</div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_REGION'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div>
				
			<select name="judet" onChange="javascript:aratOraseD(this.value)" class="sa_select"
				<?php //if ($pr_en == 1) { echo ' disabled '; } ?>
			>
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_REGION'); ?></option>
						<?php
						
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'"';
								if ($judet == $j->id) { echo ' selected '; }
							echo '>'.$j->judet.'</option>';
						}
						?>
						</select>
			</div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_CITY'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div id="sa_city_d">
				<select name="localitate" class="sa_select"
				<?php //if ($pr_en == 1) { echo ' disabled '; } ?>
				>
				<option value=""><?php echo JText::_('SAUTO_FORM_SELECT_CITY'); ?></option>
				<?php
				$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$judet."'  AND `published` = '1' ORDER BY `localitate` ASC";
				$db->setQuery($query);
				$cities = $db->loadObjectList();
				foreach ($cities as $c) {
					echo '<option value="'.$c->id.'"';
						if ($city == $c->id) { echo ' selected '; }
					echo '>'.$c->localitate.'</option>';
				}
				?>
				</select>
			</div>
			
			<?php if ($sconfig->enable_captcha == 1) { 
			require("components/com_sauto/assets/libraries/recaptchalib.php");
			$publickey = $sconfig->public_key;
			
			?>
			<div class="sauto_form_label"><?php echo JText::_('SAUTO_FORM_CAPTCHA'); ?></div>
			<div><?php echo recaptcha_get_html($publickey); ?></div>
			<?php } ?>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_SEDIU'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div>
			<?php
			$editor =& JFactory::getEditor();
			$params = array( 'smilies'=> '0' ,
                 'style'  => '1' ,  
                 'layer'  => '0' , 
                 'table'  => '0' ,
                 'clear_entities'=>'0'
                 );
			echo $editor->display( 'sediu', $sediu, '500', '150', '20', '20', false, $params );
			?>
			</div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_PHONE'); ?>
				<?php echo ' <span class="sa_obligatoriu">'.JText::_('SA_ASTERISC').'</span>'; ?>
			</div>
			
			<div><input type="text" name="phone" value="<?php echo $phone; ?>" class=" sa_inputbox" /></div>
			
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_FORM_ZIP_CODE'); ?>	
			</div>
			
			<div>
				<input type="text" name="cp" value="<?php echo $cp; ?>" class=" sa_inputbox" 
					<?php //if ($pr_en == 1) { echo ' disabled '; } ?>
				/>
			</div>
		</td>
		<td class="sa_table_cell" valign="top">
			<?php echo $login_article; ?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" colspan="2">
			<div class="sauto_form_label">
				<?php echo JText::_('SAUTO_ABONAMENTUL_DORIT'); ?>	
			</div>
			
			<div>
			<table class="sa_table_class">
				<tr class="sa_table_row">
				<?php
$query = "SELECT `a`.`id`, `a`.`abonament`, `a`.`pret`, `m`.`m_scurt` FROM #__sa_abonament AS `a` JOIN #__sa_moneda AS `m` 
		ON `a`.`moneda` = `m`.`id`";
$db->setQuery($query);
$abn = $db->loadObjectList();
				foreach ($abn as $a) {
					if ($a->pret == 0) {
						//gratuit
						$pret = JText::_('SAUTO_GRATUIT');
					} else {
						//
						$pret = $a->pret.' '.$a->m_scurt;
					}
					if ($a->id == 1) {
						//h2o
						$imagine_abn = 'ab_h2o.png';
					} elseif ($a->id == 2) {
						//motorina
						$imagine_abn = 'ab_diesel.png';
					} elseif ($a->id == 3) {
						//kerosen
						$imagine_abn = 'ab_kerosen.png';
					}
					?>
					<td class="sa_table_cell" valign="top" width="28%">
<div class="sa_abn_border">					
<table class="sa_table_class" >
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" width="35%">
			<img src="<?php echo $img_path.$imagine_abn; ?>" />
		</td>
		<td class="sa_table_cell" valign="top">
			<br />
			<?php
			for ($i=1;$i<5;$i++) {
				if (($i==1) or ($i==2)) {
					$ck_img = 'boxselectat.png';
				} else {
					if ($a->id == 3) {
						$ck_img = 'boxselectat.png';	
					} else {
						$ck_img = 'box.png';
					}
				}
				?>
				<div>
					<img src="<?php echo $img_path.$ck_img; ?>" />
					<span class="sa_abon_span">
						<?php echo JText::_('SAUTO_ABONAMENT_'.$i); ?>
					</span>
				</div>
			<?php
			}
			?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td class="sa_table_cell" colspan="2" align="center">
			<input type="radio" name="abonament_value" value="<?php echo $a->id; ?>" 
			<?php if ($a->id == 1) { echo ' checked '; } ?>
			/>
			<span class="sa_reg_abon"><?php echo JText::_('SAUTO_SELECT_ABONAMENT_BUTTON'); ?></span>		
		</td>
	</tr>
</table>
</div>					
					</td>
					<?php
				}
				?>
				</tr>
			</table>
			</div>
		</td>
	</tr>
	<tr>
		<td class="sa_table_cell" valign="top">
			
			<div class="sauto_form_label sa_obligatoriu">
				<?php echo JText::_('SAUTO_CAMPURI_OBLIGATORII'); ?>
			</div>
			
			<div class="sauto_form_label">
			<input type="checkbox" name="agree" value="1" checked />
			<?php 
			echo JText::_('SAUTO_ABONARE_NEWSLETTER'); ?>
			</div>
			
			<div class="sauto_form_label">
			<input type="checkbox" name="agree" value="1" checked />
			<?php 
			$link_term = JRoute::_('index.php?option=com_content&view=article&id='.$sconfig->link_terms);
			echo '<a href="'.$link_term.'" class="sauto_link_terms" target="_blank">'.JText::_('SAUTO_AGREE_WITH_TERMS').'</a>'; ?>
			</div>
			<br />
			<input type="hidden" name="register_type" value="dealer" />
			<div>
			
			<input type="submit" value="<?php echo JText::_('SAUTO_FORM_REGISTER_BUTTON'); ?>" class="sauto_button validate" onclick="this.form;return true;" />
			</div>

		
		</td>
		<td class="sa_table_cell" valign="top">
		<?php //zona 2 ?>
		</td>
	</tr>
</table>
</form>


