<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
//defined('_JEXEC') || die('=;)');

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
		//echo $curs_euro;
		//echo '<hr /><br />';
		$curs_usd = $rates['26']['rate'];
		//echo $curs_usd;
		//echo '<hr /><br />';
		$curs_gbp = $rates['11']['rate'];
		//echo $curs_gbp;
//adaugam in baza de date

$time = time();
$addDate = date('Y-m-d H:i:s', $time);
	
require("../../../../configuration.php");
$config = new JConfig;

$conect = mysqli_connect($config->host, $config->user, $config->password, $config->db);

$query = "INSERT INTO ".$config->dbprefix."sa_curs_valutar (`data`, `curs_euro`, `curs_dolar`, `curs_lira`) VALUES ('".$addDate."', '".$curs_euro."', '".$curs_usd."', '".$curs_gbp."')";

//echo $query;

mysqli_query($conect, $query);
