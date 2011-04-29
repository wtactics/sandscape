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
	'Messages'=>array('index'),
	$model->messageId=>array('view','id'=>$model->messageId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Message', 'url'=>array('index')),
	array('label'=>'Create Message', 'url'=>array('create')),
	array('label'=>'View Message', 'url'=>array('view', 'id'=>$model->messageId)),
	array('label'=>'Manage Message', 'url'=>array('admin')),
);
?>

<h1>Update Message <?php echo $model->messageId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>