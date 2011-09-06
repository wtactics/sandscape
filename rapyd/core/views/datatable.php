
<!-- datatable begin //-->
<div class="datagrid">

<table class="table collapsed">
  <tr>
    <td>
			<?php if($header_footer):?>
      <table class="collapsed">
        <tr>
          <td class="dt_header"><?php echo $label?></td>
          <td class="dt_header" align="right"><?php echo $container["TR"]?></td>
        </tr>
      </table>
			<?php endif;?>
      <div class="dt_content">

				<table width="100%" cellspacing="0" cellpadding="0">
				<?php if (count($trs)>0)://table-rows?>
				<?php foreach ($trs as $tds):?>
					<tr>
				<?php foreach ($tds as $td):?>
						<td <?php echo $td["attributes"]?>><?php echo $td["content"]?></td>
				<?php endforeach;?>
					</tr>
				<?php endforeach;?>
				<?php endif;//table-rows?>
				</table>

      </div>
			<div class="pagination">
			<?php echo $pagination;?>
			</div>
			<?php if($header_footer):?>
			<div class="dt_footer">
				<div>
					<div style="float:left"><?php echo $container["BL"]?></div>
					<div style="float:right"><?php echo $container["BR"]?></div>
				</div><div style="clear:both;"></div>
			</div>
			<?php endif;?>

    </td>
  </tr>
</table>

</div><!-- datatable end //-->
