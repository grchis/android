<style type="text/css">
#detalii_firma{
	float:right;
}
.sa_submit_form{
    margin-left:2%;
}
p {
     margin: 0.5em 2% 0.5em;
}
.sa_reported_div{
	width:36%;
}
.sa_min_width {
    width: 25%;
}
form {
    margin: 0;
    padding-left: 2%;
    padding-right: 2%;
}
	  .pic-container{
        width: 15%;
        display: inline-block;
    }
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
<?php
defined('_JEXEC') || die('=;)');
$anunt_id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$user =& JFactory::getUser();
$uid = $user->id;
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_anunturi WHERE `id` = '".$anunt_id."'";
$db->setQuery($query);
$rezult = $db->loadObject();
Jhtml::_('behavior.modal');

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();

//poza user
$query = "SELECT `poza`, `companie` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$prf = $db->loadObject();
?>
<div id="m_visitors">
	<?php
require("menu_filter_d.php");
	?>
	<div id="hidden-values">
			<?php
			$data_adaugarii = explode(" ", $rezult->data_adaugarii);
			echo JText::_('SAUTO_DATA').': '.$data_adaugarii[0].'<br />';
			//obtin categorie
			$query = "SELECT `tip` FROM #__sa_tip_anunt WHERE `id` = '".$rezult->tip_anunt."'";
			$db->setQuery($query);
			$categorie = $db->loadResult();
			$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$rezult->tip_anunt);
			echo JText::_('SAUTO_CATEGORY').': <a href="'.$link_categ.'">'.$categorie.'</a><br />';
			if ($rezult->tip_anunt == 1) {
				//1
				require("display_request_1_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 2) {
				//2
				require("display_request_2_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 3) {
				//3
				require("display_request_3_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 4) {
				//4
				require("display_request_4_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 5) {
				//5
				require("display_request_5_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 6) {
				//6
				require("display_request_6_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 7) {
				//7
				require("display_request_7_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 8) {
				//8
				require("display_request_8_mobile.php");
				view_detail($rezult, $tip);
			} elseif ($rezult->tip_anunt == 9) {
				//9
				require("display_request_9_mobile.php");
				view_detail($rezult, $tip);
			} 
			?>
</div>
<?php
		if ($tip == 1){
			echo "<h1>Detalii Companie</h1>";
		} else {
			echo "<h1>Detalii Client</h1>";
		}
		require('display_proprietar_mobile.php');
		getMobileDetails($rezult->proprietar, $tip, $id, '');	 
	?>
<div id="main-container">
		<p><strong>Detalii Cerere</strong></p>
	</div>
	<!--=================================================Comentarii=======================================================----------------->
	<?php echo JText::_('SAUTO_MESAJ_CERERE'); ?>
	<div class="comments_list">
		<?php
		$query = "SELECT count(*) FROM #__sa_poze WHERE `id_anunt` = '".$anunt_id."'";
		$db->setQuery($query);
		$total = $db->loadResult();
		if ($total != 0) {
			//avem poze
			require("display_pictures_mobile.php");
			view_pictures($anunt_id, $rezult->proprietar);
		}
			echo $rezult->anunt; ?>
			<h2><?php echo JText::_('SAUTO_COMMENTS_LIST'); ?></h2>
				<?php 
				//preluam ofertele facute
				$img_path = JURI::base()."components/com_sauto/assets/images/";
				$img_path2 = JURI::base()."components/com_sauto/assets/users/";
				$query = "SELECT  `c`.`id`, `c`.`proprietar`, `c`.`companie` as `comp`,`c`.`data_adaugarii`, `c`.`mesaj`, `c`.`ordonare`, `c`.`raspuns`, `p`.`fullname`, `p`.`poza` FROM #__sa_comentarii as `c` JOIN #__sa_profiles as `p` ON `c`.`proprietar` = `p`.`uid` AND `c`.`anunt_id` = '".$anunt_id."' AND `c`.`companie` = '".$uid."' AND `c`.`published` = '1' ORDER BY `c`.`companie` ASC, `c`.`ordonare` ASC";
				$db->setQuery($query);
				$rasp = $db->loadObjectList();
				$link_u_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$uid);
				foreach ($rasp as $r) {
				echo '<hr class="sauto_hr"/>';
				$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$r->comp);			
						if ($r->raspuns == 1) {
							if ($r->poza != '') {
									//avatar custom
									$pozaFirma=$img_path2.$uid.'/'.$prf->poza;
								} else { 
									//avatar standard
									echo $pozaFirma=$img_path.'icon_profile.png';
								}
								$data_add = explode(" ", $r->data_adaugarii);
								
								?>							
			<div class="firma-item">
				<div class="pic-container" data-id="<?php echo $r->companie ?>" data-category="categories">
					<img src="<?php echo $pozaFirma ?>" width="80" border="0" />
				</div>	
					<div class="client_comment"style="display:inline;">
								<p class="sa_client_comment"><?php echo JText::_('SAUTO_COMENTARIU_DEALER');?>: </p>
								<div style="float:left;margin-left:2%;" class="sa_link_profile">
									<a class="sa_public_profile"
										href="<?php echo $link_profile;?>"><?php echo $prf->companie; ?></a>
								</div>
							<div style="clear:both;"></div>
							<p><?php echo $data_add[0];?></p>
							<p><?php echo $r->mesaj; ?></p>
				
							</div>
						<?php
							$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
							$db->setQuery($query);
							$totals = $db->loadResult();
							if ($totals != 0) {
								$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
								$db->setQuery($query);
								$poze2 = $db->loadObjectList();
								echo '<div style="display:inline">';
								foreach ($poze2 as $p2) {
									echo '<div style="float:left;padding:5px;">';
									echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path2.$r->proprietar.'/'.$p2->poza.'">';
									echo '<img src="'.$img_path2.$r->proprietar.'/'.$p2->poza.'" width="70" border="0" />';
									echo '</a>';
									echo '</div>';
								}
								echo '</div>';
								echo '<div style="clear:both;"></div>';
							}
							echo '</div>';
						} else {
							//Comentariu client, aliniat la dreapta
									$data_add = explode(" ", $r->data_adaugarii);
								if ($prf->poza != '') {
									//avatar custom
									$pozaClient=$img_path2.$r->proprietar.'/'.$r->poza;
								} else {
									//avatar standard
									$pozaClient=$img_path.'icon_profile.png';
								}
							?>
						
						<div class="client-item">
								<div class="pic-container" data-id="<?php echo $r->proprietar; ?>" data-category="categories">
									<img src="<?php echo $pozaClient; ?>" width="80" border="0" />
								</div>	
								<div class="client_comment"style="display:inline;">
									<p class="sa_client_comment"><?php echo JText::_('SAUTO_COMENTARIU_CLIENT');?>: </p>
										<div style="float:left;margin-left:2%;" class="sa_link_profile">
											<a class="sa_public_profile"
												href="<?php echo $link_u_profile;?>"><?php echo $r->fullname; ?></a>
										</div>
									<div style="clear:both;"></div>
									<p><?php echo $data_add[0];?></p>
									<p><?php echo $r->mesaj; ?></p>
								</div>
							<?php
							$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
							$db->setQuery($query);
							$totals = $db->loadResult();
							if ($totals != 0) {
								echo '<p>';
								$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$r->id."'";
								$db->setQuery($query);
								$poze = $db->loadObjectList();
								echo '<div style="display:inline">';
								foreach ($poze as $p) {
									echo '<div style="float:left;padding:5px;">';
									echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$img_path2.$r->proprietar.'/'.$p->poza.'">';
									echo '<img src="'.$img_path2.$r->proprietar.'/'.$p->poza.'" width="70" border="0" />';
									echo '</a>';
									echo '</div>';
								}
								echo '</div>';
								echo '<div style="clear:both;"></div>';
							}
						}
						echo '</div>';								
				}
			?>
</div>	
</div>	
	<script type="text/javascript">

var element = document.getElementById('hidden-values');
		var textValues = element.innerHTML.split('<br>');
		var appendElement = '';
		for(var i = 0;i < textValues.length - 1; i++){
			var splitValues = textValues[i].split(':');
			var appendElement = '<p><span class="some-class">' + splitValues[0] + ': </span>' + splitValues[1] + '</p>';
			document.getElementById('main-container').innerHTML += appendElement;
		}
		document.getElementById('hidden-values').remove();
		document.getElementById('gkTopBar').remove();
		document.getElementsByTagName('center')[0].remove();
		document.getElementById('wrapper9').getElementsByTagName('h1')[0].remove();
		document.getElementById('m_table').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100%;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}#gkMainbody table{ width: 100% !important; }' + 
						'#gkMainbody table tbody, #gkMainbody table thead, #gkMainbody table tfoot{ width: 100% !important; }' + 
						'span{ display: inline-block; width: 45%; } p{ margin-top: 2px; margin-bottom: 2px;}</style>'
		);
	

</script>