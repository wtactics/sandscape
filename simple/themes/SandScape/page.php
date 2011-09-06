<div id="content">
    <div id="left">
        <h2><?php echo $this->page->getTitle(); ?></h2>
        <?php
        echo $this->renderPlugins('pageContentStart');

        echo $this->page->getText();

        echo $this->renderPlugins('pageContentStop');
        ?>
    </div>
    <div id="right">
        <?php echo $this->getSecundaryMenuSection('secnav'); ?>
        <div class="box">
            <h2 style="margin-top:17px">Recent Entries</h2>
            <ul>
                <li><a href="#">Recent Entries1</a> <i>01 Des 06</i></li>
                <li><a href="#">Recent Entries2</a> <i>01 Des 06</i></li>
                <li><a href="#">Recent Entries3</a> <i>01 Des 06</i></li>
                <li><a href="#">Recent Entries4</a> <i>01 Des 06</i></li>
                <li><a href="#">Recent Entries5</a> <i>01 Des 06</i></li>
            </ul>
        </div>
    </div>                