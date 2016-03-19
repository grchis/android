<style type="text/css">
.action-button{
	text-align: center;
	width: 30%;
	max-width: 100px;
	display: inline-block;
	background-color: #509EFF;
	font-size: 1em;
	color: white;
	padding-top: 4px;
	padding-bottom: 4px;
}
h1{
display:none;
}
.ellipse{
	white-space: nowrap; 
	overflow: hidden; 
	text-overflow: ellipsis;
}

a{
	color: white;
}
@media screen and (max-width: 1210px){
    .gkPage {
    padding: 0 !important;
    }
}
</style>
<?php
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
if ($total == 0) {
	//nu ai anunturi
	require_once('fara_anunturi.php');
} else { 
?>
<div id="m_visitors" style="background-color:#F9F9F9">
<?php 
require_once('menu_filter.php');
	$query = "SELECT * FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `status_anunt` = '1' AND `is_winner` = '0' ORDER BY `id` DESC ";
	$db->setQuery($query);
	$list1 = $db->loadObjectList();
?>
<div class = "main-container">
	<?php
	foreach ($list1 as $l) {
	?>
	<div id="request-item" style="padding-bottom: 10px;">
		<div style="display: inline-block; width: 73%;">
		<?php 
			$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
			$image = 'anunt_type_'.$l->tip_anunt.'.png';
			$query = "SELECT `poza`,`alt` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."' ORDER BY `id` ASC";
			$db->setQuery($query);
			$pics = $db->loadObject();
			if ($pics->poza != '') {
				$poza = $image_path."/users/".$uid."/".$pics->poza;
				$alt = $pics->alt;
			} else {
				$poza = $img_path.$image;
				$alt = '';
			}
			$link_anunt1 = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			$data_add1 = explode(" ", $l->data_adaugarii);
			
			if ($l->marca_auto != 0) {
				echo '<div style="display:inline;">';
				//obtin marca si modelul
				$query = "SELECT `marca_auto`, `published` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
				$db->setQuery($query);
				$marca1 = $db->loadObject();
				$query = "SELECT `model_auto`, `published` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
				$db->setQuery($query);
				$model1 = $db->loadObject();
				}
			//obtin ofertele
			$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$l->id."'";
			$db->setQuery($query);
			$oferte1 = $db->loadResult();
			$link_delete_anunt1 = JRoute::_('index.php?option=com_sauto&view=delete&id='.$l->id);
			?>
	<div id="request-item" style="border-bottom: 1px solid #509EFF; padding-bottom: 10px;">
		<img src="<?php echo $poza ?>" width="25%" height="13%" alt="some pic" style="vertical-align: top; display: inline-block;"/>
			<div style="display: inline-block; width: 73%;">
				<p class="request-p ellipse" style="font-size: 20px; margin: 0 !important; padding-top: 10px;">
					<?php echo JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt).': '.$l->titlu_anunt; ?>		
				</p>
	        	<p class="request-p" style="font-size: 13px; margin: 0 !important; padding-top: 10px;">
					Adaugat in: <?php echo $data_add1[0]; ?>
				</p>
				<p class="request-p ellipse" style="font-size: 13px; margin: 0 !important; padding-top: 10px;">
				 <?php echo substr(strip_tags($l->anunt), 0, 50); ?>
				</p>
				<p class="request-p" style="font-size: 13px; margin: 0 !important; padding-top: 10px;">
					Model: <?php echo $model1->model_auto; ?>
				</p>
				<p class="request-p" style="font-size: 13px; margin: 0 !important; padding-top: 10px;">
					Marca: <?php echo $marca1->marca_auto; ?>
				</p>
     			<div id="request-offers" class="action-button"> 
					<?php	echo '<a href="'.$link_anunt1.'" >';	      
					if ($oferte1 == 1) {
						echo 'O oferta';
						} elseif ($oferte1 == 0) {
						echo '0 oferte';
						} else {
						echo $oferte1.' '.'oferte';
						}
						echo '</a>';?>
					</div>
					<div id="edit-offer" class="action-button" > 
				<?php 
				    $link_edit1 = JRoute::_('index.php?option=com_sauto&view=edit_request');
					echo '<form action="'.$link_edit1.'" method="post" name="edit_form_'.$l->id.'" id="edit_form_'.$l->id.'">';
					echo '<input type="hidden" name="anunt_id" value="'.$l->id.'" />';
					echo '</form>';
					echo '<div  onClick="document.forms[\'edit_form_'.$l->id.'\'].submit();">';
					echo JText::_('SAUTO_EDIT_REQUEST');
					echo '</div>';
				?>
					</div>
					<div id="delete-offer" class="action-button" > 
						
				<?php echo '<a href="'.$link_delete_anunt1.'" class="sa_delete_box">'; ?>
				Sterge 
				</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	
<?php 
	}
}
?>
</div>


<script type="text/javascript">
		document.getElementById('side_bar').remove();
		document.getElementById('gkTopBar').remove();
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
</script>
