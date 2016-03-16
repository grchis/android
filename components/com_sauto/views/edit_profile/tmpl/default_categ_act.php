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
$document = JFactory::getDocument ();
$path = JPATH_ROOT.DS.'components'.DS.'com_sauto'.DS.'assets'.DS.'includes'.DS;
$img_path = JURI::base()."components/com_sauto/assets/images/";
//require($path."toggle_js.php");
//require($path."javascript.php");
//$document->addScriptDeclaration ($js_code);

//$document->addScriptDeclaration ($js_code2);

$db = JFactory::getDbo();
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');

$site = JUri::base();
//echo '>>> '.$site;
$document->addScript($site.'components/com_sauto/assets/script/jquery.min.js');
$document->addScript($site.'components/com_sauto/assets/script/animatedcollapse.js');

$url =& JURI::getInstance(  );
?>

<h1><?php echo $this->site_title; ?></h1>
<div id="wrapper9">
	<div id="side_bar">
	<?php 
	$user =& JFactory::getUser();
	$uid = $user->id;
		if ($uid == 0) {
			//vizitator
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} else {
			//verificare tip utilizator
			$query= "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
			$db->setQuery($query);
			$tip = $db->loadResult();
			if ($tip == 0) {
				//client
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			} elseif ($tip == 1) {
				//dealer
				require_once("components/com_sauto/assets/includes/menu_d.php");
			} else {
				//nedefinit, redirectionam la prima pagina
				$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
			} 
		}
	?> 
	</div>
				
	<div id="content9">
<?php

//obtinem judetele
$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
$db->setQuery($query);
$judet = $db->loadObjectList();
			
//obtinem marci auto
$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
$db->setQuery($query);
$marci = $db->loadObjectList();
	
	
$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
$db->setQuery($query);
$acts = $db->loadObjectList();

	$js = '
	animatedcollapse.addDiv(\'act1\', \'fade=0,speed=500,group=activ,hide=1\')
	animatedcollapse.addDiv(\'act2\', \'fade=0,speed=500,group=activ,hide=1\')
	animatedcollapse.addDiv(\'act3\', \'fade=0,speed=500,group=activ,hide=1\')
	animatedcollapse.addDiv(\'act4\', \'fade=0,speed=500,group=activ,hide=1\')
	animatedcollapse.addDiv(\'act5\', \'fade=0,speed=500,group=activ,hide=1\')
	animatedcollapse.addDiv(\'act8\', \'fade=0,speed=500,group=activ,hide=1\')
	animatedcollapse.addDiv(\'act9\', \'fade=0,speed=500,group=activ,hide=1\')
	animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state
}
animatedcollapse.init()
';	
	//echo $js.'<br />'; 
	$document->addScriptDeclaration($js);

$link = JRoute::_('index.php?option=com_sauto&view=setalert&task=dealertemp');

	foreach ($acts as $a) {
		//obtin alert_temp
		$query = "SELECT `alert_id` FROM #__sa_alert_temp WHERE `uid` = '".$uid."' AND `alert_id` = '".$a->id."'";
		$db->setQuery($query);
		$setat = $db->loadResult();
		
		?>
<div class="sa_set_activ">
	<a href="#" rel="toggle[act<?php echo $a->id; ?>]">
		<?php echo $a->tip; ?>
	</a>
</div>
	
<?php
		if ($setat == $a->id) {
			echo '<div id="act'.$a->id.'" class="sa_div_activ">';
			echo JText::_('SAUTO_ALERTA_SETATA_DEJA');
			echo '</div>';
		} else {
?>
<div id="act<?php echo $a->id; ?>" class="sa_div_activ">
	<?php
	$query = "SELECT `alert_id` FROM #__sa_alert_temp WHERE `uid` = '".$uid."' AND `alert_id` = '".$a->id."'";
	$db->setQuery($query);
	$setat = $db->loadResult();	
echo '<form method="post" action="'.$link.'">';	
	?>
	<div style="display:inline;">
	<?php if ( ($a->id == '2') OR ($a->id == '5')) { 

	} else {  ?>
	<div style="float:left;width:350px;">
		<div><strong><?php echo JText::_('SAUTO_ALEGETI_MARCI_AUTO'); ?></strong></div>
		<div class="sauto_alert_box">
			<div><input type="checkbox" name="cat_m_all_<?php echo $a->id; ?>" value="1" /><?php echo JText::_('SAUTO_ALEGE_TOATE_MARCILE'); ?></div>
			<?php foreach ($marci as $m) {
					//listare checkboxuri
					echo '<div>';
						echo '<input type="checkbox" name="cat_m_'.$a->id.'_'.$m->id.'" value="1" /> ';
					echo ' '.$m->marca_auto.'</div>';
				} ?>
		</div>
	</div>
	<?php } ?>
	<div style="float:left;width:350px;margin-left:20px;">
		<div><strong><?php echo JText::_('SAUTO_ALEGETI_JUDETUL'); ?></strong></div>
		<div class="sauto_alert_box">
			<div><input type="checkbox" name="cat_j_all_<?php echo $a->id; ?>" value="1" /><?php echo JText::_('SAUTO_ALEGE_TOATE_JUDETELE'); ?></div>
			<?php foreach ($judet as $j) {
					//listare checkboxuri
					echo '<div>';
						echo '<input type="checkbox" name="cat_j_'.$a->id.'_'.$j->id.'" value="1" /> ';
					echo ' '.$j->judet.'</div>';
				} ?>
		</div>
	</div>
</div>
<div style="clear:both;"></div>	
<br />
<input type="hidden" name="url" value="<?php echo $url->toString(); ?>" />
<input type="hidden" name="alert_id" value="<?php echo $a->id; ?>" />
<input type="submit" value="<?php echo JText::_('SA_SETEAZA_ALERTA_2'); ?>" />
</form>	

<br /><br />
</div>
		<?php
		}
	}
	?>
<div>
	<?php
	//verificam daca este setata alerta pentru acest user
	$query = "SELECT count(*) FROM #__sa_alert_temp WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$total = $db->loadResult();
	if ($total == 0) {
		//nu e setata nimic
		echo JText::_('SAUTO_NO_ACTIVITY_ADDED'); 
	} else {
	$link2 = JRoute::_('index.php?option=com_sauto&view=setalert&task=dealer');
	echo '<form method="post" action="'.$link2.'">';
	?>
		<input type="submit" value="<?php echo JText::_('SAUTO_SETEAZA_ALERTE_NOI'); ?>" />
	</form>
	<?php } ?>
</div>
	</div>
				
					
</div>


