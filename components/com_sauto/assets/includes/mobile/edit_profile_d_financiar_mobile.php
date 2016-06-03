
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
#submit {
    width: 60%;
    margin: 2% 20% 20%;
    margin-bottom: 25px;
    padding-top: 10px;
    text-align: center;
    height: 50px;
    background-color: #509EFF;
    color: white;
    font-size: 1.4em;
    padding-bottom: 10px;
</style>


<?php
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
$data_exp = $profil->data_abonare + 15811200;
$data_exp = date('Y-m-d', $data_exp);
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

?>
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
			if ($total_tranz == 0) {
				 echo '<p>'.JText::_('SAUTO_NU_AVETI_TRANZACTII'); ?></p>
					<?php } else { 
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
					<?php } } ?>
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
			//query facturi
				$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."'";
				$db->setQuery($query);
				$total_fact = $db->loadResult();
				?>
				<p>
				<?php echo JText::_('SAUTO_TOTAL_FACTURI').': '.$total_fact; ?>
				</p>
			<?php
			if ($total_fact == 0) {
						?>
						<p><?php echo JText::_('SAUTO_NU_AVETI_FACTURI'); ?></p>
				<?php
				} else {
			
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
				<?php } }?>

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
			<input type="text" name="credite" value="" class="text-input"/>
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
		<div>
				<?php if ($profil->id != 1) { echo JText::_('SAUTO_INTERZIS_CREDITE').'<br />'; } ?>
				<input type="hidden" name="plata_pentru" value="puncte" />
				<input type="submit" id="submit"value="<?php echo JText::_('SAUTO_CUMPARA_CREDITE_BUTTON'); ?>" 
				<?php if ($profil->id != 1) { echo 'disabled'; } ?>
				/>
			</div>
		</form>
</div>

<script type="text/javascript">
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
</script>
