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
?><div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('faction')); ?>:</b>
	<?php echo CHtml::encode($data->faction); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subtype')); ?>:</b>
	<?php echo CHtml::encode($data->subtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('threshold')); ?>:</b>
	<?php echo CHtml::encode($data->threshold); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attack')); ?>:</b>
	<?php echo CHtml::encode($data->attack); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('defense')); ?>:</b>
	<?php echo CHtml::encode($data->defense); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rules')); ?>:</b>
	<?php echo CHtml::encode($data->rules); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author')); ?>:</b>
	<?php echo CHtml::encode($data->author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('revision')); ?>:</b>
	<?php echo CHtml::encode($data->revision); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cardscapeId')); ?>:</b>
	<?php echo CHtml::encode($data->cardscapeId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imageId')); ?>:</b>
	<?php echo CHtml::encode($data->imageId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('private')); ?>:</b>
	<?php echo CHtml::encode($data->private); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />
</div>