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
$img_path = JURI::base()."components/com_sauto/assets/images/";
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
//profile...
$query = "SELECT `p`.`fullname`, `p`.`data_abonare`, `a`.`abonament`, `a`.`id`, `p`.`abonament` AS `abn` FROM #__sa_profiles as `p` JOIN #__sa_abonament as `a` ON `p`.`uid` = '".$uid."' AND `p`.`abonament` = `a`.`id`";
$db->setQuery($query);
$profil = $db->loadObject();

$query = "SELECT `credite` FROM #__sa_financiar WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$credite = $db->loadResult();

//$data_abon = $profil->data_abonare;
$data_exp = $profil->data_abonare + 15811200;
$data_exp = date('Y-m-d', $data_exp);
//echo 'data exp in > '.$data_exp;
?>
<table width="100%" class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td valign="top" width="60%" class="sa_table_cell">
			<div class="sa_financiar_title">
				<?php echo JText::_('SAUTO_CREDITELE_MELE'); ?>
			</div>
			<div>
			<img src="<?php echo $img_path; ?>icon_financiar_mic.png" />
				<span style="position:relative;top:-10px;">
					<?php echo JText::_('SAUTO_CREDITE_DISPONIBILE').': '.$credite; ?>
				</span>
			</div>
			<?php
			if (($profil->abn == 2) OR ($profil->abn == 3)) {
			echo '<div class="sa_necontorizat">'.JText::_('SAUTO_CREDITE_NECONTORIZATE').'</div>';
			}
			?>
			<div>
			<?php 
			//ultima reincarcare
			$query = "SELECT `data_tr` FROM #__sa_facturi WHERE `uid` = '".$uid."' ORDER BY `id` DESC LIMIT 0, 1";
			$db->setQuery($query);
			$ultima_reinc = $db->loadResult();
			if ($ultima_reinc == '') {
				$ultima = JText::_('SAUTO_NICI_O_REINCARCARE');
			} else {
				$data_cump = explode(" ", $ultima_reinc);
				$ultima = $data_cump[0];
			}
			echo JText::_('SAUTO_ULTIMA_INCARCARE').': '.$ultima; ?>
			</div>
			<div>
				<?php
				echo JText::_('SAUTO_TAB_ABONAMENT').': '.$profil->abonament;
				if ($profil->abn != 1) {
					echo '<br />'.JText::sprintf('SAUTO_ABN_EXPIRA_IN', $data_exp);
				}
				?>
			</div>
			<div>
			<?php
			$query = "SELECT count(*) FROM #__sa_financiar_det WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$total_tranz = $db->loadResult();
			echo JText::_('SAUTO_TRANZACTII_EFECTUATE').': '.$total_tranz;
			?>
			</div>
			<div>
				<table width="100%" class="sa_table_class">
					<thead>
						<td class="sa_fin_table_data">#</td>
						<td class="sa_fin_table_data"><?php echo JText::_('SAUTO_DATA_TRANZ'); ?></td>
						<td class="sa_fin_table_data"><?php echo JText::_('SAUTO_TRANZ_DET'); ?></td>
						<td class="sa_fin_table_data">+</td>
						<td class="sa_fin_table_data">-</td>
					</thead>
					<?php
					//query tranzactii
					if ($total_tranz == 0) {
					?>
					<tr class="sa_table_row">
						<td colspan="5" class="sa_table_cell"><?php echo JText::_('SAUTO_NU_AVETI_TRANZACTII'); ?></td>
					</tr>
					<?php } else { 
						$i = 1;
						//lista de tranzactii....
						$query = "SELECT * FROM #__sa_financiar_det WHERE `uid` = '".$uid."' ORDER BY `id` DESC LIMIT 0, 20";
						$db->setQuery($query);
						$tranz = $db->loadObjectList();
						foreach ($tranz as $t) {
							echo '<tr class="sa_table_row">';
								echo '<td class="sa_fin_table_data2">'.$i.'</td>';
								$data_t = explode(" ", $t->data_tranz);
								echo '<td class="sa_fin_table_data2">'.$data_t[0].'</td>';
								if ($t->anunt_id != 0) {
									$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$t->anunt_id); 
									echo '<td class="sa_fin_table_data2"><a href="'.$link_anunt.'">'.JText::_('SAUTO_APLICARE_OFERTA').'</a></td>';
								} else {
									//cumparare credite
									echo '<td class="sa_fin_table_data2">';
									if ($t->cumparare != 'abon_nou') {
											echo JText::_('SAUTO_CUMPARARE_CREDITE');
										} else {
											if ($t->cumparare != 'update') {
												echo JText::_('SAUTO_ABONAMENT_NOU');
											} else {
												echo JText::_('SAUTO__UPDATE_ABONAMENT');
											}
										}
									echo '</td>';
								}
								if ($t->cumparare == '') {
									//nu afisam nimic
									echo '<td class="sa_fin_table_data2"></td>';
									echo '<td class="sa_fin_table_data2">2</td>';
								} else {
									//afisam creditele cumparate
									echo '<td class="sa_fin_table_data2">';
									echo $t->credite;	
									echo '</td>';
									echo '<td class="sa_fin_table_data2"></td>';
								}
							echo '</tr>';
							$i++;
						}
					}	?>
				</table>
			</div>
			
			<div>
				<?php
				//query facturi
				$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."'";
				$db->setQuery($query);
				$total_fact = $db->loadResult();
				
				?>
				<div>
				<?php echo JText::_('SAUTO_TOTAL_FACTURI').': '.$total_fact; ?>
				</div>
				<table width="100%" class="sa_table_class">
					<thead>
						<td class="sa_fin_table_data">#</td>
						<td class="sa_fin_table_data"><?php echo JText::_('SAUTO_DATA_TRANZ'); ?></td>
						<td class="sa_fin_table_data"><?php echo JText::_('SAUTO_TITLU_TRANZ'); ?></td>
						<td class="sa_fin_table_data"><?php echo JText::_('SAUTO_STATUS_TRANZ'); ?></td>
						<td class="sa_fin_table_data"><?php echo JText::_('SAUTO_CREDITE_TRANZ'); ?></td>
					</thead>
					<?php
					if ($total_fact == 0) {
						?>
						<tr class="sa_table_row">
							<td colspan="5" class="sa_table_cell"><?php echo JText::_('SAUTO_NU_AVETI_FACTURI'); ?></td>
						</tr>
					<?php
				} else {
					//afisare facturi
					$query = "SELECT * FROM #__sa_facturi WHERE `uid` = '".$uid."' ORDER BY `id` DESC LIMIT 0, 10";
					
					//$query = "SELECT `f`.`factura`, `f`.`data_tr`, `f`.`status_tr`, `f`.`tip_plata` FROM #__sa_facturi as `f` WHERE `f`.`uid` = '".$uid."'  ORDER BY `f`.`id` DESC LIMIT 0, 10";
					$db->setQuery($query);
					//echo $query;
					$facts = $db->loadObjectList();
					$z = 1;
					foreach ($facts as $f) {
						echo '<tr class="sa_table_row">';
							echo '<td class="sa_fin_table_data2">'.$z.'</td>';
							//get data
							$data_t = explode(" ", $f->data_tr);
							echo '<td class="sa_fin_table_data2">'.$data_t[0].'</td>';
							echo '<td class="sa_fin_table_data2">';
								if ($f->tip_plata == 'credit') {
									echo JText::_('SAUTO_CUMPARARE_CREDITE');
								} elseif ($f->tip_plata == 'abon') {
									echo JText::_('SAUTO_ABONAMENT_NOU');
								} else {
									echo JText::_('SAUTO__UPDATE_ABONAMENT');
								}
							echo '</td>';
							echo '<td class="sa_fin_table_data2">';
								if ($f->status_tr == 1) {
									//platit
									echo JText::_('SAUTO_STATUS_PLATIT');
								} else {
									//in asteptare
									echo JText::_('SAUTO_STATUS_NEPLATIT');
								}
							echo '</td>';
							echo '<td class="sa_fin_table_data2">'.$f->credite.'</td>';
						echo '</tr>';
						$z++;
					}
				} 
					?>
				</table>
			</div>

		</td>
		<td valign="top" class="sa_table_cell">
		<div style="margin-left:10px;">
			<div class="sa_financiar_title">
				<?php echo JText::_('SAUTO_CUMPAR_CREDITE'); ?>
			</div>
			<div style="text-align:center;">
				<img src="<?php echo $img_path; ?>icon_financiar.png" />
			</div>
			<?php 
			//$link_form = JRoute::_('index.php?option=com_sauto&view=credits'); 
			$link_form = JRoute::_('index.php?option=com_sauto&view=pay');
			?>
			<form action="<?php echo $link_form; ?>" method="post">
			<div>
			<?php echo JText::_('SAUTO_NR_CREDITE_DORIT'); ?>
			</div>
			<div>
			<input type="text" name="credite" value="" />
			</div>
			<div>
				<?php echo JText::_('SAUTO_METODA_PLATA'); ?>
			</div>
			<div>
			<select name="procesator">
			<?php
			$query = "SELECT * FROM #__sa_plati WHERE `published` = '1'";
			$db->setQuery($query);
			$plati = $db->loadObjectList();
			foreach ($plati as $p) {
				echo '<option value="'.$p->id.'">'.$p->procesator.'</option>';
			}
			?>
			</select>
			</div>
			<div>
			<img src="<?php echo $img_path; ?>icon_financiar_mic.png" />
				<span style="position:relative;top:-10px;">
					<?php echo JText::_('SAUTO_VALOARE_CREDITE'); ?>
				</span>
			</div>
			<div>
				<?php if ($profil->id != 1) { echo JText::_('SAUTO_INTERZIS_CREDITE').'<br />'; } ?>
				<input type="hidden" name="plata_pentru" value="puncte" />
				<input type="submit" value="<?php echo JText::_('SAUTO_CUMPARA_CREDITE_BUTTON'); ?>" 
				<?php if ($profil->id != 1) { echo 'disabled'; } ?>
				/>
			</div>
			</form>
		</div>
		</td>
	</tr>
</table>

<div class="m_visitors_child">
	<p><strong><?php echo JText::_('SAUTO_CREDITELE_MELE'); ?></strong></p>
	<div>
		<img src="<?php echo $img_path; ?>icon_financiar_mic.png" />
		<span style="position:relative;top:-10px;">
			<?php echo JText::_('SAUTO_CREDITE_DISPONIBILE').': '.$credite; ?>
		</span>
	</div>
	<p> <?php echo JText::_('SAUTO_ULTIMA_INCARCARE').': '.$ultima; ?> </p>
	<p> <?php echo JText::_('SAUTO_TAB_ABONAMENT').': '.$profil->abonament; ?></p> 
	<p>
	<?php
		$query = "SELECT count(*) FROM #__sa_financiar_det WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$total_tranz = $db->loadResult();
		echo JText::_('SAUTO_TRANZACTII_EFECTUATE').': '.$total_tranz;
	?>
	</p>

	<div id="tranz-container">
		<div class="tranz-container-header">
			<span class="noCrt">#</span>
			<span class="date_tr"><?php echo JText::_('SAUTO_DATA_TRANZ'); ?></span>
			<span class="title_tr"><?php echo JText::_('SAUTO_TRANZ_DET'); ?></span>
			<span class="status_tr">+</span>
			<span class="noCredits_tr"> - </span>
		</div>
		<div class="tranz-items-container">
			<?php
			$query = "SELECT count(*) FROM #__sa_financiar_det WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$tranz = $db->loadObjectList();
			$i = 1;
			
			foreach ($tranz as $t) { 
				$data_t = explode(" ", $t->data_tranz);
				$tranzactie;
				if ($t->anunt_id != 0) { 
					$tranzactie = '<a href="'.$link_anunt.'"">'.JText::_('SAUTO_APLICARE_OFERTA').'</a>';
				} elseif ($t->cumparare != 'abon_nou') {
					$tranzactie = JText::_('SAUTO_CUMPARARE_CREDITE');
				} elseif ($t->cumparare != 'update') {
					$tranzactie = JText::_('SAUTO_ABONAMENT_NOU');
				} else {
					$tranzactie = JText::_('SAUTO__UPDATE_ABONAMENT');
				}
				$cumparare;
				if ($t->cumparare == ''){
					$cumparare = $t->credite;
				}?>
				<div>
					<span class="noCrt"><?php echo $i ?></span>
					<span class="date_tr"><?php echo $data_t[0] ?></span>
					<span class="title_tr"><?php echo $tranzactie ?></span>
					<span class="status_tr"> <?php echo $cumparare ?> </span>
					<span class="noCredits_tr"></span>
				</div>
			<?php } ?>
		</div>
	</div>

	<div id="fact-container">
		<div class="tranz-container-header">
			<span class="noCrt">#</span>
			<span class="date_tr"><?php echo JText::_('SAUTO_DATA_TRANZ'); ?></span>
			<span class="title_tr"><?php echo JText::_('SAUTO_TITLU_TRANZ'); ?></span>
			<span class="status_tr"><?php echo JText::_('SAUTO_STATUS_TRANZ'); ?></span>
			<span class="noCredits_tr"><?php echo JText::_('SAUTO_CREDITE_TRANZ'); ?></span>
		</div>
		<div class="tranz-items-container">
			<?php
			$query = "SELECT * FROM #__sa_facturi WHERE `uid` = '".$uid."' ORDER BY `id` DESC LIMIT 0, 10";
			$db->setQuery($query);
			$fact = $db->loadObjectList();
			$i = 1;
			
			foreach ($fact as $f) { 
				$data_t = explode(" ", $f->data_tr); 
				$status;
				if ($f->status_tr == 1) {
					//platit
					$status = JText::_('SAUTO_STATUS_PLATIT');
				} else {
					//in asteptare
					$status = JText::_('SAUTO_STATUS_NEPLATIT');
				}
				$text;
				if ($f->tip_plata == 'credit') {
					$text = JText::_('SAUTO_CUMPARARE_CREDITE');
				} elseif ($f->tip_plata == 'abon') {
					$text = JText::_('SAUTO_ABONAMENT_NOU');
				} else {
					$text = JText::_('SAUTO__UPDATE_ABONAMENT');
				}?>
				<div>
					<span class="noCrt"><?php echo $i ?></span>
					<span class="date_tr"><?php echo $data_t[0] ?></span>
					<span class="title_tr"><?php echo $text ?></span>
					<span class="status_tr"><?php echo $status ?></span>
					<span class="noCredits_tr"><?php echo $f->credite ?></span>
				</div>
			<?php } ?>

		</div>
	</div>

	<?php 
		$link_form = JRoute::_('index.php?option=com_sauto&view=pay');
	?>
	<p>
		<span class="fix-title"> <?php echo JText::_('SAUTO_CUMPAR_CREDITE'); ?> </span>
		<img class="img-currency" src="<?php echo $img_path; ?>icon_financiar.png" />
	</p>
	<form action="<?php echo $link_form; ?>" method="post">
		<p>
			<?php echo JText::_('SAUTO_NR_CREDITE_DORIT'); ?>
		</p>
		<p>
			<input type="text" name="credite" class="text-input"/>
		</p>
		<p>
			<?php echo JText::_('SAUTO_METODA_PLATA'); ?>
		</p>
		<div>
			<select name="procesator" class="text-input">
			<?php
			$query = "SELECT * FROM #__sa_plati WHERE `published` = '1'";
			$db->setQuery($query);
			$plati = $db->loadObjectList();
			foreach ($plati as $p) {
				echo '<option value="'.$p->id.'">'.$p->procesator.'</option>';
			}
			?>
			</select>
			</div>
			<div style="margin-bottom: 15px;">
			<img src="<?php echo $img_path; ?>icon_financiar_mic.png" />
				<span style="position:relative;top:-10px;">
					<?php echo JText::_('SAUTO_VALOARE_CREDITE'); ?>
				</span>
			</div>

			<div id="submit">Cumpara Credite</div>
	</form>
</div>

<script type="text/javascript">

	var isMobile = navigator.userAgent.contains('Mobile');

	if (!isMobile) {
		jQuery('.m_visitors_child').remove();
	}else {
	    var isCollapsed = true;

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
	.text-input{
		width: 100%;
	}
	.m_visitors_child > p{
		font-size: 1em;
	}
	.fix-title, .img-currency{
		display: inline-block;
	}
	.img-currency{
		vertical-align: top;
	}
	#fact-container, #tranz-container{
		margin-bottom: 25px;
	}
	.tranz-container-header{
		background-color: #509EFF; 
	}
	.noCrt{
		width: 4%;
		display: inline-block;
	}
	.date_tr{
		width: 20%;
		display: inline-block;
	}
	.title_tr{
		width: 35%;
		display: inline-block;
	}
	.status_tr{
		width: 20%;
		display: inline-block;	
	}
	.noCredits_tr{
		width: 13%;
		display: inline-block;	
	}

</style>

