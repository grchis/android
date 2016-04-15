<?php
defined('_JEXEC') || die('=;)');
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$link_form = JRoute::_('index.php?option=com_sauto&view=pay');
$query = "SELECT `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$abonament = $db->loadResult();
$time = time();
$old_date = $time - 1296000;
$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."' AND `tip_abn` = '2' AND `data_prf` > '".$old_data."'";
$db->setQuery($query);
$total_2 = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."' AND `tip_abn` = '3' AND `data_prf` > '".$old_data."'";
$db->setQuery($query);
$total_3 = $db->loadResult();
?>
<div id="m_visitors">
	<div id="abon1">
		<img class="subscribe-pic" src="<?php echo $img_path; ?>ab_kerosen.png" />
		<div class="check-boxes-subscribe">
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_1'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_2'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_3'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_4'); ?>
				</span>
			</div>
		</div>	
	</div>
	<div id="abon2">
		<img class="subscribe-pic" src="<?php echo $img_path; ?>ab_kerosen.png" />
		<div class="check-boxes-subscribe">
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_1'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_2'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_3'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_4'); ?>
				</span>
			</div>
		</div>
	</div>
	<div id="abon3">
		<img class="subscribe-pic" src="<?php echo $img_path; ?>ab_kerosen.png" />
		<div class="check-boxes-subscribe">
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_5'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>boxselectat.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_2'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_3'); ?>
				</span>
			</div>
			
			<div>
				<img src="<?php echo $img_path; ?>box.png" />
				<span class="sa_abon_span">
				<?php echo JText::_('SAUTO_ABONAMENT_4'); ?>
				</span>
			</div>
		</div>
	</div>

	<div id="payment">
		in progress
	</div>
</div>

<script type="text/javascript">
        document.getElementById('avatar-loader').addEventListener("click", triggerHiddenFileInput);

        document.getElementById('submit').addEventListener("click", submitForm);

        function triggerHiddenFileInput(event){
            event.preventDefault();
            event.stopPropagation();

            document.getElementById('hidden-file').click();
        }

        function submitForm(event)
        {
            event.preventDefault();
            event.stopPropagation();
            var form = document.getElementsByTagName('form')[0];
            form.submit();
        }

        if (document.getElementsByTagName('h1')[0])
        {
            document.getElementsByTagName('h1')[0].remove();
        }
        if (document.getElementById("side_bar"))
        {
            document.getElementById("side_bar").remove();
        }
        if(document.getElementsByTagName('center')[0])
        {
            document.getElementsByTagName('center')[0].remove();
        }
        if(document.getElementById('gkTopBar'))
        {
            document.getElementById('gkTopBar').remove();
        }
        if(document.getElementById('m_table'))
        {
            document.getElementById('m_table').remove();
        }
        document.write('<style type="text/css" >#content9{width: 100% !important;' +
            'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
            'width: 100% !important;}</style>'
        );

</script>

<style type="text/css">
	.check-boxes-subscribe {
		display: inline-block;
		vertical-align: top;
		margin-top: 15px;
	}
	.subscribe-pic {
		display: inline-block;
	}
</style>
