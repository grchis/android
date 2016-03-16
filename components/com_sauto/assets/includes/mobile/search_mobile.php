<div id="m_visitors" style="background-color:#F9F9F9">
	<?php require_once('menu_filter.php');?>
	<div class = "main-container">
		<form action="/android/index.php?option=com_sauto&amp;view=searching" method="post" name="search_form" id="search_form">
		<fieldset style="margin-bottom: 15px;">
				<p>Firma: </p>
				<input type="text" name="firma" style="width: 96%; margin-left:2%;margin-right:2%;" />
				
				
				<p>Domeniu de activitate</p>
				<select name="domeniu" style="width: 100%;">
					<option value="">Alege domeniul de activitate</option>
				<option value="1-1">Piese auto</option>
				<option value="2-1">Inchirieri</option>
				<option value="3-1">Auto noi</option>
				<option value="4-1">Auto rulate</option>
				<option value="5-1">Tractari auto</option>
				<option value="8-1">Service auto</option>
				<option value="9-1">Tuning</option>			
				</select>
				
				<p>Judet</p>
			<select name="judet" style="width: 100%;">
				<option value="">Alege judetul</option>
			<option id="Alba">Alba</option>
			<option id="Arad">Arad</option>
			<option id="Arges">Arges</option>
			<option id="Bacau">Bacau</option>
			<option id="Bihor">Bihor</option>
			<option id="Bistrita-Nasaud">Bistrita-Nasaud</option>
			<option id="Botosani">Botosani</option>
			<option id="Braila">Braila</option>
			<option id="Brasov">Brasov</option>
			<option id="Bucuresti">Bucuresti</option>
			<option id="Buzau">Buzau</option>
			<option id="Calarasi">Calarasi</option>
			<option id="Caras-Severin">Caras-Severin</option>
			<option id="Cluj">Cluj</option>
			<option id="Constanta">Constanta</option>
			<option id="Covasna">Covasna</option>
			<option id="Dambovita">Dambovita</option>
			<option id="Dolj">Dolj</option>
			<option id="Galati">Galati</option>
			<option id="Giurgiu">Giurgiu</option>
			<option id="Gorj">Gorj</option>
			<option id="Harghita">Harghita</option>
			<option id="Hunedoara">Hunedoara</option>
			<option id="Ialomita">Ialomita</option>
			<option id="Iasi">Iasi</option>
			<option id="Ilfov">Ilfov</option>
			<option id="Maramures">Maramures</option>
			<option id="Mehedinti">Mehedinti</option>
			<option id="Mures">Mures</option>
			<option id="Neamt">Neamt</option>
			<option id="Olt">Olt</option>
			<option id="Prahova">Prahova</option>
			<option id="Salaj">Salaj</option>
			<option id="Satu Mare">Satu Mare</option>
			<option id="Sibiu">Sibiu</option>
			<option id="Suceava">Suceava</option>
			<option id="Teleorman">Teleorman</option>
			<option id="Timis">Timis</option>
			<option id="Tulcea">Tulcea</option>
			<option id="Valcea">Valcea</option>
			<option id="Vaslui">Vaslui</option>
			<option id="Vrancea">Vrancea</option>			
			</select>
					<p>Tip Vanzator</p>
				<select name="abonament" style="width: 100%;">
					<option value="">Alege tipul de vanzator</option>
				<option value="1">H2O</option>
				<option value="2">Motorina</option>
				<option value="3">Kerosen</option>
				</select>
				</fieldset>
			<div id="submit" style="width: 96%; margin-left:2%;margin-right:2%;margin: 0px auto; padding-top: 10px; text-align: center; height: 50px; background-color: #509EFF; color: white; font-size: 2.4em; padding-bottom: 10px;">
				Cauta Firme
			</div>
		</form>
	</div>
</div>


<script>
document.getElementById('submit').addEventListener('click', function (event) {
		event.stopPropagation();
		event.preventDefault();
		var form = document.getElementsByTagName('form')[0];
		form.submit();
	});
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')
		if (jQuery('#wrapper9 > h1')[0]) {
			jQuery('#wrapper9 > h1')[0].remove();
		}
		if (jQuery('#m_table')) {
			jQuery('#m_table').remove();
		}
		if (jQuery('#gkTopBar')) {
			jQuery('#gkTopBar').remove();
		}
		if (jQuery('#side_bar')) {
			jQuery('#side_bar').hide();
		}
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);

</script>

<style type="text/css">
form {
    margin: 0;
    padding-left: 2%;
    padding-right: 2%;
}
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>