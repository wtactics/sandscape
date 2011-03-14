package org.wtactics.sandscape.client.model;

import com.google.gwt.core.client.JavaScriptObject;

public class Content extends JavaScriptObject {

    protected Content() {
    }

    public final native String getContent() /*-{ return this.content; }-*/;
}
