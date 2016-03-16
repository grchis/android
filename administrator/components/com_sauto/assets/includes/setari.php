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
?>

<table width="100%">
	<tr>
		<td valign="top" width="200">
		<?php
		require("setari_meniu.php");
		?>
		</td>
		<td valign="top">
			<?php
			$action =& JRequest::getVar( 'action', '', 'get', 'string' );
			switch ($action) {
				case '':
				default:
				require("setari_default.php");
				break;
				case 'abonament':
				require("setari_abonament.php");
				break;
				case 'cities':
				require("setari_cities.php");
				break;
				case 'marci':
				require("setari_marci.php");
				break;
				case 'lista_modele':
				require("setari_lista_modele.php");
				break;
				case 'carburant':
				require("setari_carburant.php");
				break;
				case 'caroserie':
				require("setari_caroserie.php");
				break;
				case 'stare':
				require("setari_stare.php");
				break;
				case 'usi':
				require("setari_usi.php");
				break;
				case 'anunt':
				require("setari_anunt.php");
				break;
				case 'plati':
				require("setari_plati.php");
				break;
				case 'moneda':
				require("setari_moneda.php");
				break;
				case 'reclame':
				require("setari_reclame.php");
				break;
				case 'suport':
				require("setari_suport.php");
				break;
				case 'suport_edit':
				require("setari_suport_edit.php");
				break;
			}
			?>
			
		</td>
	</tr>
</table>
