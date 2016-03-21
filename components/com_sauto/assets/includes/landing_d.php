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
$image_path = JURI::base()."components/com_sauto/assets";
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(strpos($useragent,'Mobile')){
require_once('/mobile/landing_d_mobile.php');
}else{
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$last_visit = $user->lastvisitDate;
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->loadObject();



$width = 'style="width:800px;"';
//obtin ultimele oferte adaugate
$actual_date = date('Y-m-d H:i:s', time());
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `data_adaugarii` < '".$actual_date."' AND `data_adaugarii` > '".$profil->data_0."'";
$db->setQuery($query);
$news = $db->loadResult();

//obtin filiale
$query = "SELECT `cod_fiscal` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$cf = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_profiles AS `p` JOIN #__users AS `u` 
	ON `p`.`cod_fiscal` = '".$cf."' 
	AND `p`.`f_principal` = '0' 
	AND `p`.`uid` = `u`.`id` 
	AND `u`.`block` = '1'";
$db->setQuery($query);
$filiale = $db->loadResult();

//obtin calificative
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."'";
$db->setQuery($query);
$all = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."' AND `tip` = 'p'";
$db->setQuery($query);
$poz = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."' AND `tip` = 'x'";
$db->setQuery($query);
$neg = $db->loadResult();
$neg2 = $poz + $neg;
$feeds = $poz/$neg2;

//obtin ultimele comentarii
$query = "SELECT count(*) FROM #__sa_comentarii WHERE `companie` = '".$uid."' AND `data_adaugarii` > '".$last_visit."' AND `data_adaugarii` > '".$profil->data_1."' AND `raspuns` = '0' AND `readed_d` = '0'";
$db->setQuery($query);
$last_comms_n = $db->loadResult();
/////
$query = "SELECT count(*) FROM #__sa_comentarii WHERE `companie` = '".$uid."' AND `data_adaugarii` < '".$last_visit."' AND `data_adaugarii` > '".$profil->data_1."' AND `raspuns` = '0' AND `readed_d` = '0'";
$db->setQuery($query);
$last_comms = $db->loadResult();

//ofertele mele
$query = "SELECT * FROM #__sa_raspunsuri AS `r` JOIN #__sa_anunturi as `a` ON `r`.`firma` = '".$uid."' AND `r`.`anunt_id` = `a`.`id` AND `a`.`uid_winner` = '0' AND `a`.`uid_winner` != '".$uid."' GROUP BY `r`.`anunt_id` ";
$db->setQuery($query);
$db->execute();
$total_my_request = $db->getNumRows();

//oferte finalizate
$query = "SELECT * FROM #__sa_raspunsuri AS `r` JOIN #__sa_anunturi as `a` ON `r`.`firma` = '".$uid."' AND `r`.`anunt_id` = `a`.`id` AND `a`.`uid_winner` = '".$uid."' GROUP BY `r`.`anunt_id` ";
$db->setQuery($query);
$db->execute();
$total_final_request = $db->getNumRows();
				
//linkuri
$link_abonament = JRoute::_('index.php?option=com_sauto&view=edit_profile#t4'); 
$link_financiar = JRoute::_('index.php?option=com_sauto&view=edit_profile#t3'); 
$link_feedback = JRoute::_('index.php?option=com_sauto&view=feedback');
$link_suport = JRoute::_('index.php?option=com_sauto&view=suport');
$link_comments = JRoute::_('index.php?option=com_sauto&view=comments');
$link_my_request = JRoute::_('index.php?option=com_sauto&view=my_request');
$link_final_request = JRoute::_('index.php?option=com_sauto&view=final_request');
$link_filiale = JRoute::_('index.php?option=com_sauto&view=edit_profile#t6'); 

//echo '>>>> '.$filiale;
//echo '>>>> '.$actual_date.' si '.$profil->data_0 ;
/*
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
<center>
<div class="sauto_home_page">
	<h2>
		<?php echo JText::_('SAUTO_WELCOME_CLIENT').' '.$profil->companie; ?>
	</h2>
</div>

<div class="sa_logo_start">
	<?php 
	if ($profil->poza == '') { 
		$path = $image_path."/images/logo_client_mare.png";
	} else {
		$path = $image_path."/users/".$profil->uid."/".$profil->poza;
	} 	
	?>
	<img src="<?php echo $path; ?>" width="139" border="0" />
</div>

<div class="sauto_home_page_icons">
	<table width="100%" class="sa_table_class">
		<tr class="sa_table_row">
			<td align="center" class="sa_table_cell">
				<?php 
				//total final request
				$query = "SELECT * FROM #__sa_raspunsuri AS `r` JOIN #__sa_anunturi as `a` ON `r`.`firma` = '".$uid."' AND `r`.`anunt_id` = `a`.`id` AND `a`.`uid_winner` = '".$uid."' GROUP BY `r`.`anunt_id` ";
				$db->setQuery($query);
				$db->execute();
				$total_final_request = $db->getNumRows();
				$link_final_request = JRoute::_('index.php?option=com_sauto&view=final_request'); 
				?>
				<a href="<?php echo $link_final_request; ?>" class="sa_lk_profile">
					<img src="<?php echo $img_path; ?>icon_final_request.png" />
					<?php if ($total_final_request != 0) { ?>
					<span class="sa_sup_nr"><?php echo $total_final_request; ?></span>
					<?php } ?>
					<br />
					<?php echo JText::_('SA_MENU_DEALER_FINAL_REQUEST'); ?>
				</a>
			</td>
			<td class="sa_table_cell"></td>
			<td align="center" class="sa_table_cell">
				<?php 
				//total my request
				$query = "SELECT * FROM #__sa_raspunsuri AS `r` JOIN #__sa_anunturi as `a` ON `r`.`firma` = '".$uid."' AND `r`.`anunt_id` = `a`.`id` AND `a`.`uid_winner` = '0' AND `a`.`uid_winner` != '".$uid."' GROUP BY `r`.`anunt_id` ";
				$db->setQuery($query);
				$db->execute();
				$total_my_request = $db->getNumRows();
				$link_my_request = JRoute::_('index.php?option=com_sauto&view=my_request'); ?>
				<a href="<?php echo $link_my_request; ?>" class="sa_lk_profile">
					<img src="<?php echo $img_path; ?>icon_my_request.png" />
					<?php if ($total_my_request != 0) { ?>
					<span class="sa_sup_nr"><?php echo $total_my_request; ?></span>
					<?php } ?>
					<br />
					<?php echo JText::_('SA_MENU_DEALER_MY_REQUEST'); ?>
				</a>
			</td>
			<td class="sa_table_cell"></td>
			<td align="center" class="sa_table_cell">
				<?php 
				$query = "SELECT count(*) FROM #__sa_comentarii WHERE `companie` = '".$uid."' AND `data_adaugarii` > '".$last_visit."' AND `data_adaugarii` > '".$profil->data_1."' AND `raspuns` = '0' AND `readed_d` = '0'";
				$db->setQuery($query);
				$last_comms_n = $db->loadResult();
				/////
				$query = "SELECT count(*) FROM #__sa_comentarii WHERE `companie` = '".$uid."' AND `data_adaugarii` < '".$last_visit."' AND `data_adaugarii` > '".$profil->data_1."' AND `raspuns` = '0' AND `readed_d` = '0'";
				$db->setQuery($query);
				$last_comms = $db->loadResult();
				$link_comments = JRoute::_('index.php?option=com_sauto&view=comments'); ?>
				<a href="<?php echo $link_comments; ?>" class="sa_lk_profile">
					<?php if ($last_comms_n != 0) { ?>
					<span class="sa_sup_nr sa_fact_red"><?php echo $last_comms_n; ?></span>
					<?php } ?>
					<img src="<?php echo $img_path; ?>icon_comments.png" />
					<?php if ($last_comms != 0) { ?>
					<span class="sa_sup_nr"><?php echo $last_comms; ?></span>
					<?php } ?>
					<br />
					<?php echo JText::_('SA_MENU_USERS_COMMENTS'); ?>
				</a>
			</td>
			<td class="sa_table_cell"></td>
			<td align="center" class="sa_table_cell">
				<?php
				$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."'";
				$db->setQuery($query);
				$all = $db->loadResult();
				$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."' AND `tip` = 'p'";
				$db->setQuery($query);
				$poz = $db->loadResult();
				$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."' AND `tip` = 'x'";
				$db->setQuery($query);
				$neg = $db->loadResult();
				//$poz = $poz + 15;
				$neg2 = $poz + $neg;
				$feeds = $poz/$neg2;
				//echo JText::_('SAUTO_CURRENT_FEEDBACK').' '.round(100*$feeds,2).'% ('.$all.')';
				$link_feedback = JRoute::_('index.php?option=com_sauto&view=feedback'); ?>
				<a href="<?php echo $link_feedback; ?>" class="sa_lk_profile">
					<img src="<?php echo $img_path; ?>icon_feedback.png" />
					<?php if ($all != 0) { ?>
					<span class="sa_sup_nr"><?php echo round(100*$feeds,2).'%'; ?></span>
					<?php } ?>
					<br />
					<?php echo JText::_('SA_MENU_USERS_FEEDBACK'); ?>
				</a>
			</td>
		</tr>
			<tr class="sa_table_row">
				<td class="sa_table_cell"></td>
				<td align="center" class="sa_table_cell">
<?php 
//$link_financiar = JRoute::_('index.php?option=com_sauto&view=edit_profile&type=fn'); 
$link_financiar = JRoute::_('index.php?option=com_sauto&view=edit_profile#t3'); 
?>
					<a href="<?php echo $link_financiar; ?>" class="sa_lk_profile">
					<img src="<?php echo $img_path; ?>icon_financiar.png" />
					<br />
					<?php echo JText::_('SA_MENU_USERS_FINANCIAR'); ?>
					</a>
				</td>
				<td class="sa_table_cell"></td>
				<td align="center" class="sa_table_cell">
<?php 
//$link_abonament = JRoute::_('index.php?option=com_sauto&view=edit_profile&type=ab'); 
$link_abonament = JRoute::_('index.php?option=com_sauto&view=edit_profile#t4'); 
?>
					<a href="<?php echo $link_abonament; ?>" class="sa_lk_profile">
					<img src="<?php echo $img_path; ?>icon_abonament.png" />
					<br />
					<?php echo JText::_('SA_MENU_USERS_ABONAMENT'); ?>
					</a>
				</td>
				<td class="sa_table_cell"></td>
				<td align="center" class="sa_table_cell">
					<a href="<?php echo $link_suport; ?>" class="sa_lk_profile">
					<img src="<?php echo $img_path; ?>icon_suport.png" />
					<br />
					<?php echo JText::_('SA_MENU_USERS_SUPORT'); ?>
					</a>
				</td>
				<td class="sa_table_cell"></td>
			</tr>
			
				<?php 
				if ($news != 0) {
				?>
			<tr class="sa_table_row">
				<td class="sa_table_cell" colspan="7">
					<div class="sa_warnings"><?php echo JText::sprintf('SAUTO_NEWS_ALERTS', $news); ?></div>
				</td>
			</tr>
				<?php
				}
				
				if ($filiale != 0) {
				?>
			<tr class="sa_table_row">
				<td class="sa_table_cell" colspan="7">
					<div class="sa_warnings">
<?php 
//$list_filiale = JRoute::_('index.php?option=com_sauto&view=edit_profile&type=fl');
$link_filiale = JRoute::_('index.php?option=com_sauto&view=edit_profile#t6'); 
echo JText::sprintf('SAUTO_FILIALE_NOI', $filiale, $link_filiale); 	
?>
					</div>
				</td>
			</tr>
			<?php
				}
				?>
				
			<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="7">
				<div class="sa_front_divs_d">
				<?php
				require("list_news_d.php");
				?>
				</div>
			</td>
		</tr>
		
		<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="7">
				<div class="sa_front_divs_d">
				<?php
				require("list_comment_d.php");
				?>
				</div>
			</td>
		</tr>
		<tr class="sa_table_row">
			<td class="sa_table_cell" colspan="7">
				<div class="sa_front_divs_d">
				<?php
				require("list_feedback_d.php");
				?>
				</div>
			</td>
		</tr>
	</table>
</div>
</center>

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
*/
?>
<div align ="center" id="additional_content">
<div class="sauto_home_page">
	<h2 class="sa_front_title">
		<?php echo JText::_('SAUTO_WELCOME_CLIENT').' '.$profil->companie; ?>
	</h2>
</div>

<div class="sa_logo_start">
	<?php 
	if ($profil->poza == '') { 
		$path = $image_path."/images/logo_client_mare.png";
	} else {
		$path = $image_path."/users/".$profil->uid."/".$profil->poza;
	} 	
	?>
	<img src="<?php echo $path; ?>" width="139" border="0" />
</div>

<div class="sauto_home_page_icons" id="m_table">
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_final_request; ?>" class="sa_lk_profile">
			<img src="<?php echo $img_path; ?>icon_final_request.png" />
			<?php if ($total_final_request != 0) { ?>
			<span class="sa_sup_nr"><?php echo $total_final_request; ?></span>
			<?php } ?>
			<br />
			<?php echo JText::_('SA_MENU_DEALER_FINAL_REQUEST'); ?>
		</a>
	</div>
	<div class="sa_front_dealer_btns">
	&nbsp;
	</div>
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_my_request; ?>" class="sa_lk_profile">
			<img src="<?php echo $img_path; ?>icon_my_request.png" />
			<?php if ($total_my_request != 0) { ?>
			<span class="sa_sup_nr"><?php echo $total_my_request; ?></span>
			<?php } ?>
			<br />
			<?php echo JText::_('SA_MENU_DEALER_MY_REQUEST'); ?>
		</a>
	</div>
	<div class="sa_front_dealer_btns">&nbsp;
	</div>
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_comments; ?>" class="sa_lk_profile">
			<?php if ($last_comms_n != 0) { ?>
			<span class="sa_sup_nr sa_fact_red"><?php echo $last_comms_n; ?></span>
			<?php } ?>
			<img src="<?php echo $img_path; ?>icon_comments.png" />
			<?php if ($last_comms != 0) { ?>
			<span class="sa_sup_nr"><?php echo $last_comms; ?></span>
			<?php } ?>
			<br />
			<?php echo JText::_('SA_MENU_USERS_COMMENTS'); ?>
		</a>
	</div>
	<div class="sa_front_dealer_btns">&nbsp;
	</div>
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_feedback; ?>" class="sa_lk_profile">
			<img src="<?php echo $img_path; ?>icon_feedback.png" />
			<?php if ($all != 0) { ?>
			<span class="sa_sup_nr"><?php echo round(100*$feeds,2).'%'; ?></span>
			<?php } ?>
			<br />
			<?php echo JText::_('SA_MENU_USERS_FEEDBACK'); ?>
		</a>
	</div>
	<?php // row 2 ?>
	<div class="sa_front_dealer_btns">
&nbsp;
	</div>
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_financiar; ?>" class="sa_lk_profile">
			<img src="<?php echo $img_path; ?>icon_financiar.png" />
			<br />
			<?php echo JText::_('SA_MENU_USERS_FINANCIAR'); ?>
		</a>
	</div>
	<div class="sa_front_dealer_btns">
&nbsp;
	</div>
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_abonament; ?>" class="sa_lk_profile">
			<img src="<?php echo $img_path; ?>icon_abonament.png" />
			<br />
			<?php echo JText::_('SA_MENU_USERS_ABONAMENT'); ?>
		</a>
	</div>
	<div class="sa_front_dealer_btns">
&nbsp;
	</div>
	<div class="sa_front_dealer_btns">
		<a href="<?php echo $link_suport; ?>" class="sa_lk_profile">
			<img src="<?php echo $img_path; ?>icon_suport.png" />
			<br />
			<?php echo JText::_('SA_MENU_USERS_SUPORT'); ?>
		</a>
	</div>
	<div class="sa_front_dealer_btns">
&nbsp;
	</div>
</div>

<?php if ($news != 0) { ?>
<div class="sa_front_news_zone">
	<div class="sa_warnings"><?php echo JText::sprintf('SAUTO_NEWS_ALERTS', $news); ?></div>
</div>
<?php } ?>

<?php
if ($filiale != 0) { ?>
<div class="sa_front_news_zone">
	<div class="sa_warnings">
<?php 
echo JText::sprintf('SAUTO_FILIALE_NOI', $filiale, $link_filiale); 	
?>
	</div>
</div>
<?php } ?>


<div class="sa_fron_news_zone">
<?php require("list_news_d.php"); ?>
</div>

<div class="sa_fron_news_zone">
<?php require("list_comment_d.php"); ?>
</div>

<div class="sa_fron_news_zone">
<?php require("list_feedback_d.php"); ?>
</div>
</div>
<?php } ?>
