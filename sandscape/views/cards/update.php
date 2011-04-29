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
$this->breadcrumbs=array(
	'Cards'=>array('index'),
	$model->cardId=>array('view','id'=>$model->cardId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Card', 'url'=>array('index')),
	array('label'=>'Create Card', 'url'=>array('create')),
	array('label'=>'View Card', 'url'=>array('view', 'id'=>$model->cardId)),
	array('label'=>'Manage Card', 'url'=>array('admin')),
);
?>

<h1>Update Card <?php echo $model->cardId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>