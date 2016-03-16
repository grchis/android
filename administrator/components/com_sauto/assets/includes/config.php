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
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$list = $db->loadObject();
$link_form = 'index.php?option=com_sauto&task=prelucrari&action=save_config';
?>
<h3>Configurare componenta</h3>
<form method="post" action="<?php echo $link_form; ?>">
<table width="100%" cellpadding="0" cellspacing="0"  class="sa_table_class">
	<thead>
		<tr>
			<th class="sa_table_head">Optiune</th>
			<th class="sa_table_head">Input</th>
			<th class="sa_table_head">Descriere</th>
		</tr>
	</thead>
	<tbody>
		<tr class="sa-row1">
			<td class="sa_table_data">Articol login</td>
			<td class="sa_table_data">
				<input type="text" name="login_article" value="<?php echo $list->login_article; ?>" />
			</td>
			<td class="sa_table_data">Adaugati id-ul articolului pe care-l doriti afisat la autentificare.</td>
		</tr>
		
		<tr class="sa-row0">
			<td class="sa_table_data">Articol Alerte</td>
			<td class="sa_table_data">
				<input type="text" name="alerts_article" value="<?php echo $list->alerts_article; ?>" />
			</td>
			<td class="sa_table_data">Adaugati id-ul articolului pe care-l doriti afisat la alerte - partea lateral-dreapta a formularului.</td>
		</tr>
		
		<tr class="sa-row1">
			<td class="sa_table_data">Articol jos alerte</td>
			<td class="sa_table_data">
				<input type="text" name="alert_det_article" value="<?php echo $list->alert_det_article; ?>" />
			</td>
			<td class="sa_table_data">Adaugati id-ul articolului pe care-l doriti afisat la alerte - partea de jos a formularului.</td>
		</tr>
		
		
		<tr class="sa-row0">
			<td class="sa_table_data" valign="top">Tutorial client</td>
			<td class="sa_table_data">
				<?php
				$editor =& JFactory::getEditor();
				echo $editor->display('tutorial_client', $list->tutorial_client, '300', '150', '60', '20', false);
				?>
			</td>
			<td class="sa_table_data" valign="top">Cod pentru tutorial video pentru inregistrarea clientilor</td>
		</tr>
		<tr class="sa-row1">
			<td class="sa_table_data" valign="top">Tutorial firma</td>
			<td class="sa_table_data">
				<?php
				echo $editor->display('tutorial_firma', $list->tutorial_firma, '300', '150', '60', '20', false);
				?>
			</td>
			<td class="sa_table_data" valign="top">Cod pentru tutorial video pentru inregistrarea companiilor</td>
		</tr>
		<tr class="sa-row0">
			<td class="sa_table_data" valign="top">Mesaj inregistrare</td>
			<td class="sa_table_data" valign="top">
				<select name="custom_register">
					<option value="1" <?php if ($list->custom_register == 1) { echo ' selected '; } ?>>Mesaj personalizat</option>
					<option value="0" <?php if ($list->custom_register == 0) { echo ' selected '; } ?>>Mesaj standard</option>
				</select>
			</td>
			<td class="sa_table_data" valign="top">Afisarea unui mesaj personalizat la inregistrarea clientilor si a companiilor<br />
			Mesaj personalizat: afisarea unui text personalizat in momentul inregistrarii unui cont<br />
			Mesaj standard: afisarea ultimelor anunturi si oferte facute pe site<br />
			</td>
		</tr>
		<tr class="sa-row1">
			<td class="sa_table_data" valign="top">Mesaj client</td>
			<td class="sa_table_data">
				<?php
				echo $editor->display('custom_register_client', $list->custom_register_client, '300', '150', '60', '20', false);
				?>
			</td>
			<td class="sa_table_data" valign="top">Afisarea unui mesaj personalizat afisat la autentificarea clientilor</td>
		</tr>
		<tr class="sa-row0">
			<td class="sa_table_data" valign="top">Mesaj companie</td>
			<td class="sa_table_data">
				<?php
				echo $editor->display('custom_register_firma', $list->custom_register_firma, '300', '150', '60', '20', false);
				?>
			</td>
			<td class="sa_table_data" valign="top">Afisarea unui mesaj personalizat afisat la autentificarea companiilor</td>
		</tr>
		<tr class="sa-row1">
			<td class="sa_table_data" valign="top">Activare Re-captcha</td>
			<td class="sa_table_data" valign="top">
				<select name="enable_captcha">
					<option value="1" <?php if ($list->enable_captcha == 1) { echo ' selected '; } ?>>Activat</option>
					<option value="0" <?php if ($list->enable_captcha == 0) { echo ' selected '; } ?>>Dezactivat</option>
				</select>
			</td>
			<td class="sa_table_data" valign="top">Activarea codului captcha foilosit la inregistrare</td>
		</tr>
		<tr class="sa-row0">
			<td class="sa_table_data" valign="top">Public key</td>
			<td class="sa_table_data">
				<textarea name="public_key" cols="35" rows="5"><?php echo $list->public_key; ?></textarea>
			</td>
			<td class="sa_table_data" valign="top">Adaugarea Public Key oferita de catre Google pentru codul re-captcha</td>
		</tr>
		<tr class="sa-row1">
			<td class="sa_table_data" valign="top">Private key</td>
			<td class="sa_table_data">
				<textarea name="private_key" cols="35" rows="5"><?php echo $list->private_key; ?></textarea>
			</td>
			<td class="sa_table_data" valign="top">Adaugarea Private Key oferita de catre Google pentru codul re-captcha</td>
		</tr>
		<tr class="sa-row0">
			<td class="sa_table_data">Termeni si conditii</td>
			<td class="sa_table_data">
				<input type="text" name="link_terms" value="<?php echo $list->link_terms; ?>" />
			</td>
			<td class="sa_table_data">Id-ul articolului catre Termenii si conditiile site-ului</td>
		</tr>
		<tr class="sa-row1">
			<td class="sa_table_data">Marime imagine</td>
			<td class="sa_table_data">
				<input type="text" name="max_size" value="<?php echo $list->max_size; ?>" />
			</td>
			<td class="sa_table_data">Marimea maxima permisa la upload a unei imagini</td>
		</tr>
		<tr class="sa-row0">
			<td class="sa_table_data" valign="top">Extensii valide</td>
			<td class="sa_table_data">
				<textarea name="valid_ext" cols="35" rows="5"><?php echo $list->valid_ext; ?></textarea>
			</td>
			<td class="sa_table_data" valign="top">Extensii valide pentru imagini</td>
		</tr>
		<tr class="sa-row1">
			<td class="sa_table_data" valign="top">Mime types</td>
			<td class="sa_table_data">
				<textarea name="mime_types" cols="35" rows="5"><?php echo $list->mime_types; ?></textarea>
			</td>
			<td class="sa_table_data" valign="top">Mime-types valide pentru imagini</td>
		</tr>
		<tr class="sa-row0">
			<td class="sa_table_data">Alerte clienti</td>
			<td class="sa_table_data">
				<input type="text" name="alerte_clienti" value="<?php echo $list->alerte_clienti; ?>" />
			</td>
			<td class="sa_table_data">Numarul alertelor pentru clienti</td>
		</tr>
		<tr class="sa-row1">
			<td class="sa_table_data">Alerte companii</td>
			<td class="sa_table_data">
				<input type="text" name="alerte_dealer" value="<?php echo $list->alerte_dealer; ?>" />
			</td>
			<td class="sa_table_data">Numarul alertelor pentru firme</td>
		</tr>
		
		<tr class="sa-row0">
			<td class="sa_table_data">Articol Cerere</td>
			<td class="sa_table_data">
				<input type="text" name="request_article" value="<?php echo $list->request_article; ?>" />
			</td>
			<td class="sa_table_data">Adaugati id-ul articolului pe care-l doriti afisat in pagina clientilor sectiunea "Adauga cerere".</td>
		</tr>
		
		<tr class="sa-row1">
			<td class="sa_table_data">Link Suport</td>
			<td class="sa_table_data">
				<input type="text" name="disabled" value="" />
			</td>
			<td class="sa_table_data">Nu se completeaza!</td>
		</tr>
		
		<tr class="sa-row0">
			<td class="sa_table_data">Cautare cereri 1</td>
			<td class="sa_table_data">
				<input type="text" name="search_req_right_article" value="<?php echo $list->search_req_right_article; ?>" />
			</td>
			<td class="sa_table_data">Adaugati id-ul articolului pe care-l doriti afisat in pagina firmelor sectiunea "cauta cerere" in partea dreapta.</td>
		</tr>
		
		<tr class="sa-row1">
			<td class="sa_table_data">Cautare cereri 2</td>
			<td class="sa_table_data">
				<input type="text" name="search_req_bottom_article" value="<?php echo $list->search_req_bottom_article; ?>" />
			</td>
			<td class="sa_table_data">Adaugati id-ul articolului pe care-l doriti afisat in pagina firmelor sectiunea "cauta cerere" in partea de jos a formularului.</td>
		</tr>

		<tr class="sa-row0">
			<td class="sa_table_data">Modul login</td>
			<td class="sa_table_data">
				<input type="text" name="login_module" value="<?php echo $list->login_module; ?>" />
			</td>
			<td class="sa_table_data">Setati pozitia unui modul custom_login folosit la autentificarea pe site.</td>
		</tr>
		<tr class="sa-row1">
			<td class="sa_table_data">Modul login</td>
			<td class="sa_table_data">
				<input type="text" name="login_module2" value="<?php echo $list->login_module2; ?>" />
			</td>
			<td class="sa_table_data">Setati pozitia unui modul custom_login folosit la autentificarea pe site pentru adaugarea anunt vizitatori.</td>
		</tr>
		<tr class="sa-row0">
			<td class="sa_table_data">Modul login</td>
			<td class="sa_table_data">
				<input type="text" name="login_module3" value="<?php echo $list->login_module3; ?>" />
			</td>
			<td class="sa_table_data">Setati pozitia unui modul custom_login folosit la autentificarea pe site pentru adaugare de oferte la firme.</td>
		</tr>
		<tr class="sa-row1">
			<td class="sa_table_data">Modul login</td>
			<td class="sa_table_data">
				<input type="text" name="login_module4" value="<?php echo $list->login_module4; ?>" />
			</td>
			<td class="sa_table_data">Setati pozitia unui modul custom_login folosit la autentificarea pe site pentru selectarea unei oferte castigatoare.</td>
		</tr>
		
		<tr class="sa-row0">
			<td class="sa_table_data">Articol oferte</td>
			<td class="sa_table_data">
				<input type="text" name="id_article_all" value="<?php echo $list->id_article_all; ?>" />
			</td>
			<td class="sa_table_data">Adaugati id-ul articolului pe care-l doriti afisat in pagina cu toate ofertele afisate. Afisarea este in partea dreapta.</td>
		</tr>
		
		
		<tr class="sa-row1">
			<td class="sa_table_data">Link Google Play</td>
			<td class="sa_table_data">
				<input type="text" name="google_play" value="<?php echo $list->google_play; ?>" />
			</td>
			<td class="sa_table_data">Adaugare link spre aplicatia android</td>
		</tr>
		
		
		<tr class="sa-row0">
			<td class="sa_table_data" colspan="3"><strong>Id articole categorii anunturi</strong></td>
		</tr>
		<?php
		//incarcam id-uri articole/categorii
		$query = "SELECT * FROM #__sa_tip_anunt";
		$db->setQuery($query);
		$tips = $db->loadObjectList();
		foreach ($tips as $t) {
			if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
			echo '<tr class="'.$style.'">';
				echo '<td class="sa_table_data">';
					if ($t->published == 1) {
						echo '<span style="color:green;">';
					} else {
						echo '<span style="color:red;">';
					}
					echo $t->tip;
					echo '</span>';
				echo '</td>';
				echo '<td class="sa_table_data">';
					echo '<input type="text" name="article_id_'.$t->id.'" value="'.$t->article_id.'" />';
				echo '</td>';
				echo '<td class="sa_table_data">In articol alocat categoriei '.$t->tip.'</td>';
			echo '</tr>';
		}
		?>
		<tr class="sa-row2">
			<td class="sa_table_data"></td>
			<td class="sa_table_data"><input type="submit" value="Salvare optiuni" /></td>
			<td class="sa_table_data"></td>
		</tr>

	</tbody>
</table>
</form>
