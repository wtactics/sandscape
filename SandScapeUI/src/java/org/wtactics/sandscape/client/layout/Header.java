/*
 * Header.java
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

import com.google.gwt.core.client.GWT;
import com.google.gwt.user.client.ui.Anchor;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.FlowPanel;
import com.google.gwt.user.client.ui.Image;
import org.wtactics.sandscape.client.resources.ImageResources;

/**
 * Header component. This is a reusable <em>Composite</em> that shows the header
 * section of general pages. It is used in every page except the game page.
 * 
 * The header section has a logo and a menu, both made with a <em>FlowPanel</em>
 * and added to a root <em>FlowPanel</em> that is used to initialize the widget.
 * 
 * @see Footer
 * @see Page
 * @since 1.0
 */
public class Header extends Composite {

    public Header() {
        ImageResources resources = GWT.create(ImageResources.class);

        FlowPanel logo = new FlowPanel();
        logo.add(new Image(resources.logo()));

        FlowPanel links = new FlowPanel();
        Anchor a = new Anchor("Home");
        links.add(a);
        
        a = new Anchor("Lobby");
        links.add(a);
        
        a = new Anchor("Stats");
        links.add(a);

        FlowPanel root = new FlowPanel();
        root.add(logo);
        root.add(links);

        root.addStyleName("header");
        
        
        initWidget(root);
        
    }
}
//TODO: implement
