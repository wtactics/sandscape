package org.wtactics.sandscape.client;

import com.google.gwt.cell.client.TextCell;
import com.google.gwt.core.client.EntryPoint;
import com.google.gwt.user.client.ui.RootPanel;
import com.google.gwt.user.cellview.client.CellList;
import com.google.gwt.user.client.ui.HTML;
import com.google.gwt.user.client.ui.SplitLayoutPanel;
import java.util.Arrays;
import java.util.List;

public class LobbyEntryPoint implements EntryPoint {

    private static final List<String> DEMO = Arrays.asList("USer 1", "User 2",
            "User 3", "User 4", "User 5");

    public LobbyEntryPoint() {
    }

    @Override
    public void onModuleLoad() {
        RootPanel root = RootPanel.get("lobby");

        TextCell cell = new TextCell();
        CellList<String> list = new CellList<String>(cell);
        list.setRowCount(DEMO.size(), true);
        list.setRowData(0, DEMO);

        SplitLayoutPanel sp = new SplitLayoutPanel();
        sp.addWest(list, 128);

        sp.addNorth(new HTML("Central area"), 300);
        sp.addEast(new HTML(""), 128);
        
        root.add(sp);
    }
}
