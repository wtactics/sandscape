<?php

/*
 * WTSGrid.php
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

/**
 * @since 1.0
 * @author Pedro Serra
 */
class WTSGrid extends WTSContainer {

    private $cells;
    private $cellList;
    private $rows;
    private $columns;

    public function __construct($rows, $columns) {
        parent::__construct(false, false);

        $this->cells = array();
        $this->cellList = array();
        $this->rows = $rows;
        $this->columns = $columns;

        for ($i = 0; $i < $rows; ++$i)
            for ($j = 0; $j < $columns; ++$j) {
                $this->cells[$i][$j] = $this->cellList[] = $c = new WTSWTSGridCell(false, true);
                $c->setId("{$this->getId()}_{$i}_{$j}");
            }
    }

    public function getHTML() {
        $html = array();
        $html[] = '<table class="grid">';
        for ($i = 0; $i < $this->rows; ++$i) {
            $html[] = '<tr>';
            for ($j = 0; $j < $this->columns; ++$j) {
                $html[] = sprintf('<td id="%s"></td>', $this->cells[$i][$j]->getId());
            }
            $html[] = '</tr>';
        }
        $html[] = '</table>';
        return implode($html);
    }

    public function getReversedHTML() {
        $html = array();
        $html[] = '<table class="grid">';
        for ($i = $this->rows - 1; $i >= 0; --$i) {
            $html[] = '<tr>';
            for ($j = 0; $j < $this->columns; ++$j) {
                $html[] = sprintf('<td id="%s"></td>', $this->cells[$i][$j]->getId());
            }
            $html[] = '</tr>';
        }
        $html[] = '</table>';
        return implode($html);
    }

    public function getUpdate() {
        $output = parent::getUpdate();

        foreach ($this->cellList as $cell)
            $output = array_merge($output, $cell->getUpdate());

        return $output;
    }

    public function findCardContainer($id) {
        $result = parent::findCardContainer($id);
        if ($result)
            return $this;
        foreach ($this->cellList as $cell)
            if ($cell->findCardContainer($id))
                return $cell->findCardContainer($id);
        return null;
    }

    public function find($id) {
        foreach ($this->cellList as $cell) {
            $result = $cell->find($id);
            if ($result)
                return $result;
        }
        return parent::find($id);
    }

}

?>