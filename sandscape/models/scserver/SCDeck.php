<?php

/* SCDeck.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * @since 1.0, Sudden Growth
 */
class SCDeck extends SCContainer {

    private $name;

    /**
     *
     * @param SCGame $game
     * @param string $name
     * @param SCCard[] $cards 
     * 
     * @since 1.0, Sudden Growth
     */
    public function __construct(SCGame $game, $name, $cards) {
        parent::__construct($game, false, false);
        $this->name = $name;

        foreach ($cards as $c)
            $this->push($c);
    }

    /**
     *
     * @return string
     * 
     * @since 1.0, Sudden Growth
     */
    public function getName() {
        return $this->name;
    }

}