<?php
/*
 * Controller.php
 * 
 * This file is part of SandScape.
 * 
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 */
?><?php
/* $this->menu=array(
  array('label'=>'List Card', 'url'=>array('index')),
  array('label'=>'Create Card', 'url'=>array('create')),
  array('label'=>'Update Card', 'url'=>array('update', 'id'=>$model->cardId)),
  array('label'=>'Delete Card', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cardId),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage Card', 'url'=>array('admin')),
  ); */
?>

<h1>View Card #<?php echo $model->cardId; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'cardId',
        'faction',
        'type',
        'subtype',
        'cost',
        'threshold',
        'attack',
        'defense',
        'rules',
        'author',
        'revision',
        'cardscapeId',
        'imageId',
        'private',
        'active',
    ),
));
?>
