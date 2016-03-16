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
$document = JFactory::getDocument ();
$editor =& JFactory::getEditor();

//obtin datele filialei
$query = "SELECT `p`.`telefon`, `p`.`companie`, `p`.`reprezentant`, `p`.`sediu`, `u`.`email`, `u`.`registerDate`, 
		`j`.`judet`, `j`.`id` AS `jid`, `l`.`localitate`, `l`.`id` AS `lid`   
		FROM #__sa_profiles AS `p`
		JOIN #__users AS `u` 
		JOIN #__sa_judete AS `j` 
		JOIN #__sa_localitati AS `l` 
		ON `p`.`uid` = '".$id."' 
		AND `p`.`uid` = `u`.`id`
		AND `p`.`judet` = `j`.`id` 
		AND `p`.`localitate` = `l`.`id`";
$db->setQuery($query);
$fil = $db->loadObject();
//print_r($fil);

require("javascript.php");
$document->addScriptDeclaration ($js_code2);

$width = 'style="width:800px;"';

$link_form = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=editing_filiala');
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
			<h3>
				<?php echo JText::_('SAUTO_EDIT_FILIALA'); ?>
			</h3>
			<br />
			<form action="<?php echo $link_form; ?>" method="post" name="fil_form">
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<table class="sa_table_class">
				<tr class="sa_table_row">
					<td class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_COMPANY_NAME'); ?></td>
					<td class="sa_table_cell"><?php echo $fil->companie; ?></td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_REPREZ_NAME'); ?></td>
					<td class="sa_table_cell"><input type="text" name="reprezentant" value="<?php echo $fil->reprezentant; ?>" class="sa_inputbox" /></td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_PHONE'); ?></td>
					<td class="sa_table_cell"><input type="text" name="telefon" value="<?php echo $fil->telefon; ?>" class="sa_inputbox" /></td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_EMAIL'); ?></td>
					<td class="sa_table_cell"><input type="text" name="email" value="<?php echo $fil->email; ?>" class="sa_inputbox" /></td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_REGION'); ?></td>
					<td class="sa_table_cell">
						<select name="judet" onChange="javascript:aratOrase(this.value)" class="sa_select">
						<?php
						$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
						$db->setQuery($query);
						$judete = $db->loadObjectList();
						foreach ($judete as $j) {
							echo '<option id="'.$j->id.'"';
								if ($j->id == $fil->jid) { echo ' selected '; }
							echo '>'.$j->judet.'</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_CITY'); ?></td>
					<td class="sa_table_cell">
					<div id="sa_city">
						<select name="localitate" class="sa_select">
						<?php
						$query = "SELECT * FROM #__sa_localitati ORDER BY `localitate` ASC";
						$db->setQuery($query);
						$cities = $db->loadObjectList();
						foreach ($cities as $c) {
							echo '<option id="'.$c->id.'"';
								if ($c->id == $fil->lid) { echo ' selected '; }
							echo '>'.$c->localitate.'</option>';
						}
						?>	
						</select>
					</div>
					</td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell" valign="top"><?php echo JText::_('SAUTO_FORM_SEDIU'); ?></td>
					<td class="sa_table_cell">
					<?php
					
					$params = array( 'smilies'=> '0' ,
						'style'  => '1' ,  
						'layer'  => '0' , 
						'table'  => '0' ,
						'clear_entities'=>'0'
						);
			echo $editor->display( 'sediu', $fil->sediu, '500', '150', '20', '20', false, $params );
			?>
					</td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell"><?php echo JText::_('SAUTO_FORM_MEMBER_SINCE'); ?></td>
					<td class="sa_table_cell"><?php echo $fil->registerDate; ?></td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell"></td>
					<td class="sa_table_cell">
<?php $link_form2 = JRoute::_('index.php?option=com_sauto&view=edit_profile&task=aprove_filiala&id='.$id); ?>
<input type="submit" 
	value="<?php echo JText::_('SAUTO_FORM_APROBA_FILIALA'); ?>" 
	class="sauto_button2 " 
	onclick="fil_form.action='<?php echo $link_form2; ?>'; return true;" />
	
<input type="submit" 
	value="<?php echo JText::_('SAUTO_FORM_EDITARE_FILIALA'); ?>" 
	class="sauto_button2 validate" onclick="this.form;return true;" />
					</td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell"></td>
					<td class="sa_table_cell"></td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell"></td>
					<td class="sa_table_cell"></td>
				</tr>
			</table>
</form>
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