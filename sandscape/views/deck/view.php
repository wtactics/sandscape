<?php
/*
 * view.php
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

$this->breadcrumbs = array(
    'Decks' => array('index'),
    $model->deckId,
);

$this->menu = array(
    array('label' => 'List Deck', 'url' => array('index')),
    array('label' => 'Create Deck', 'url' => array('create')),
    array('label' => 'Update Deck', 'url' => array('update', 'id' => $model->deckId)),
    array('label' => 'Delete Deck', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->deckId), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Deck', 'url' => array('admin')),
);
?>

<h1>View Deck #<?php echo $model->deckId; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'deckId',
        'userId',
        'created',
        'active',
    ),
));
?>
