<table border=1>
  <tr> 
<?php foreach ($columns as $column)://table-header?>
    <td <?php echo $column->attributes?> bgcolor=#cccccc><?php echo $column->label?></td>
<?php endforeach;//table-header?>
  </tr>
<?php if (count($rows)>0)://table-rows?>
  <?php $rowcount=0;?>
<?php foreach ($rows as $row):?>
<?php $rowcount++;?>
  <tr>
<?php foreach ($row as $cell):?>
    <td <?php echo $cell['attributes']?>><?php echo $cell['value']?></td>
<?php endforeach;?>
  </tr>
<?php endforeach;?>
<?php endif;//table-rows?>
</table>
