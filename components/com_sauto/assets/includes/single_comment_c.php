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
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
//verific daca este comentariu meu
$query = "SELECT count(*) FROM #__sa_comentarii WHERE `ID` = '".$id."' AND `proprietar` = '".$uid."'";
$db->setQuery($query);
$total = $db->loadResult();
$width = 'style="width:800px;"';
if ($total == 1) {
	$document = JFactory::getDocument();
	require("toggle_js.php");
	$document->addScriptDeclaration ($js_code);
	$img_path = JURI::base()."components".DS."com_sauto".DS."assets".DS;
	
	require("function_load_img.php");
	require("function_form_comment.php");
	$link_comment = JRoute::_('index.php?option=com_sauto&view=add_comment');
	$multiple_id = 0;
	$r_id = '';
	//preiau comentariul
	$query = "SELECT `c`.`anunt_id`, `c`.`companie` AS `comp`, `c`.`data_adaugarii`, `c`.`mesaj`, `p`.`poza`, `p`.`companie`, `p`.`calificative`, `a`.`titlu_anunt`, `a`.`anunt` FROM #__sa_comentarii AS `c` JOIN #__sa_profiles AS `p` JOIN #__sa_anunturi AS `a` ON `c`.`id` = '".$id."' AND `c`.`companie` = `p`.`uid` AND `c`.`anunt_id` = `a`.`id`";
	$db->setQuery($query);
	$list = $db->loadObject();
	//print_r($list);
	?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
	<table width="100%"  class="sa_table_class">
		<tr class="sa_table_row">
			<td class="sa_table_cell" valign="top" width="100">
			<?php
			if ($list->poza != '') {
				$poza = $image_path.'users'.DS.$list->comp.DS.$list->poza;
			} else {
				$poza = $image_path.DS.'images'.DS.'icon_profile.png';
			}
		echo '<img src="'.$poza.'" width="80" />';
			?>
			</td>
			<td class="sa_table_cell" valign="top">
				<?php
				$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$list->comp);
				$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$list->anunt_id);
				echo '<div><a class="sa_public_profile" href="'.$link_profile.'">'.$list->companie.'</a></div>';
				echo '<hr />';
				echo '<div><a class="sa_public_profile" href="'.$link_anunt.'">'.$list->titlu_anunt.'</a></div>';
				?>
			</td>
			<td class="sa_table_cell" valign="top">
				<?php
				$data_add = explode(" ", $list->data_adaugarii);
				echo '<div>'.JText::_('SAUTO_SHOW_DATE').' '.$data_add[0].'</div>';
				echo '<div>'.JText::_('SAUTO_PROFILE_FEEDBACKS').' '.$list->calificative.'%</div>';
				?>
			</td>
		</tr>
		<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="3">
				<div class="sa_cursor sa_comment_reply" onClick="toggle_visibility('anunt');">
					<?php echo JText::_('SAUTO_VIEW_ANUNT'); ?>	
				</div>
				<div id="anunt" style="display:none;">
					<?php echo $list->anunt; ?>
				</div>
			</td>
		</tr>
		<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="3">
				<hr />
			<?php
			echo $list->mesaj;
			?>
			</td>
		</tr>
		<?php
		//verificam sa vedem daca sunt poze
		$query = "SELECT count(*) FROM #__sa_poze_comentarii WHERE `com_id` = '".$id."'";
		$db->setQuery($query);
		$pcs = $db->loadResult();
		if ($pcs != 0) {
			Jhtml::_('behavior.modal');
			?>
			<tr class="sa_table_row">
				<td class="sa_table_cell" colspan="3">
					<div class="sa_pics">
					<div style="display:inline;">
				<?php
				$query = "SELECT * FROM #__sa_poze_comentarii WHERE `com_id` = '".$id."'";
				$db->setQuery($query);
				$pics = $db->loadObjectList();
					foreach ($pics as $p) {
						$pic = $image_path.'users'.DS.$uid.DS.$p->poza;
						echo '<div style="float:left;margin-left:10px;">';
							echo '<a class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 600}}" href="'.$pic.'">';
							echo '<img src="'.$pic.'" width="80" alt="'.$p->alt.'" />';
							echo '</a>';
						echo '</div>';
					}
				?>
					</div>
					</div>
					<div style="clear:both;"></div>
				</td>
			</tr>
			<?php
		}
		?>
		<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="3">
				<form method="post" action="<?php echo $link_comment; ?>" enctype="multipart/form-data" name="submit_comm" id="submit_comm">
				<?php
				form_comment($r_id, $multiple_id, $list->anunt_id, $uid, $list->comp);
				echo loadImg($r_id, $multiple_id); 
				?>					
				</form>	
				
				<div onClick="document.forms['submit_comm'].submit();" class="sa_add_comment sa_submit_form">
					<?php echo JText::_('SAUTO_COMMENT_BUTTON'); ?>
				</div>
			</td>
		</tr>
		<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="2"  align="left">
			<?php
			$link_comment_list = JRoute::_('index.php?option=com_sauto&view=comments');
			echo '<a href="'.$link_comment_list.'">'.JText::_('SAUTO_BACK_COMMENT_LIST').'</a>';
			?>
			</td>
			<td class="sa_table_cell" align="right">
			<?php
			$link_home = JRoute::_('index.php?option=com_sauto');
			echo '<a href="'.$link_home.'">'.JText::_('SAUTO_BACK_HOME').'</a>';
			?>
			</td>
		</tr>
		
	</table>
</td>
		<td class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				$categ = '';
				echo showAds($pozitionare, $categ);
			echo '</div>';
			//echo '<div>'.$show_side_content.'</div>';	
		?>
		
			</div>
		</td>
	</tr>
</table>
	<?php
	//update status comentariu
	$query = "UPDATE #__sa_comentarii SET `readed_c` = '1' WHERE `id` = '".$id."'";
	$db->setQuery($query);
	$db->query();
} else {
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');
$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));	
}
?>

