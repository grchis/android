<style type="text/css">
.main-container {
    width: 96%;
    margin-right: 2%;
    margin-left: 2%;
}
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
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$img_path = JURI::base()."components/com_sauto/assets/images/";
$link_categ_1 = JRoute::_('index.php?option=com_sauto&view=categories&id=1');
$link_categ_2 = JRoute::_('index.php?option=com_sauto&view=categories&id=2');
$link_categ_3 = JRoute::_('index.php?option=com_sauto&view=categories&id=3');
$link_categ_4 = JRoute::_('index.php?option=com_sauto&view=categories&id=4');
$link_categ_5 = JRoute::_('index.php?option=com_sauto&view=categories&id=5');
$link_categ_8 = JRoute::_('index.php?option=com_sauto&view=categories&id=8');
$link_categ_7 = JRoute::_('index.php?option=com_sauto&view=categories&id=7');

$link_request = JRoute::_('index.php?option=com_sauto&view=requests');
$link_new_request = JRoute::_('index.php?option=com_sauto&view=new_request');
/*
?>
<table width="100%" class="sa_table_class">
	<tr class="sa_table_row">
		<td colspan="2" class="sa_table_cell">
	<img src="<?php echo $img_path; ?>fp-header.jpg" width="1055" />
		</td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell">
		</td>
		<td valign="top" class="sa_table_cell">
			<div class="sauto_login_title">
				<?php echo JText::_('SAUTO_ACOUNT_EXIST'); ?>
			</div>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell">
			<table width="100%" class="sa_table_class" style="margin-top:5px;">
				<tr class="sa_table_row">
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_1; ?>">
							<img src="<?php echo $img_path; ?>fi_dezmembrari.png" />
						</a>
					</td>
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_8; ?>">
							<img src="<?php echo $img_path; ?>fi_piese_noi.png" />
						</a>
					</td>
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_2; ?>">
							<img src="<?php echo $img_path; ?>fi_inchirieri.png" />
						</a>
					</td>
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_5; ?>">
							<img src="<?php echo $img_path; ?>fi_tractari.png" />	
						</a>	
					</td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_1; ?>">
							<?php echo JText::_('SA_FP_AUTO_NOI'); ?>
						</a>
					</td>
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_8; ?>">
							<?php echo JText::_('SA_FP_AUTO_SERVICE'); ?>
						</a>
					</td>
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_2; ?>">
							<?php echo JText::_('SA_FP_INCHIRIERI'); ?>
						</a>
					</td>
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_5; ?>">
							<?php echo JText::_('SA_FP_TRACTARI'); ?>
						</a>
					</td>
				</tr>
				<tr class="sa_table_row">
					
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_4; ?>">
							<img src="<?php echo $img_path; ?>fi_auto_rulate.png" />
						</a>
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_3; ?>">
							<img src="<?php echo $img_path; ?>fi_auto_noi.png" />
						</a>
					</td>
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_7; ?>">
							<img src="<?php echo $img_path; ?>fi_tuning.png" />
						</a>
					</td>
					<td class="sa_table_cell">
						<a href="<?php echo $link_request; ?>">
							<img src="<?php echo $img_path; ?>fi_altele.png" />
						</a>
					</td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_4; ?>">
							<?php echo JText::_('SA_FP_V_AUTO_SH'); ?>
						</a>
					</td>
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_3; ?>">
							<?php echo JText::_('SA_FP_V_AUTO_NOI'); ?>
						</a>
					</td>
					
					<td class="sa_table_cell">
						<a href="<?php echo $link_categ_7; ?>">
							<?php echo JText::_('SA_FP_ACCESORII'); ?>
						</a>
					</td>
					
					
					<td class="sa_table_cell">
						<a href="<?php echo $link_request; ?>">
							<?php echo JText::_('SA_FP_ALL'); ?>
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" class="sa_table_cell" rowspan="2">
		
		
		<div class="sauto_login_module">
			<?php
			jimport('joomla.application.module.helper');
			$modules = JModuleHelper::getModules($sconfig->login_module);
				foreach($modules as $module) {
				echo JModuleHelper::renderModule($module);
				}
			?>
		</div>
		</td>
	</tr>
	<tr class="sa_table_row">
		<td valign="top" align="center" class="sa_table_cell">	
<a href="<?php echo $link_new_request; ?>" class="sauto_button_half" style="position:relative;top:-17px;" />
	<?php echo JText::_('SAUTO_ADD_ANUNT_BUTTON'); ?>
</a>
		</td>

	</tr>
	<tr class="sa_table_row">
		<td valign="top" class="sa_table_cell">
		</td>
		<td valign="top" class="sa_table_cell">
			<div class="sauto_login_title" style="position:relative;float:right;margin-right:82px;top:-35px;">
				<?php echo JText::_('SAUTO_ACOUNT_NOT_EXIST'); ?>
			</div>
		</td>
	</td>
</table>

<br /><br /><hr /><br /><br />

	

<div style="display:inline-block;">
	<center>
	<div style="float:left;width:48%;margin-top:80px;" id="sa_viz_left">
		<div style="display:inline-block;">
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_1; ?>">
				<img src="<?php echo $img_path; ?>fi_dezmembrari.png" />
			</a>
			<br />
			<a href="<?php echo $link_categ_1; ?>">
				<?php echo JText::_('SA_FP_AUTO_NOI'); ?>
			</a>
		</div>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_8; ?>">
				<img src="<?php echo $img_path; ?>fi_piese_noi.png" />
			</a><br />
			<a href="<?php echo $link_categ_8; ?>">
				<?php echo JText::_('SA_FP_AUTO_SERVICE'); ?>
			</a>
		</div>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_2; ?>">
				<img src="<?php echo $img_path; ?>fi_inchirieri.png" />
			</a><br />
			<a href="<?php echo $link_categ_2; ?>">
				<?php echo JText::_('SA_FP_INCHIRIERI'); ?>
			</a>
		</div>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_5; ?>">
				<img src="<?php echo $img_path; ?>fi_tractari.png" />	
			</a><br />
			<a href="<?php echo $link_categ_5; ?>">
				<?php echo JText::_('SA_FP_TRACTARI'); ?>
			</a>
		</div>
		</div>
		<div style="display:inline-block;">
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_4; ?>">
				<img src="<?php echo $img_path; ?>fi_auto_rulate.png" />
			</a><br />
			<a href="<?php echo $link_categ_4; ?>">
				<?php echo JText::_('SA_FP_V_AUTO_SH'); ?>
			</a>
		</div>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_3; ?>">
				<img src="<?php echo $img_path; ?>fi_auto_noi.png" />
			</a><br />
			<a href="<?php echo $link_categ_3; ?>">
				<?php echo JText::_('SA_FP_V_AUTO_NOI'); ?>
			</a>
		</div>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_7; ?>">
				<img src="<?php echo $img_path; ?>fi_tuning.png" />
			</a><br />
			<a href="<?php echo $link_categ_7; ?>">
				<?php echo JText::_('SA_FP_ACCESORII'); ?>
			</a>
		</div>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_request; ?>">
				<img src="<?php echo $img_path; ?>fi_altele.png" />
			</a><br />
			<a href="<?php echo $link_request; ?>">
				<?php echo JText::_('SA_FP_ALL'); ?>
			</a>
		</div>
		</div>
		<div class="sa_fp_add">
			<a href="<?php echo $link_new_request; ?>" class="sauto_button_half" style="position:relative;top:-17px;" />
				<?php echo JText::_('SAUTO_ADD_ANUNT_BUTTON'); ?>
			</a>
		</div>
		
	</div>
	</center>
	<div style="float:left;width:48%;" id="sa_viz_right">
		<div class="sauto_login_module">
			<div class="sauto_login_title">
				<?php echo JText::_('SAUTO_ACOUNT_EXIST'); ?>
			</div>
			<?php
			jimport('joomla.application.module.helper');
			$modules = JModuleHelper::getModules($sconfig->login_module);
				foreach($modules as $module) {
				echo JModuleHelper::renderModule($module);
				}
			?>
			<div class="sauto_login_title" style="position:relative;float:right;">
				<?php echo JText::_('SAUTO_ACOUNT_NOT_EXIST'); ?>
			</div>
		</div>
	</div>
</div>
<div style="clear:both;"></div>
*/ 
?>
<div id="m_table">
<div id="sa_viz_main">
	<div id="sa_viz_left">
		<center>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_1; ?>">
				<img src="<?php echo $img_path; ?>fi_dezmembrari.png" />
			</a>
			<br />
			<a href="<?php echo $link_categ_1; ?>">
				<?php echo JText::_('SA_FP_AUTO_NOI'); ?>
			</a>
		</div>
		
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_8; ?>">
				<img src="<?php echo $img_path; ?>fi_piese_noi.png" />
			</a><br />
			<a href="<?php echo $link_categ_8; ?>">
				<?php echo JText::_('SA_FP_AUTO_SERVICE'); ?>
			</a>
		</div>
		
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_2; ?>">
				<img src="<?php echo $img_path; ?>fi_inchirieri.png" />
			</a><br />
			<a href="<?php echo $link_categ_2; ?>">
				<?php echo JText::_('SA_FP_INCHIRIERI'); ?>
			</a>
		</div>
		
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_5; ?>">
				<img src="<?php echo $img_path; ?>fi_tractari.png" />	
			</a><br />
			<a href="<?php echo $link_categ_5; ?>">
				<?php echo JText::_('SA_FP_TRACTARI'); ?>
			</a>
		</div>
		
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_4; ?>">
				<img src="<?php echo $img_path; ?>fi_auto_rulate.png" />
			</a><br />
			<a href="<?php echo $link_categ_4; ?>">
				<?php echo JText::_('SA_FP_V_AUTO_SH'); ?>
			</a>
		</div>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_3; ?>">
				<img src="<?php echo $img_path; ?>fi_auto_noi.png" />
			</a><br />
			<a href="<?php echo $link_categ_3; ?>">
				<?php echo JText::_('SA_FP_V_AUTO_NOI'); ?>
			</a>
		</div>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_categ_7; ?>">
				<img src="<?php echo $img_path; ?>fi_tuning.png" />
			</a><br />
			<a href="<?php echo $link_categ_7; ?>">
				<?php echo JText::_('SA_FP_ACCESORII'); ?>
			</a>
		</div>
		<div class="sa_fp_icons">
			<a href="<?php echo $link_request; ?>">
				<img src="<?php echo $img_path; ?>fi_altele.png" />
			</a><br />
			<a href="<?php echo $link_request; ?>">
				<?php echo JText::_('SA_FP_ALL'); ?>
			</a>
		</div>
		<div id="sa_fp_add_btn">
			<a href="<?php echo $link_new_request; ?>" class="sauto_button_half" style="position:relative;top:-17px;" />
				<?php echo JText::_('SAUTO_ADD_ANUNT_BUTTON'); ?>
			</a>
		</div>
		</center>
	</div>
	<div id="sa_viz_rigth">
			<div class="sauto_login_title">
				<?php echo JText::_('SAUTO_ACOUNT_EXIST'); ?>
			</div>
			<?php
			jimport('joomla.application.module.helper');
			$modules = JModuleHelper::getModules($sconfig->login_module);
				foreach($modules as $module) {
				echo JModuleHelper::renderModule($module);
				}
			?>
			<div class="sauto_login_title" style="position:relative;float:right;">
				<?php echo JText::_('SAUTO_ACOUNT_NOT_EXIST'); ?>
			</div>
	</div>
</div>
<div style="clear:both;"></div>
</div>

<div id="m_visitors" style="background-color:#F9F9F9">
<?php
defined('_JEXEC') or die('Restricted access');
?>
	<div class = "m_header" style="width: 100%; height: 100px; background-color: #509EFF">
	</div>
	<div class = "main-container">
		<img src="images/logo.png" style="width: 100%; height: 100em;" />
		<form id="login-form" action="<?php echo JRoute::_( 'index.php' );?>"
			method="POST" name="login-form">
			
			<div style="width:80%; margin: 0px auto;">
					<p style="margin: 0;"> Am deja cont si vreau sa ma loghez: </p>
					
					<div id="form-login-username"style="width: 100%; margin-bottom: 15px;">
				   	<input id="modlgn-username" type="text" placeholder="Email..." name="username" class="sa_inputbox">
						</div><br>
				<div id="form-login-password" style="width: 100%; margin-bottom: 15px;">
					<input id="modlgn-passwd" type="password" name="password" class="sa_inputbox">
				</div>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="user.login" />
				<input type="hidden" id="return" name="return" value="<?php echo $return; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
			<div style="width:80%; margin: 0px auto;" >
				<input type="checkbox" >
				<span style="font-size: 1.3em; color: #509EFF">
					Remember me
				</span>
				<span style="font-size: 1.3em; color: #509EFF; float: right;"> Forgot password </span>
			</div>
			<div id="submit" style="margin: 0px auto; margin-bottom: 25px; padding-top: 10px; width:80%; text-align: center; height: 50px; background-color: #509EFF; color: white; font-size: 2.4em; padding-bottom: 10px;">
			
			LOGIN
			</div>
			<p style = "margin: 0px auto; width: 80%;"> Nu am cont si vreau sa ma inregistrez: </p>
			<div id="register" onclick="" style="margin: 0px auto; padding-top: 10px; width:80%; text-align: center; height: 50px; background-color: #509EFF; color: white; font-size: 2.4em; padding-bottom: 10px;">
			Creaza cont
			</div>
			
		</form>
	</div>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
</div>

<script>
	document.getElementById('submit').addEventListener('click', function (event) {
		event.stopPropagation();
		event.preventDefault();
		var form = document.getElementsByTagName('form')[0];
		form.submit();
	});
	document.getElementById('register').addEventListener('click',function(event){
		window.location.href='/android/index.php?option=com_sauto&amp;view=reg_form';
	})
	
	document.getElementById('login-form').getElementsByTagName('')
	
	var isMobile = navigator.userAgent.contains('Mobile');
	if (!isMobile) {
		document.getElementById('m_visitors').remove();
	} else {
		var tokenValue = document.getElementsByName('return')[0].value;
		document.getElementsByName('return')[1].value = tokenValue;
		document.getElementById('m_table').remove();
		document.getElementById('gkTopBar').remove();
		document.getElementById('gkFooterArea').remove();
	}
</script>


