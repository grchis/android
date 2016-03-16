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
$document =& JFactory::getDocument();
$document->addStyleSheet( 'components/com_sauto/assets/style.css' );

$task =& JRequest::getVar( 'task', '', 'get', 'string' );
require("assets/includes/menu.php");
?>
<h1>Site auto - anunturi</h1>
<table width="100%">
	<tr>
		<td valign="top">
			<?php
			meniu();
			?>
		</td>
	</tr>
	<tr>
		<td valign="top">
		<?php
		switch ($task) {
			case '':
			default:
			require("assets/includes/home.php");
			sumar();
			break;
			case 'anunturi':
			require("assets/includes/anunturi.php");
			break;
			case 'users':
			require("assets/includes/users.php");
			break;
			case 'dealers':
			require("assets/includes/dealers.php");
			break;
			case 'raportate':
			require("assets/includes/raportate.php");
			break;
			case 'city':
			require("assets/includes/city.php");
			city();
			break;
			case 'marci':
			require("assets/includes/marci.php");
			marci();
			break;
			case 'modele':
			require("assets/includes/modele.php");
			break;
			case 'setari':
			require("assets/includes/setari.php");
			break;
			case 'config':
			require("assets/includes/config.php");
			break;
			case 'prelucrari':
			require("assets/includes/prelucrari.php");
			break;
			case 'anunt':
			require("assets/includes/anunt.php");
			break;
			case 'profil':
			require("assets/includes/profil.php");
			break;
			case 'edit_anunt':
			require("assets/includes/edit_anunt.php");
			break;
			case 'save_anunt':
			require("assets/includes/save_anunt.php");
			break;
			case 'delete_anunt':
			require("assets/includes/delete_anunt.php");
			break;
			case 'edit_oferta':
			require("assets/includes/edit_oferta.php");
			break;
			case 'list_reported':
			require("assets/includes/list_reported.php");
			break;
			case 'anunturi_active':
			require("assets/includes/anunturi_active.php");
			break;
			case 'anunturi_finalizate':
			require("assets/includes/anunturi_finalizate.php");
			break;
			case 'edit_user':
			require("assets/includes/edit_user.php");
			break;
			case 'save_user':
			require("assets/includes/save_user.php");
			break;
			case 'edit_dealer':
			require("assets/includes/edit_dealer.php");
			break;
			case 'save_dealer':
			require("assets/includes/save_dealer.php");
			break;
			case 'castigate':
			require("assets/includes/castigate.php");
			break;
			case 'financiar':
			require("assets/includes/fin.php");
			break;
			case 'comment_list':
			require("assets/includes/comm.php");
			break;
			case 'oferte':
			require("assets/includes/oferte.php");
			break;
			case 'set_vars':
			require("assets/includes/set_vars.php");
			break;
			case 'delete_profile':
			require("assets/includes/delete_profile.php");
			break;
			case 'restore_profile':
			require("assets/includes/restore_profile.php");
			break;
			case 'promo':
			require("assets/includes/promo.php");
			break;
			case 'alerte':
			require("assets/includes/alerte.php");
			break;
		}
		?>
		</td>
	</tr>
</table>
