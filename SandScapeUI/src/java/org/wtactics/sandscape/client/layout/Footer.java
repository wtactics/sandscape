/*
 * Footer.java
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

import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.FlowPanel;

/**
 * Footer component. This class creates the footer component to be used in the
 * footer section of various pages. Only the game page ignores this component.
 * 
 * @see Header
 * @see Page
 * @since 1.0
 */
public class Footer extends Composite {

    public Footer() {
        FlowPanel root = new FlowPanel();

        initWidget(root);
    }
}
//TODO: implement
