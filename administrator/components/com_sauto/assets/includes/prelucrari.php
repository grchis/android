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

$action =& JRequest::getVar( 'action', '', 'get', 'string' );

switch ($action) {
	case 'add_city':
	require("p_add_city.php");
	break;
	case 'delete_city':
	require("p_delete_city.php");
	break;
	case 'delete_city2':
	require("p_delete_city2.php");
	break;
	case 'aprob_city':
	require("p_aprob_city.php");
	break;
	case 'edit_city':
	require("p_edit_city.php");
	break;
	case 'abonament':
	require("p_abonament.php");
	break;
	case 'edit_marca':
	require("p_edit_marca.php");
	break;
	case 'add_model':
	require("p_add_model.php");
	break;
	case 'edit_model':
	require("p_edit_model.php");
	break;
	case 'delete_model':
	require("p_delete_model.php");
	break;
	case 'publish_city':
	require("p_publish_city.php");
	break;
	case 'publish_marca':
	require("p_publish_marca.php");
	break;
	case 'publish_model':
	require("p_publish_model.php");
	break;
	case 'add_marca':
	require("p_add_marca.php");
	break;
	case 'delete_marca':
	require("p_delete_marca.php");
	break;
	case 'add_carburant':
	require("p_add_carburant.php");
	break;
	case 'edit_carburant':
	require("p_edit_carburant.php");
	break;
	case 'delete_carburant':
	require("p_delete_carburant.php");
	break;
	case 'add_caroserie':
	require("p_add_caroserie.php");
	break;
	case 'edit_caroserie':
	require("p_edit_caroserie.php");
	break;
	case 'delete_caroserie':
	require("p_delete_caroserie.php");
	break;
	case 'add_stare':
	require("p_add_stare.php");
	break;
	case 'edit_stare':
	require("p_edit_stare.php");
	break;
	case 'delete_stare':
	require("p_delete_stare.php");
	break;
	case 'add_usi':
	require("p_add_usi.php");
	break;
	case 'edit_usi':
	require("p_edit_usi.php");
	break;
	case 'delete_usi':
	require("p_delete_usi.php");
	break;
	case 'anunt':
	require("p_anunt.php");
	break;
	case 'plati':
	require("p_plati.php");
	break;
	case 'publish_plati':
	require("p_publish_plati.php");
	break;
	case 'add_moneda':
	require("p_add_moneda.php");
	break;
	case 'publish_moneda':
	require("p_publish_moneda.php");
	break;
	case 'edit_moneda':
	require("p_edit_moneda.php");
	break;
	case 'edit_moneda_s':
	require("p_edit_moneda_s.php");
	break;
	case 'delete_moneda':
	require("p_delete_moneda.php");
	break;
	case 'save_config':
	require("p_save_config.php");
	break;
	case 'edit_oferta':
	require("p_edit_oferta.php");
	break;
	case 'raportat':
	require("p_raportat.php");
	break;
	case 'add_reclama':
	require("p_add_reclama.php");
	break;
	case 'edit_reclama':
	require("p_edit_reclama.php");
	break;
	case 'editing_reclama':
	require("p_editing_reclama.php");
	break;
	case 'delete_reclama':
	require("p_delete_reclama.php");
	break;
	case 'publish_reclama':
	require("p_publish_reclama.php");
	break;
}
