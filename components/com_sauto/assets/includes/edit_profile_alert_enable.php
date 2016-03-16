<?php
/**
 * @package    sauto
 * @subpackage Base
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
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

$link = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=alert_save');
?>
<form method="post" action="<?php echo $link; ?>" id="m_table">
<table class="sa_table_class" width="100%">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top"><strong><?php echo $tip; ?></strong></td>
		<td class="sa_table_cell" valign="top">

		<?php
		//echo '>>> '.$tip;
		if (($id == 2) OR ($id == 5)) {

		} else {
		?>
		<div style="float:left;width:250px;">
		<div><strong><?php echo JText::_('SAUTO_ALEGETI_MARCI_AUTO'); ?></strong></div>
		<div class="sauto_alert_box">
			<div><input type="checkbox" name="cat_m_all_<?php echo $id; ?>" value="1" /><?php echo JText::_('SAUTO_ALEGE_TOATE_MARCILE'); ?></div>
			<?php foreach ($marci as $m) {
					//listare checkboxuri
					echo '<div>';
						echo '<input type="checkbox" name="cat_m_'.$id.'_'.$m->id.'" value="1" /> ';
					echo ' '.$m->marca_auto.'</div>';
				} ?>
		</div>
		</div>
		<?php } ?>

		</td>
		<td class="sa_table_cell" valign="top">
		<div><strong><?php echo JText::_('SAUTO_ALEGETI_JUDETUL'); ?></strong></div>
		<div class="sauto_alert_box">
			<div><input type="checkbox" name="cat_j_all_<?php echo $id; ?>" value="1" /><?php echo JText::_('SAUTO_ALEGE_TOATE_JUDETELE'); ?></div>
			<?php foreach ($judet as $j) {
					//listare checkboxuri
					echo '<div>';
						echo '<input type="checkbox" name="cat_j_'.$id.'_'.$j->id.'" value="1" /> ';
					echo ' '.$j->judet.'</div>';
				} ?>
		</div>
		</td>
		<td class="sa_table_cell" valign="top">
		<?php
		if ($id == 1) {
			$query = "SELECT `nou`, `sh` FROM #__sa_alert_details WHERE `uid` = '".$uid."' AND `alert_id` = '1'";
			$db->setQuery($query);
			$type = $db->loadObject();
			?>
			<div><strong><?php echo JText::_('SAUTO_ALEGE_TIP_PIESA'); ?></strong></div>
			<div>
				<input type="checkbox" name="nou" value="1" />
				<?php echo JText::_('SAUTO_VREAU_PIESA_NOUA'); ?>
			</div>
			<div>
				<input type="checkbox" name="sh" value="1" /> <?php echo JText::_('SAUTO_VREAU_PIESA_SH'); ?>
			</div>
			<?php
		}
		?>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td class="sa_table_cell" colspan="3" align="center">
			<input type="hidden" name="alert_id" value="<?php echo $id; ?>" />
			<input type="hidden" name="alert_type" value="enable" />
			<input type="submit" value="<?php echo JText::_('SAUTO_ALERT_BUTTON_ENABLE'); ?>" />
		</td>
	</tr>
</table>
</form>

<div id="m_visitors">
    <div class = "m_header" style="width: 100%; height: 100px; background-color: #509EFF">
    </div>

    <h1><?php echo $tip; ?></h1>

    <form method="post" action="<?php echo $link; ?>" id="m_table">
        <?php
        //echo '>>> '.$tip;
        if (($id == 2) OR ($id == 5)) {

        } else {
        ?>
            <h4 id="cars-section"><?php echo JText::_('SAUTO_ALEGETI_MARCI_AUTO'); ?></h4>
            <div id="cars-option">
            <?php foreach ($marci as $m) {
                //listare checkboxuri
                echo '<div class="option">';
                    echo '<div>'. $m->marca_auto .'</div>';
                    echo '<input type="checkbox" name="cat_m_'.$id.'_'.$m->id.'" value="1" style="display: none;" /> ';
                echo "</div>";

            } ?>
            </div>

            <h4 id="county-section"><?php echo JText::_('SAUTO_ALEGETI_JUDETUL'); ?></h4>
            <div id="county-option"></div>
            <?php foreach ($judet as $j) {
                //listare checkboxuri
                echo '<div class="option">';
                echo '<div>'. $j->judet .'</div>';
                echo '<input type="checkbox" name="cat_m_'.$id.'_'.$m->id.'" value="1" style="display: none;" /> ';
                echo "</div>";

            } ?>
        <?php } ?>

        <div id="submit" style="margin: 0px auto; margin-bottom: 25px; padding-top: 10px; width:80%; text-align: center; height: 50px; background-color: #509EFF; color: white; font-size: 2.4em; padding-bottom: 10px;">
            Submit
        </div>
    </form>
</div>

<script type="text/javascript">
    var isMobile = navigator.userAgent.contains('Mobile');
    if (!isMobile) {
        document.getElementById('m_visitors').remove();
    } else {
        document.getElementById('m_table').remove();
        document.getElementById('side_bar').remove();
        document.getElementById('gkTopBar').remove();
        document.getElementById('content9').style.all = "none";
        document.getElementsByTagName('h1')[0].remove();
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('submit').addEventListener('click', function (event) {
                event.stopPropagation();
                event.preventDefault();
                var form = document.getElementsByTagName('form')[0];
                form.submit();
            });
        });
    }
</script>
