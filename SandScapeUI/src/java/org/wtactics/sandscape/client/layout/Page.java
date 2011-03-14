/*
 * Page.java
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

/**
 * Abstract class grouping every other class that intents to represent a layout.
 * Subclasses must implement the <em>doLayout</em> method and attaching their 
 * layout implementation to the <em>RootLayoutPanel</em>.
 * 
 * Note that pages are not UI elements, they are managers. There is no API to 
 * connect a page to GWT UI elements, meaning you can't add a page to a panel, 
 * a layout or any widget.
 * 
 * @since 1.0
 */
public abstract class Page {

    public abstract void doLayout();
}
