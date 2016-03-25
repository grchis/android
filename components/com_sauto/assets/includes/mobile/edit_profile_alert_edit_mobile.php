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
    height: 150px;
    overflow-y: scroll;
	display:inline;
	
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
$user =& JFactory::getUser();
$uid = $user->id;

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
//obtin setarile curente
$query = "SELECT * FROM #__sa_alert_details WHERE `uid` = '".$uid."' AND `alert_id` = '".$id."'";
$db->setQuery($query);
$curent = $db->loadObject();
require_once("menu_filter_d.php");
$link = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_save');	
?>

<div class="sterge_alerta">
<form method="post" action="<?php echo $link; ?>">
			<div><strong><?php echo $tip; ?></strong></div>
			<div>
				<input type="checkbox" name="delete" value="1" style="margin-left:25px;" />
				<?php echo JText::_('SAUTO_ELIMINA_DOM_ACT'); ?>
			</div>
			<div><input type="hidden" name="alert_id" value="<?php echo $id; ?>" /></div>
			<div><input type="hidden" name="alert_type" value="delete" /></div>
			<div><input type="submit" value="<?php echo JText::_('SAUTO_CONFIRM_DELETE_DOM_ACT'); ?>" /></div>

</form>
</div>
</br></br></br></br>
<p style="float:left; margin-left:2%;"><strong><?php echo $tip; ?></strong></p><br/>
<div class="center">
<form method="post" action="<?php echo $link; ?>">
		<?php if (($id == '2') OR ($id == '5')) { } else { ?>
		<div class="tip_marci">
				<p><strong><?php echo JText::_('SAUTO_ALEGETI_MARCI_AUTO'); ?></strong></p>
				<p><input type="checkbox" name="cat_m_all_<?php echo $id; ?>" value="1" 
				<?php if ($curent->lista_marci == 'all') { echo 'checked'; } ?>
			/><?php echo JText::_('SAUTO_ALEGE_TOATE_MARCILE'); ?></p>
			<?php 
				$c_marci = explode(",", $curent->lista_marci);
				foreach ($marci as $m) {
						$m_id = $m->id;
						//listare checkboxuri
						echo '<div>';
						echo '<input type="checkbox" name="cat_m_'.$id.'_'.$m->id.'" value="1" ';
							if (in_array($m_id, $c_marci)) { echo 'checked'; }
						echo '/> ';
					echo ' '.$m->marca_auto.'</div>';
					} ?>
		</div>
		<?php } ?>
		<div class="tip_judet">
				<p><strong><?php echo JText::_('SAUTO_ALEGETI_JUDETUL'); ?></strong></p>	
				<p><input type="checkbox" name="cat_j_all_<?php echo $id; ?>" value="1" 
				<?php if ($curent->lista_judete == 'all') { echo 'checked'; } ?>/>
				<?php echo JText::_('SAUTO_ALEGE_TOATE_JUDETELE'); ?></p>
			<?php 
				$c_judete = explode(",", $curent->lista_judete);
				foreach ($judet as $j) {
					$j_id = $j->id;
					//listare checkboxuri
					echo '<div>';
						echo '<input type="checkbox" name="cat_j_'.$id.'_'.$j->id.'" value="1" ';
							if (in_array($j_id, $c_judete)) { echo 'checked'; }
						echo '/> ';
					echo ' '.$j->judet.'</div>';
					} ?>
		</div>
		<?php
		if ($id == 1) {
			$query = "SELECT `nou`, `sh` FROM #__sa_alert_details WHERE `uid` = '".$uid."' AND `alert_id` = '1'";
			$db->setQuery($query);
			$type = $db->loadObject();
			?><br/>
			<div class="tip_piesa">
				<strong><?php echo JText::_('SAUTO_ALEGE_TIP_PIESA'); ?></strong>
				<input type="checkbox" name="nou" value="1"  <?php if ($type->nou == '1') { echo ' checked '; } ?>/> 
				<?php echo JText::_('SAUTO_VREAU_PIESA_NOUA'); ?>
				<input type="checkbox" name="sh" value="1"<?php if ($type->sh == '1') { echo ' checked '; } ?>/> 
				<?php echo JText::_('SAUTO_VREAU_PIESA_SH'); ?>
			</div>
			<?php
		}
		?>
		<div style="clear:both;"></div>
		<br/>
		<div class="button">
			<input type="hidden" name="alert_id" value="<?php echo $id; ?>" />
			<input type="hidden" name="alert_type" value="edit" />
			<input type="submit" value="<?php echo JText::_('SAUTO_ALERT_BUTTON_EDIT'); ?>" />
		</div>
</form>
</div>
<script type="text/javascript">
        document.getElementById('side_bar').remove();
        document.getElementById('gkTopBar').remove();
        document.getElementById('content9').style.all = "none";
        document.getElementsByTagName('h1')[0].remove();
  </script>
