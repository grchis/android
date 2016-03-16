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
		require("fin_menu.php");
		?>
		</td>
		<td valign="top">
			<?php
			$action =& JRequest::getVar( 'action', '', 'get', 'string' );
			switch ($action) {
				case '':
				default:
				require("fin_default.php");
				break;
				case 'facturi':
				require("fin_facturi.php");
				break;
				case 'abonati':
				require("fin_abonati.php");
				break;
				case 'aproba':
				require("fin_aproba.php");
				break;
				case 'solicitate':
				require("fin_solicitate.php");
				break;
				case 'sent':
				require("fin_sent.php");
				break;
				case 'del':
				require("fin_del.php");
				break;
				case 'factura':
				require("fin_factura.php");
				break;
				case 'platite':
				require("fin_platite.php");
				break;
				case 'delete':
				require("fin_delete.php");
				break;
				case 'grafice':
				require("fin_grafice.php");
				break;
			}
			?>
			
		</td>
	</tr>
</table>
