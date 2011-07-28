
<h1><?php echo Kohana::lang('kmlonbydefault.kmlonbydefault');?></h1>
<h4> 
	<br/> <?php echo Kohana::lang('kmlonbydefault.kmlonbydefault_description');?>
<h4>
<br/>
<br/>
<?php print form::open(); ?>


	<?php  if ($form_saved) {?>
		<!-- green-box -->
		<div class="green-box">
		<h3><?php echo Kohana::lang('ui_main.configuration_saved');?></h3>
		</div>
	<?php } ?>

<table class="table">
	<?php foreach($layers as $layer) {?>
		<tr>
			<td style="width:250px;">
				<input type="checkbox" name="layer_<?php echo $layer->id;?>" id="layer_<?php echo $layer->id;?>" value="layer_<?php echo $layer->id;?>" 
					<?php if($layer->kmlonbydefault_id != null){echo "checked";} ?> />
				<?php echo Kohana::lang('kmlonbydefault.show_by_default');?>
			</td>			
			<td> 
				<h3><?php echo $layer->layer_name;?></h3>
			</td>
		</tr>	
	<?php }?>
</table>

<br/><br/>

<input type="image" src="<?php echo url::base() ?>media/img/admin/btn-save-settings.gif" class="save-rep-btn" style="margin-left: 0px;" />

<?php print form::close(); ?>
