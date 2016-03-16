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
$img_path = JURI::base()."components/com_sauto/assets/images/";
$link_form = JRoute::_('index.php?option=com_sauto&view=pay');
//obtin tipul de abonament al firmei
$query = "SELECT `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$abonament = $db->loadResult();

//verificam daca avem fcaturi proforme generate in ultimele 15 zile
//timestamp 15 zile: 1296000
$time = time();
$old_date = $time - 1296000;
//echo 'data actuala: '.$time.'   si data cu 15 zile in urma: '.$old_date;
$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."' AND `tip_abn` = '2' AND `data_prf` > '".$old_data."'";
$db->setQuery($query);
$total_2 = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."' AND `tip_abn` = '3' AND `data_prf` > '".$old_data."'";
$db->setQuery($query);
$total_3 = $db->loadResult();
//echo '>>>> '.$total_2.' >>>> '.$total_3; 
?>

<table width="100%" class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td valign="top" width="120" class="sa_table_cell"><img src="<?php echo $img_path; ?>ab_kerosen.png" /></td>
		<td valign="top" class="sa_table_cell">
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_1'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_2'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_3'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_4'); ?>
				</span>
			</div>
		</td>
		<td valign="top" class="sa_table_cell">
			
			<?php if ($abonament != 3) { ?>
			<form action="<?php echo $link_form; ?>" method="post" name="submit_kerosen" class="sa_submit_div">
				<div>
				<?php echo JText::_('SAUTO_METODA_PLATA'); ?>
			</div>
			<div>
			<select name="procesator">
			<?php
			if ($total_3 != 0) {
			$query = "SELECT * FROM #__sa_plati WHERE `published` = '1' AND `id` != '1'";
			} else {
			$query = "SELECT * FROM #__sa_plati WHERE `published` = '1'";
			}
			$db->setQuery($query);
			$plati = $db->loadObjectList();
			foreach ($plati as $p) {
				echo '<option value="'.$p->id.'">'.$p->procesator.'</option>';
			}
			?>
			</select>
			<input type="hidden" name="plata_pentru" value="abonament" />
			<input type="hidden" name="tip_abonament" value="3" />
			</div>
			<div style="margin-top:10px;" onClick="document.forms['submit_kerosen'].submit();">
			<img src="<?php echo $img_path; ?>icon_bifa_inactiva.png" />
			</div>
			</form>
			<?php } else {
				echo '<div class="sa_submit_div_nc"><img src="'.$img_path.'icon_bifa_activa.png" /></div>';
			} 
			if ($total_3 != 0) {
					echo '<div class="sa_submit_div_nc">'.JText::_('SAUTO_FACTURA_PROFORMA_GENERATA').'</div>';
					}
			?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td colspan="3" class="sa_table_cell"><hr /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><img src="<?php echo $img_path; ?>ab_diesel.png" /></td>
		<td valign="top" class="sa_table_cell">
		<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_1'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_2'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_3'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_4'); ?>
				</span>
			</div>
		</td>
		<td valign="top" class="sa_table_cell">
			<?php 
			if ($abonament != 2) { 
				if ($abonament == 3) {
					echo '<div class="sa_submit_div_nc"><img src="'.$img_path.'icon_bifa_inactiva.png" /></div>';
				} else { 
				?>
			<form action="<?php echo $link_form; ?>" method="post" name="submit_motorina" class="sa_submit_div">
				<div>
				<?php echo JText::_('SAUTO_METODA_PLATA'); ?>
			</div>
			<div>
			<select name="procesator">
			<?php
			if ($total_2 != 0) {
			$query = "SELECT * FROM #__sa_plati WHERE `published` = '1' AND `id` != '1'";
			} else {
			$query = "SELECT * FROM #__sa_plati WHERE `published` = '1'";
			}
			$db->setQuery($query);
			$plati = $db->loadObjectList();
			foreach ($plati as $p) {
				echo '<option value="'.$p->id.'">'.$p->procesator.'</option>';
			}
			?>
			</select>
			<input type="hidden" name="plata_pentru" value="abonament" />
			<input type="hidden" name="tip_abonament" value="2" />
			</div>
			<div style="margin-top:10px;" onClick="document.forms['submit_motorina'].submit();">
			<img src="<?php echo $img_path; ?>icon_bifa_inactiva.png" />
			</div>
			</form>
			<?php 
					
				}
			} else {
				echo '<div class="sa_submit_div_nc"><img src="'.$img_path.'icon_bifa_activa.png" /></div>';
			} 
			
			if ($total_2 != 0) {
					echo '<div class="sa_submit_div_nc">'.JText::_('SAUTO_FACTURA_PROFORMA_GENERATA').'</div>';
					}
			?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td colspan="3" class="sa_table_cell"><hr /></td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell"><img src="<?php echo $img_path; ?>ab_h2o.png" /></td>
		<td valign="top" class="sa_table_cell">
		<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_5'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_2'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_3'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_4'); ?>
				</span>
			</div>
		</td>
		<td valign="top" class="sa_table_cell">
			<?php if ($abonament != 1) { ?>
			<div class="sa_submit_div_nc"><img src="<?php echo $img_path; ?>icon_bifa_inactiva.png" /></div>
			<?php } else {
				echo '<div class="sa_submit_div_nc"><img src="'.$img_path.'icon_bifa_activa.png" /></div>';
			} ?>
		</td>
	</tr>
</table>

<div id="m_visitors">
	<div id="abon1">
		<img class="subscribe-pic" src="<?php echo $img_path; ?>ab_kerosen.png" />
		<div class="check-boxes-subscribe">
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_1'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_2'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_3'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_4'); ?>
				</span>
			</div>
		</div>	
	</div>
	<div id="abon2">
		<img class="subscribe-pic" src="<?php echo $img_path; ?>ab_kerosen.png" />
		<div class="check-boxes-subscribe">
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_1'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_2'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_3'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_4'); ?>
				</span>
			</div>
		</div>
	</div>
	<div id="abon3">
		<img class="subscribe-pic" src="<?php echo $img_path; ?>ab_kerosen.png" />
		<div class="check-boxes-subscribe">
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_5'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_2'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_3'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_4'); ?>
				</span>
			</div>
		</div>
	</div>

	<div id="payment">
		in progress
	</div>
</div>

<script type="text/javascript">
    var isMobile = navigator.userAgent.contains('Mobile');
    if (!isMobile) {
        document.getElementById('m_visitors').remove();
        window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>');
    }else {
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
    }
</script>

<style type="text/css">
	.check-boxes-subscribe {
		display: inline-block;
		vertical-align: top;
		margin-top: 15px;
	}
	.subscribe-pic {
		display: inline-block;
	}
</style>
