<?php

class SCGrid extends SCContainer {

    private $cells;
    private $cellList;
    private $rows;
    private $columns;

    public function __construct(SCGame $game, $rows, $columns) {
        parent::__construct($game, false, false);

        $this->cells = array();
        $this->cellList = array();
        $this->rows = $rows;
        $this->columns = $columns;

        for ($i = 0; $i < $rows; ++$i) {
            for ($j = 0; $j < $columns; ++$j) {
                $this->cells[$i][$j] = $this->cellList[] = $c = new SCContainer($game, false, true);
                $c->setId("{$this->getId()}_{$i}_{$j}");
            }
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

}