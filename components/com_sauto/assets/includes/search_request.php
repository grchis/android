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
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->login_article."'";
$db->setQuery($query);
$login_article = $db->loadResult();
$img_path = JURI::base()."components/com_sauto/assets/images/forms/";
//get article
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->search_req_right_article."'";
$db->setQuery($query);
$search_req_right_article = $db->loadResult();


$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->search_req_bottom_article."'";
$db->setQuery($query);
$search_req_bottom_article = $db->loadResult();
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->request_article."'";
$db->setQuery($query);
$request_article = $db->loadResult();
$link_form = JRoute::_('index.php?option=com_sauto&view=search_request2');
$width = 'style="width:800px;"';

?>

<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
<div style="display:inline;">
	<?php 
	if ($login_article == '') {
		echo '<div>';
	} else {
		echo '<div class="sauto_main_left">';
	}	
	?>
	
		<h3>
			<?php echo JText::_('SAUTO_TIP_ANUNT'); ?>
		</h3>
		<table width="100%">
			<tr>
				<td valign="top" width="50%">
					<div>
						<form action="<?php echo $link_form; ?>" method="post">
						<?php /*<select  id="selectedOptions" onchange="showDivs('div',this)">*/ ?>
							<select name="request" onChange="this.form.submit()" class="sa_select_mic">
								<option value="0" selected><?php echo JText::_('SAUTO_ALEGE_TIP_ANUNT'); ?></option>
								<?php
								$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
								$db->setQuery($query);
								$tip = $db->loadObjectList();
								foreach ($tip as $t) {
									echo '<option value="'.$t->id.'">'.$t->tip.'</option>';
								}
								?>	
							</select>
						</form>
					</div>
				</td>
				<td valign="top">
					<div class="bubble_box"><?php echo JText::_('SAUTO_SEARCH_REQUEST_BUBBLE_1'); ?></div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php
					$pozitionare = 'c';
					$categ = '';
					echo showAds($pozitionare, $categ);
					?>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<div class="bubble_box2"><?php echo JText::_('SAUTO_SEARCH_REQUEST_BUBBLE_2'); ?></div>
				</td>
				<td valign="top">
					<?php
					$array = array("form1.png","form2.png","form3.png","form4.png","form5.png","form6.png","form7.png");
					$random = array_rand($array);
					$file = $array[$random];
					$file = 'form7.png';
					?>
					<img src="<?php echo $img_path.$file; ?>" />
				</td>
			</tr>
		</table>
			<div>
				<?php
				echo $request_article;
				?>
			</div>
	</div>
	
	<?php
	if ($login_article != '') {
	?>
	<div class="sauto_main_right">
		<?php echo $login_article; ?>
	</div>
	<?php } ?>
</div>
<div style="clear:both;"></div>
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
		?>
			</div>
		</td>
	</tr>
</table>
<?php
/*
<div style="display:inline;">
	<div class="sauto_main_left">
			<h3>
				<?php echo JText::_('SAUTO_TIP_ANUNT'); ?>
			</h3>
				
			<div>
				<form action="<?php echo $link_form; ?>" method="post">
				<select name="request" onChange="this.form.submit()">
					<option value="0" selected><?php echo JText::_('SAUTO_ALEGE_TIP_ANUNT'); ?></option>
				<?php
				$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
				$db->setQuery($query);
				$tip = $db->loadObjectList();
					foreach ($tip as $t) {
						echo '<option value="'.$t->id.'">'.$t->tip.'</option>';
					}
				?>	
				</select>
				</form>
			</div>
			
			<div>
				<?php
				echo $search_req_bottom_article;
				?>
			</div>
	</div>
	
	<div class="sauto_main_right">
		<?php echo $search_req_right_article; ?>
	</div>
</div>
<div style="clear:both;"></div>
<?php
*/
//stergere cookie....
$app =& JFactory::getApplication();

$app->setUserState('request', '');
$app->setUserState('string_cautare', '');
$app->setUserState('search_in_1', '');
$app->setUserState('search_in_2', '');
$app->setUserState('marca', '');
$app->setUserState('model_auto', '');
$app->setUserState('an_fabricatie', '');
$app->setUserState('cilindree', '');
$app->setUserState('carburant', '');
$app->setUserState('nr_usi', '');
$app->setUserState('stare', '');
$app->setUserState('caroserie', '');
$app->setUserState('tip_piesa', '');
$app->setUserState('judet', '');
$app->setUserState('city', '');
$app->setUserState('buget_alocat', '');
$app->setUserState('buget_moneda', '');
$app->setUserState('judet_r', '');
$app->setUserState('city_r', '');

