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


//echo 'abonament > '.$pret->abonament.' pret > '.$pret->pret.' moneda > '.$pret->m_scurt;
//obtinem profilul
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->LoadObject();

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$cfg = $db->loadObject();


$baza = JUri::base();

$tip_abonament =& JRequest::getVar( 'tip_abonament', '', 'post', 'string' );
//obtinem pretul abonamentului
$query = "SELECT `ab`.`abonament`, `ab`.`pret`, `m`.`m_scurt`, `m`.`id` FROM #__sa_abonament AS `ab` JOIN #__sa_moneda AS `m` ON `ab`.`id` = '".$tip_abonament."' AND `ab`.`moneda` = `m`.`id`";
$db->setQuery($query);
$pret = $db->loadObject();

?>
<div>
<?php echo JText::_('SA_PLATA_PAYPAL_ABONAMENT_DESC'); ?>
</div>
<br />
<div>
<?php 
echo JText::sprintf('SA_PLATA_PAYPAL_ABONAMENT_DESC2', $pret->abonament, $pret->pret); 
?>
</div>

<br /><br />
<form action='<?php echo $cfg->paypal_url; ?>' method='post' name='frmPayPal1'><!-- found on top -->
					
                    <input type='hidden' name='business' value='<?php echo $cfg->paypal_email;?>'> <!-- found on top -->
                    <input type='hidden' name='cmd' value="_xclick">
					<input type='hidden' name='image_url' value='<?php echo $cfg->paypal_site_logo; ?>'> <!-- logo of your website -->
					<input type="hidden" name="rm" value="2" /> <!--1-get 0-get 2-POST -->
                    <input type='hidden' class="name" name='item_name' value='<?php echo JText::_('SAUTO_FACT_ABONAMENT').' '.$pret->abonament; ?>'>
                    <input type='hidden' name='item_number' value='1'>
                    <input type='hidden' class="price" name='amount' value='<?php echo $pret->pret; ?>'>
					<input type='hidden' name='no_shipping' value='1'>
					<input type='hidden' name='no_note' value='1'>
					<input type='hidden' name='handling' value='0'>
                    <input type="hidden" name="currency_code" value="EUR">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="cbt" value="Return to the hub">
					<input type="hidden" name="bn" value="PP-BuyNowBF">
                    <input type='hidden' name='cancel_return' value='<?php echo $baza.$cfg->paypal_cancel; ?>'>
                    <input type='hidden' name='return' value='<?php echo $baza.$cfg->return_url; ?>'>
					<input type="hidden" name="notify_url" value="<?php echo $baza.$cfg->notify_url; ?>" /> 
                    <input type="submit" border="0" name="submit" value="<?php echo JText::_('SA_PLATESTE_PRIN_PAYPAL'); ?>">
                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					<input type="hidden" name="custom" value='<?php echo 'abonament-pp-'.$uid.'-'.$pret->pret; ?>'><!-- custom field -->
                </form>
