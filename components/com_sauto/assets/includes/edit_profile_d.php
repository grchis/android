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
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(strpos($useragent,'Mobile')){
require_once('/mobile/edit_profile_d_mobile.php');
}else{
$document = JFactory::getDocument ();
require("tab_js.php");
$document->addScriptDeclaration ($js_code_tab);

//$jslink = JUri::base().'components/com_sauto/assets/script/tabtastic.js';
$jslink = JUri::base().'components/com_sauto/assets/script/domtab.js';
$document->addScript($jslink);



$type =& JRequest::getVar( 'type', '', 'get', 'string' );
$link = JRoute::_('index.php?option=com_sauto&view=edit_profile');
$width = 'style="width:800px;"';

?>

<table class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
<div class="domtab">
  <ul class="domtabs">
    <li><a href="#t1"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a></li>
    <li><a href="#t2"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a></li>
	<li><a href="#t3"><?php echo JText::_('SAUTO_TAB_FINANCIAR'); ?></a></li>
	<li><a href="#t4"><?php echo JText::_('SAUTO_TAB_ABONAMENT'); ?></a></li>
	<li><a href="#t5"><?php echo JText::_('SAUTO_TAB_FACTURI'); ?></a></li>
	<li><a href="#t6"><?php echo JText::_('SAUTO_TAB_FILIALE'); ?></a></li>
  </ul>
  <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t1" id="t1"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a></h2>
   <?php require("edit_profile_d_profil.php"); ?>
  </div>
  <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t2" id="t2"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a> 	</h2>
   <?php require("edit_profile_d_profil2.php"); ?>
  </div>
   <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t3" id="t3"><?php echo JText::_('SAUTO_TAB_FINANCIAR'); ?></a> 	</h2>
   <?php require("edit_profile_d_financiar.php"); ?>
  </div>
   <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t4" id="t4"><?php echo JText::_('SAUTO_TAB_ABONAMENT'); ?></a> 	</h2>
   <?php require("edit_profile_d_abonament.php"); ?>
  </div>
   <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t5" id="t5"><?php echo JText::_('SAUTO_TAB_FACTURI'); ?></a> 	</h2>
   <?php require("edit_profile_d_facturi.php"); ?>
  </div>
   <div class="sa_border_tab">
    <h2 class="tabset_label"><a name="t6" id="t6"><?php echo JText::_('SAUTO_TAB_FILIALE'); ?></a> 	</h2>
   <?php require("edit_profile_d_filiale.php"); ?>
  </div>
</div>

		
<?php /*
<ul class="tabset_tabs">
   <li><a href="<?php echo $link; ?>#tab1" <?php if ($type == '') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_PROFILE'); ?></a>
	</li>
	<li><a href="<?php echo $link; ?>#tab2" <?php if ($type == 'pr') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></a>
	</li>
   <li><a href="<?php echo $link; ?>#tab3" <?php if ($type == 'fn') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_FINANCIAR'); ?>
   </a></li>
   <li><a href="<?php echo $link; ?>#tab4" <?php if ($type == 'ab') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_ABONAMENT'); ?>
   </a></li>
   <li><a href="<?php echo $link; ?>#tab5" <?php if ($type == 'fc') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_FACTURI'); ?>
   </a></li>
   <li><a href="<?php echo $link; ?>#tab6" <?php if ($type == 'fl') { echo 'class="active"';} ?>>
		<?php echo JText::_('SAUTO_TAB_FILIALE'); ?>
   </a></li>
</ul>

<div id="tab1" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_PROFILE'); ?></h2>
   <?php require("edit_profile_d_profil.php"); ?>
</div>

<div id="tab2" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_PROFILE_2'); ?></h2>
   <?php require("edit_profile_d_profil2.php"); ?>
</div>

<div id="tab3" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_FINANCIAR'); ?></h2>
   <?php require("edit_profile_d_financiar.php"); ?>
</div>

<div id="tab4" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_ABONAMENT'); ?></h2>
   <?php require("edit_profile_d_abonament.php"); ?>
</div>

<div id="tab5" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_FACTURI'); ?></h2>
   <?php require("edit_profile_d_facturi.php"); ?>
</div>
<div id="tab6" class="tabset_content">
   <h2 class="tabset_label"><?php echo JText::_('SAUTO_TAB_FILIALE'); ?></h2>
   <?php require("edit_profile_d_filiale.php"); ?>
</div>
*/ ?>
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
<?php } ?>

