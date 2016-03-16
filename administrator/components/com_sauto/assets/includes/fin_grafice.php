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
$year = date("Y");
$last_year = $year - 1;
$month = array(
	1 => 'Ianuarie', 
	2 => 'Februarie', 
	3 => 'Martie', 
	4 => 'Aprilie', 
	5 => 'Mai', 
	6 => 'Iunie', 
	7 => 'Iulie', 
	8 => 'August', 
	9 => 'Septembrie', 
	10 => 'Octombrie', 
	11 => 'Noiembrie', 
	12 => 'Decembrie');

$document = JFactory::getDocument();
$document->addScript('https://www.google.com/jsapi');
$code1 = 'google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([';
		$code1 .= '[\'Luna\', \'Facturi\'],';
		for ($i=1;$i<13;$i++) {
			if (strlen($i) == 1) { $luna = '0'.$i; } else { $luna = $i; }
			$query = "SELECT count(*) FROM #__sa_facturi WHERE `data_tr` LIKE '".$year."-".$luna."-%'";
			$db->setQuery($query);
			$rez = $db->loadResult();
			//echo 'luna '.$month[$i].' >>> '.$rez.'<br />';
			$code1 .= "['".$month[$i]."',  ".$rez." ]";
			if ($i != 12) { $code1 .= ","; }
		} 
$code1 .= ']);

        var options = {
          title: \'Grafic facturi an '.$year.'\'
        };

        var chart = new google.visualization.PieChart(document.getElementById(\'this_year\'));

        chart.draw(data, options);
      }';
$document->addScriptDeclaration($code1);


$code2 = 'google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart2);
      function drawChart2() {
        var data = google.visualization.arrayToDataTable([';
		$code2 .= '[\'Luna\', \'Facturi\'],';
		for ($i=1;$i<13;$i++) {
			if (strlen($i) == 1) { $luna = '0'.$i; } else { $luna = $i; }
			$query = "SELECT count(*) FROM #__sa_facturi WHERE `data_tr` LIKE '".$last_year."-".$luna."-%'";
			$db->setQuery($query);
			$rez = $db->loadResult();
			//echo 'luna '.$month[$i].' >>> '.$rez.'<br />';
			$code2 .= "['".$month[$i]."',  ".$rez." ]";
			if ($i != 12) { $code2 .= ","; }
		} 
$code2 .= ']);

        var options = {
          title: \'Grafic facturi an '.$last_year.'\'
        };

        var chart2 = new google.visualization.PieChart(document.getElementById(\'last_year\'));

        chart2.draw(data, options);
      }';
$document->addScriptDeclaration($code2);

$code3 = 'google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart3);
      function drawChart3() {
        var data = google.visualization.arrayToDataTable([';
		$code3 .= '[\'Metode de plata\', \'Nr. total\'],';
		for ($i=1;$i<4;$i++) {
			if ($i == 1) {
				$db_qr = "op";
				$tip = "Ordin de plata";
			} elseif ($i == 2) {
				$db_qr = "cc";
				$tip = "Card bancar";
			} elseif ($i == 3) {
				$db_qr = "pp";
				$tip = "PayPal";
			}
			$query = "SELECT count(*) FROM #__sa_facturi WHERE `factura` LIKE '".$db_qr." - sauto -%'";
			$db->setQuery($query);
			$rez = $db->loadResult();
			$code3 .= "['".$tip."',  ".$rez." ]";
			if ($i != 3) { $code3 .= ","; }
		} 
$code3 .= ']);

        var options = {
          title: \'Grafic metode de plata\'
        };

        var chart3 = new google.visualization.PieChart(document.getElementById(\'metode_plata\'));

        chart3.draw(data, options);
      }';
$document->addScriptDeclaration($code3);

$code4 = 'google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart4);
      function drawChart4() {
        var data = google.visualization.arrayToDataTable([';
		$code4 .= '[\'Metode de plata\', \'Nr. total\'],';
		for ($i=1;$i<3;$i++) {
			if ($i == 1) {
				$db_qr = "credit";
				$tip = "Credite";
			} elseif ($i == 2) {
				$db_qr = "abonament";
				$tip = "Abonamente";
			}
			$query = "SELECT count(*) FROM #__sa_facturi WHERE `tip_plata` = '".$db_qr."'";
			$db->setQuery($query);
			$rez = $db->loadResult();
			$code4 .= "['".$tip."',  ".$rez." ]";
			if ($i != 2) { $code4 .= ","; }
		} 
$code4 .= ']);

        var options = {
          title: \'Grafic plati pentru?\'
        };

        var chart4 = new google.visualization.PieChart(document.getElementById(\'incasari\'));

        chart4.draw(data, options);
      }';
$document->addScriptDeclaration($code4);

$code5 = 'google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart5);
      function drawChart5() {
        var data = google.visualization.arrayToDataTable([';
		$code5 .= '[\'Utilizatori\', \'Nr. total\'],';
		for ($i=1;$i<3;$i++) {
			if ($i == 1) {
				$db_qr = "0";
				$tip = "Utilizator";
			} elseif ($i == 2) {
				$db_qr = "1";
				$tip = "Dealer";
			}
			$query = "SELECT count(*) FROM #__sa_profiles WHERE `tip_cont` = '".$db_qr."'";
			$db->setQuery($query);
			$rez = $db->loadResult();
			$code5 .= "['".$tip."',  ".$rez." ]";
			if ($i != 2) { $code5 .= ","; }
		} 
$code5 .= ']);

        var options = {
          title: \'Grafic tipuri de utilizatori inregistrati\'
        };

        var chart5 = new google.visualization.PieChart(document.getElementById(\'users\'));

        chart5.draw(data, options);
      }';
$document->addScriptDeclaration($code5);

$code6 = 'google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart6);
      function drawChart6() {
        var data = google.visualization.arrayToDataTable([';
		$code6 .= '[\'Abonamente\', \'Nr. total\'],';
		for ($i=1;$i<4;$i++) {
			if ($i == 1) {
				$db_qr = "1";
				$tip = "H2O";
			} elseif ($i == 2) {
				$db_qr = "2";
				$tip = "Diesel";
			} elseif ($i == 3) {
				$db_qr = "3";
				$tip = "Kerosen";
			}
			$query = "SELECT count(*) FROM #__sa_profiles WHERE `abonament` = '".$db_qr."'";
			$db->setQuery($query);
			$rez = $db->loadResult();
			$code6 .= "['".$tip."',  ".$rez." ]";
			if ($i != 3) { $code6 .= ","; }
		} 
$code6 .= ']);

        var options = {
          title: \'Grafic abonamente firme\'
        };

        var chart6 = new google.visualization.PieChart(document.getElementById(\'abonamente\'));

        chart6.draw(data, options);
      }';
$document->addScriptDeclaration($code6);
?>
<div style="display:inline;">
	<div id="this_year" style="width: 500px; height: 400px;float:left;"></div>
	<div id="last_year" style="width: 500px; height: 400px;float:left;margin-left:20px;"></div>
</div>
<div style="clear:both;"></div>

<br /><br />
<div style="display:inline;">
	<div id="metode_plata" style="width: 500px; height: 400px;float:left;"></div>
	<div id="incasari" style="width: 500px; height: 400px;float:left;margin-left:20px;"></div>
</div>
<div style="clear:both;"></div>

<br /><br />
<div style="display:inline;">
	<div id="users" style="width: 500px; height: 400px;float:left;"></div>
	<div id="abonamente" style="width: 500px; height: 400px;float:left;margin-left:20px;"></div>
</div>
<div style="clear:both;"></div>