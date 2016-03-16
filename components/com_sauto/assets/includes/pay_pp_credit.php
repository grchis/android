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
//
$pret =& JRequest::getVar( 'credite', '', 'post', 'string' );

//echo 'abonament > '.$pret->abonament.' pret > '.$pret->pret.' moneda > '.$pret->m_scurt;
//obtinem profilul
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->LoadObject();

$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$cfg = $db->LoadObject();


$baza = JUri::base();

//curs valutar....
$url  = 'http://www.bnro.ro/nbrfxrates.xml';
		if( function_exists('curl_init') ) {
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,$url);
			curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			$curs = curl_exec($curl_handle);
			curl_close($curl_handle);
		} else {
			$curs = file_get_contents($url);
		}
		if( !class_exists('SimpleXMLElement') ){
			echo 'Serverul nu suporta SimpleXML';
		exit;
		}
		$rates = array(); 
		$xml = new SimpleXMLElement($curs);
			foreach( $xml->Body->Cube->Rate as $rate ){
			$final = array();
				foreach( $rate->attributes() as $att => $value ){
					if( strcmp($att,'currency') == 0 )   $final['currency']   = (string) $value;
					if( strcmp($att,'multiplier') == 0 ) $final['multiplier'] = (string) $value;
				}
			$final['rate'] = (string) $rate;
			if( empty($final['multiplier']) ) $final['multiplier'] = 1;
			array_push($rates,$final);
		}
		//print_r($rates);
		//echo '<hr /><br />';
		$curs_euro = $rates['10']['rate'];
		//echo '>>>>> '.$curs_euro;
//
?>
<div>
<?php echo JText::_('SA_PLATA_PAYPAL_CREDITE_DESC'); ?>
</div>
<br />
<div>
<?php 
echo JText::sprintf('SA_PLATA_PAYPAL_CREDITE_DESC2', $pret); 
?>
</div>
<br />
<div>
<?php
$all_cr = round($pret/$curs_euro, 2); 
echo JText::sprintf('SA_PLATA_PAYPAL_CREDITE_DESC3', $all_cr, $curs_euro); 

?>
</div>
<br /><br />
<form action='<?php echo $cfg->paypal_url; ?>' method='post' name='frmPayPal1'><!-- found on top -->
					
                    <input type='hidden' name='business' value='<?php echo $cfg->paypal_email;?>'> <!-- found on top -->
                    <input type='hidden' name='cmd' value="_xclick">
					<input type='hidden' name='image_url' value='<?php echo $cfg->paypal_site_logo; ?>'> <!-- logo of your website -->
					<input type="hidden" name="rm" value="2" /> <!--1-get 0-get 2-POST -->
                    <input type='hidden' class="name" name='item_name' value='<?php echo JText::_('SA_PACHET_CREDITE'); ?>'>
                    <input type='hidden' name='item_number' value='1'>
                    <input type='hidden' class="price" name='amount' value='<?php echo $all_cr; ?>'>
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
					<input type="hidden" name="custom" value='<?php echo 'credite-pp-'.$uid.'-'.$pret; ?>'><!-- custom field -->
                </form>
