/*
 * GamePage.java
 *
 * This file is part of SandScape, http://sourceforge.net/p/sandscape/.
 *
 * Copyright (C) 2011 jAutoInvoice
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
package org.wtactics.sandscape.client.layout;

import com.allen_sauer.gwt.dnd.client.PickupDragController;
import com.google.gwt.user.client.ui.Image;
import com.google.gwt.user.client.ui.RootLayoutPanel;
import com.google.gwt.user.client.ui.RootPanel;

/**
 * The game's page. The page where the game is played and that is the main 
 * view for SandScape.
 * 
 * @see Page
 * @since 1.0
 */
public class GamePage extends Page {

    @Override
    public void doLayout() {
        RootPanel.get().setPixelSize(1024, 790);

        PickupDragController controller = new PickupDragController(RootPanel.get(), true);

        Image img = new Image("http://localhost/spikes/card-images/DoubttheViolence.png");
        controller.makeDraggable(img);
        RootPanel.get().add(img, 40, 30);

    }
}
//TODO: implement
