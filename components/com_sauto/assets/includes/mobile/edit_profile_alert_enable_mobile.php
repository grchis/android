<style>
.center {
    margin: auto;
    width: 100%;
    padding: 12%;
}
.buton{
    margin-left: 15%;
    margin-right: 15%;
    width: 70%;
    margin-top: 6%;
}
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
	.tip_piesa{
	width: 40%;
    height: 170px;
    overflow-y: scroll;
	display: inline;
	}
	
	.tip_judet{
	width: 40%;
    height: 300px;
    overflow-y: scroll;	
	}
	
	.tip_marci{
	width: 40%;
    height: 300px;
	float:left;
    overflow-y: scroll;
	}
</style>
<?php
defined('_JEXEC') || die('=;)');
$db = JFactory::getDbo();
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
//obtin numele domeniului de activitate
$query = "SELECT `tip` FROM #__sa_tip_anunt WHERE `id` = '".$id."'";
$db->setQuery($query);
$tip = $db->loadResult();

$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
$db->setQuery($query);
$judet = $db->loadObjectList();

//obtinem marci auto
$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
$db->setQuery($query);
$marci = $db->loadObjectList();
require_once("menu_filter_d.php");
$link = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_save');
?>
<p style="float:left; margin-left:2%;"><strong><?php echo $tip; ?></strong></p><br/>
<div class="center">
<form method="post" action="<?php echo $link; ?>" id="m_table">
		<?php
		if (($id == 2) OR ($id == 5)) {

		} else {
		?>
		<div class="tip_marci">
		<p><strong><?php echo JText::_('SAUTO_ALEGETI_MARCI_AUTO'); ?></strong></p>
				<p><input type="checkbox" name="cat_m_all_<?php echo $id; ?>" value="1" /><?php echo JText::_('SAUTO_ALEGE_TOATE_MARCILE'); ?></p>
				<?php foreach ($marci as $m) {
						//listare checkboxuri
						echo '<div>';
							echo '<input type="checkbox" name="cat_m_'.$id.'_'.$m->id.'" value="1" /> ';
						echo ' '.$m->marca_auto.'</div>';
					} ?>
		</div>
		<?php } ?>
			<div class="tip_judet">
				<p><strong><?php echo JText::_('SAUTO_ALEGETI_JUDETUL'); ?></strong></p>	
				<input type="checkbox" name="cat_j_all_<?php echo $id; ?>" value="1" /><?php echo JText::_('SAUTO_ALEGE_TOATE_JUDETELE'); ?>				
					<?php foreach ($judet as $j) {
							//listare checkboxuri
												echo '<div>';
									echo '<input type="checkbox" name="cat_j_'.$id.'_'.$j->id.'" value="1" /> ';
							echo ' '.$j->judet.'</div>';
						} ?>
		</div>
		<?php
		if ($id == 1) {
			$query = "SELECT `nou`, `sh` FROM #__sa_alert_details WHERE `uid` = '".$uid."' AND `alert_id` = '1'";
			$db->setQuery($query);
			$type = $db->loadObject();
			?>
			<div class="tip_piesa">
				<p><strong><?php echo JText::_('SAUTO_ALEGE_TIP_PIESA'); ?></strong></p>
				<p><input type="checkbox" name="nou" value="1" />
				<?php echo JText::_('SAUTO_VREAU_PIESA_NOUA'); ?></p>
				<p><input type="checkbox" name="sh" value="1" /> <?php echo JText::_('SAUTO_VREAU_PIESA_SH'); ?><p/>
			</div>
			<?php
		}
		?>
		
		<div style="clear:both;"></div>
		<div class="button">
			<input type="hidden" name="alert_id" value="<?php echo $id; ?>" />
			<input type="hidden" name="alert_type" value="enable" />
			<input type="submit" value="<?php echo JText::_('SAUTO_ALERT_BUTTON_ENABLE'); ?>" />
		</div>

</form>
</div>
<script type="text/javascript">
        document.getElementById('side_bar').remove();
        document.getElementById('gkTopBar').remove();
        document.getElementById('content9').style.all = "none";
        document.getElementsByTagName('h1')[0].remove();
  </script>
