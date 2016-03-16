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

function calificativ($uid, $proprietar, $id_anunt, $id_raspuns, $type, $redirect) {
	$link_calificativ = JRoute::_('index.php?option=com_sauto&view=calificativ');
	$img_path = JURI::base()."components/com_sauto/assets/images/";

	?>
	<form action="<?php echo $link_calificativ; ?>" method="post" name="calificativ_<?php echo $id_anunt; ?>" id="calificativ_<?php echo $id_anunt; ?>">
		<div>
			<textarea name="calificativ_mess" cols="100" rows="1"></textarea>
		</div>
		<div>
		<?php
			$calif_p = 'feedback_pozitiv_gri.png';	
			$calif_n = 'feedback_neutru_gri.png';							
			$calif_x = 'feedback_negativ_gri.png';
							/*	echo '<input type="radio" name="calificativ_value" value="p" class="sa_feed_select sa_styled" />';
								echo '<input type="radio" name="calificativ_value" value="n" class="sa_feed_select sa_styled" />';
								echo '<input type="radio" name="calificativ_value" value="x" class="sa_feed_select sa_styled" />';
							*/ ?>
			<div id="calificativ_value" style="display:inline;">
				<div style="position:relative;float:left;margin-left:14px;">
					<label for="pozitiv_<?php echo $id_anunt; ?>">
						<input type="radio" name="calificativ_value" id="pozitiv_<?php echo $id_anunt; ?>" value="p" />
						<img src="<?php echo $img_path.$calif_p; ?>" alt="Pozitiv" />
					</label>
				</div>
				
				<div style="position:relative;float:left;margin-left:14px;">
					<label for="neutru_<?php echo $id_anunt; ?>">
						<input type="radio" name="calificativ_value" id="neutru_<?php echo $id_anunt; ?>" value="n" />
						<img src="<?php echo $img_path.$calif_n; ?>" alt="Neutru" />
					</label>
				</div>
				
				<div style="position:relative;float:left;margin-left:14px;">
					<label for="negativ_<?php echo $id_anunt; ?>">
						<input type="radio" name="calificativ_value" id="negativ_<?php echo $id_anunt; ?>" value="x" />
						<img src="<?php echo $img_path.$calif_x; ?>" alt="Negativ" />
					</label>
				</div>
			</div>
			
			<div style="clear:both;"></div>
		</div>
		<input type="hidden" name="poster_id" value="<?php echo $uid; ?>" />
		<input type="hidden" name="dest_id" value="<?php echo $proprietar; ?>" />
		<input type="hidden" name="id_anunt" value="<?php echo $id_anunt; ?>" />
		<input type="hidden" name="type" value="<?php echo $type; ?>" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
						
		</form>
						
		<div onClick="document.forms['calificativ_<?php echo $id_anunt; ?>'].submit();" class="sa_send_feedback sa_submit_feed sa_calificativ">
			<?php echo JText::_('SAUTO_FEEDBACK_NOW_BUTTON'); ?>
		</div>
		<?php
}
?>
