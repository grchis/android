<style type="text/css">
	h1{
		display:none;
	}
    p{
        margin: 0;
    }
    .pic-container{
        width: 15%;
        display: inline-block;
    }
    .info-section{
         width: 45%;
        display: inline-block;
    }
    .contact-section{
        width: 33%;
        display: inline-block;
        vertical-align: top;
    }
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
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
$id =& JRequest::getVar( 'id', '', 'get', 'string' );


//start script
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$id."'";
$db->setQuery($query);
$total = $db->loadResult();
if ($total == 0) {
	//nu ai anunturi
	require_once('fara_anunturi.php');
	$link_home = JRoute::_('index.php?option=com_sauto');
	} else { 

$link = JRoute::_('index.php?option=com_sauto&view=requests');
$image_path = JURI::base()."components/com_sauto/assets/users/";
//verificam nivelul de acces
$query = "SELECT `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$types = $db->loadResult();
$view_phone = 0;
	//verificam abonamentul
	if ($types == 3) {
		$view_phone = 1;
	}
	?>
<div id="m_visitiors">

	<?php
require_once("menu_filter.php");	
	$query = "SELECT * FROM #__sa_anunturi WHERE `proprietar` = '".$id."' ORDER BY `id` DESC ";
	$db->setQuery($query);
	$list = $db->loadObjectList();
	foreach ($list as $l) {
			$image = 'anunt_type_'.$l->tip_anunt.'.png';
			$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
		?>
		<div class="request-item">
		<?php 
			//verificare poze
			$query = "SELECT `poza`,`alt` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."'";
			$db->setQuery($query);
			$pics = $db->loadObject();
			if ($pics->poza != '') {
				$poza = $image_path.$l->proprietar."/".$pics->poza;
				$alt = $pics->alt;
			} else {
				$poza = $img_path.$image;
				$alt = '';
			}
		?>
		<div class="pic-container" data-id="<?php echo $l->tip_anunt ?>" data-category="categories">
			<?php echo '<a href="'.$link_categ.'" class="sa_lk_profile">'.JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt); ?>
					<img src="<?php echo $poza ?>" width="80" border="0" /></a>
		</div>	
		 <div class="info-section">
			<?php
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
			$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=delete&id='.$l->id);
			echo '<p class="sa_request_title"><a href="'.$link_anunt.'" class="sa_link_request">'.$l->titlu_anunt.'</a></p>';
			$data_add = explode(" ",$l->data_adaugarii);
			echo '<p>'.substr(strip_tags($l->anunt), 0, 50).' ...</p>';
			if ($l->marca_auto != 0) {

				//obtin marca si modelul
				$query = "SELECT `marca_auto`, `published` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
				$db->setQuery($query);
				$marca = $db->loadObject();
				$query = "SELECT `model_auto`, `published` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
				$db->setQuery($query);
				$model = $db->loadObject();
					echo '<p style="position:relative">'.JText::_('SAUTO_SHOW_MARCA').' ';
						if ($marca->published == 1) {
							echo $marca->marca_auto;
						} else {
							echo JText::_('SAUTO_MARCA_NEPUBLICATA');
						}
					echo '</p>';
					echo '<p style="position:relative">'.JText::_('SAUTO_SHOW_MODEL').' ';
						if ($model->published == 1) {
							echo $model->model_auto;
						} else {
							echo JText::_('SAUTO_MODEL_NEPUBLICAT');
						}
					echo '</p>';
			}
			echo '<p>'.JText::_('SAUTO_SHOW_DATE').' '.$data_add[0].'</p>';
			?>
			
			</div>
		 <div class="contact-section">
			<?php
			$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet`, `p`.`abonament` FROM #__sa_profiles as `p` JOIN #__sa_judete as `j` ON `p`.`uid` = '".$l->proprietar."' AND `p`.`judet` = `j`.`id`";
			$db->setQuery($query);
			$userd = $db->loadObject();
			$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
			echo '<p class="sa_request_title"><a href="'.$link_profile.'" class="sa_link_request">'.$userd->fullname.'</a></p>';
			echo '<p>'.JText::_('SAUTO_DISPLAY_JUDET').': '.$userd->judet.'</p>';
			
			echo '<p style="width:100%;"class="sa_table_cell sa_phone sa_phone_oferte">';
			echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />';
			echo '<span class="sa_phone_span">';
				//afisam telefonul
				if ($view_phone == 0) {
					echo JText::_('SAUTO_TELEFON_ASCUNS');
				} else {
					echo $userd->telefon;
				}
								
			echo '</span>';
			echo '</p>';

			echo '<p style="width:100%;" class="sa_table_cell sa_phone sa_phone_oferte sa_padding">';
			echo '<span class="sa_oferte_span">';
				$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `proprietar` = '".$l->proprietar."' AND `anunt_id` = '".$l->id."'";
				$db->setQuery($query);
				$oferte = $db->loadResult();
				if ($oferte == 1) {
					echo JText::_('SAUTO_O_OFERTA');
				} elseif ($oferte == 0) {
					echo JText::_('SAUTO_FARA_OFERTE');
				} else {
					echo $oferte.' '.JText::_('SAUTO_NR_OFERTE');
				}
			echo '</span>';
			echo '</p>';
			?>
		</div>
		</div>
	<?php
	}
	echo '</div>';
	}
?>

<script type="text/javascript">
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