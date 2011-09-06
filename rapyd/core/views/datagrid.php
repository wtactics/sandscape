
<!-- datagrid begin //-->
<div class="datagrid">
<?php echo $form_begin?>
<table class="grid collapsed">
  <tr>
    <td>
      <table class="collapsed">
        <tr>
          <td class="dg_header"><?php if($label!='') echo $label.'&nbsp;('.$total_rows.')'?></td>
          <td class="dg_header" align="right"><?php echo $container["TR"]?></td>
        </tr>
      </table>

      <div class="dg_content">
      <table width="100%" cellpadding="1">
        <tr>
<?php foreach ($columns as $column)://table-header?>
<?php if (in_array($column->column_type, array("orderby","detail"))):?>
          <td class="table_header">
            <table class="collapsed">
              <tr>
                <td class="table_header_clean"><?php echo $column->label?></td>
                <td class="table_header_clean" style="width:32px;white-space:nowrap">
                  <a href="<?php echo $column->orderby_asc_url?>"><?php echo rpd_html_helper::image('orderby_asc.gif')?></a><a href="<?php echo  $column->orderby_desc_url?>"><?php echo rpd_html_helper::image('orderby_desc.gif')?></a>
                </td>
              </tr>
            </table>
          </td>
<?php elseif ($column->column_type == "clean"):?>
          <td <?php echo $column->attributes?>><?php echo $column->label?></td>
<?php elseif (in_array($column->column_type, array("normal"))):?>
          <td class="table_header" <?php echo $column->attributes?>><?php echo $column->label?></td>
<?php endif;?>
<?php endforeach;//table-header?>
        </tr>
<?php if (count($rows)>0)://table-rows?>
  <?php $rowcount=0;?>
<?php foreach ($rows as $row):?>
  <?php $rowcount++;?>
        <tr <?php if($rowcount % 2){ echo 'class="odd"';}else{ echo 'class="even"';} ?>>
<?php foreach ($row as $cell):?>
<?php if ($cell['type'] == "detail" OR $cell['link']!=""):?>
          <td <?php echo $cell['attributes']?> class="table_row"><a href="<?php echo $cell['link']?>"><?php if($cell['img']!=""){ echo rpd_html_helper::image($cell['img'], array('style'=>'vertical-align:middle')); }?><?php echo $cell['value']?></a></td>
<?php elseif ($cell['type'] == "clean"):?>
          <td <?php echo $cell['attributes']?>><?php echo $cell['value']?></td>
<?php elseif ($cell['check'] != ""):?>
          <td <?php echo $cell['attributes']?> class="table_row"><?php echo $cell['check']?> <?php echo $cell['value']?> </td>
<?php else:?>
          <td <?php echo $cell['attributes']?> class="table_row"><?php echo $cell['value']?>&nbsp;</td>
<?php endif;?>
<?php endforeach;?>
        </tr>
<?php endforeach;?>
<?php endif;//table-rows?>
      </table>
      </div>
      <div class="pagination">
      <?php echo $pagination;?>
      </div>
      <div class="dg_footer">
        <div>
          <div style="float:left"><?php echo $container["BL"]?></div>
          <div style="float:right"><?php echo $container["BR"]?></div>
        </div><div style="clear:both;"></div>
      </div>

    </td>
  </tr>
</table>
<?php echo $hidden;?>
<?php echo $form_end?>
</div>
<!-- datagrid end //-->
