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
$img_path = JURI::base()."components".DS."com_sauto".DS."assets".DS."images".DS;
$db = JFactory::getDbo();
//get configure table
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
?>
<div style="display:inline;">
		<div class="sauto_main_left">
			<div class="sa_register_start">
				<?php $link_client = JRoute::_('index.php?option=com_sauto&view=register_customer'); ?>
				<a href="<?php echo $link_client; ?>" class="sauto_register_link">
					<img src="<?php echo $img_path; ?>register_client.png" border="0" />
				</a>
			</div>
			
			<div class="sauto_register_div">
				<?php if ($sconfig->custom_register == 1) {
					//afisare mesaj custom
					echo $sconfig->custom_register_client;
				} else {
					//preluare din baza de date
					$query = "SELECT `anunt` FROM #__sa_anunturi ORDER BY `id` DESC LIMIT 0,1";
					$db->setQuery($query);
					$anunt = $db->loadResult();
					echo $anunt;
				}
				?> 
			</div>
		</div>
		
		<div class="sauto_main_right">
			<div class="sauto_login_title">
			<?php echo JText::_('SAUTO_TUTORIAL_CLIENT'); ?>
			</div>
			
			<div>
				<?php echo $sconfig->tutorial_client; ?>
			</div>
		</div>
</div>
<div style="clear:both;"></div>

<hr class="sauto_hr" />

<div style="display:inline;">
		<div class="sauto_main_left">
			<div class="sa_register_start">
				<?php $link_firma = JRoute::_('index.php?option=com_sauto&view=register_dealer'); ?>
				<a href="<?php echo $link_firma; ?>" class="sauto_register_link">
					<img src="<?php echo $img_path; ?>register_firma.png" border="0" />
				</a>
			</div>
			
			<div class="sauto_register_div">
				<?php if ($sconfig->custom_register == 1) {
					//afisare mesaj custom
					echo $sconfig->custom_register_firma;
				} else {
					//preluare din baza de date
					$query = "SELECT `mesaj` FROM #__sa_raspunsuri ORDER BY `id` DESC LIMIT 0,1";
					$db->setQuery($query);
					$mesaj = $db->loadResult();
					echo $mesaj;
				}
				?> 
			</div>
		</div>
		
		<div class="sauto_main_right">
			<div class="sauto_login_title">
			<?php echo JText::_('SAUTO_TUTORIAL_FIRMA'); ?>
			</div>
			
			<div>
			<?php echo $sconfig->tutorial_firma; ?>
			</div>
		</div>
</div>
<div style="clear:both;"></div>
