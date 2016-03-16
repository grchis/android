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
?>
<?php
if ($uid == 0) {
	//vizitator
	require_once("components/com_sauto/assets/includes/vizitatori.php");
} else {	
?>
<?php /*<h1><?php echo $this->site_title; ?></h1>*/ ?>
<div id="sa_reclame_top">
	<?php
	echo '<div class="sa_reclama_right">';
	$pozitionare = 'l';
	$categ = '';
	echo showAds($pozitionare, $categ);
	echo '</div>'; ?>
</div>
<div id="sa_viz_main">
	<div id="sa_viz_side_bar">
	<?php 
			//verificare tip utilizator
			$query= "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$tip = $db->loadResult();
			if ($tip == 0) {
				//client
				require_once("components/com_sauto/assets/includes/menu_c.php");
			} elseif ($tip == 1) {
				//dealer
				require_once("components/com_sauto/assets/includes/menu_d.php");
			} else {
				//nedefinit, redirectionam la prima pagina
				$app =& JFactory::getApplication();
				$link_redirect = JRoute::_('index.php');
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			} 
		
	?> 
	</div>
				
	<div id="sa_viz_content">
				<?php
			//verificare tip utilizator
			if ($tip == 0) {
				//client
				require_once("components/com_sauto/assets/includes/landing_c.php");
			} elseif ($tip == 1) {
				//dealer
				require_once("components/com_sauto/assets/includes/landing_d.php");
			}
		?> 						
	</div>
	<div id="sa_reclame">
		<div class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				$categ = '';
				echo showAds($pozitionare, $categ);
			echo '</div>'; ?>
		</div>
	</div>
				
					
</div>
<div style="clear:both;"></div>
<?php
}
?>
<script>
document.getElementById('gkFooter').remove();
</script>

