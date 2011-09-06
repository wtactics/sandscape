<?php
$url = $this->createURL('dashboard/updatewidget');

$this->registerStyle('css/dashboard/dashboard.css', 'ui');
$this->registerInitScript("
    $('.column').sortable({
        connectWith: '.column',
        handle: 'h2',
        cursor: 'move',
        placeholder: 'placeholder',
        forcePlaceholderSize: true,
        opacity: 0.4,
        stop: function(event, ui) {
            $(ui.item).find('h2').click();
            var sortorder = '';
            $('.column').each(function(){
                sortorder += $(this).attr('id') + '=' + $(this).sortable('toArray').toString() + '&';
            });
            $.post('{$url}', sortorder);
        }
    }).disableSelection();
        ");
?>
<div id="left">
    <h2><?php echo $this->getTranslatedString('STAY_DASHBOARD_TILE'); ?></h2>
    <?php $this->includeTemplateFile('_messages'); ?>

    <?php if (count($this->widgets)) {
        $widgets = $this->widgets;
        ?>
        <div class="column" id="column1">
            <?php
            foreach ($this->column1 as $config) {
                foreach ($widgets as $key => $plugin) {
                    if ($config == $plugin->instance->getWidgetId()) {
                        unset($widgets[$key]);
                        ?>
                        <div class="dragbox" id="<?php echo $plugin->instance->getWidgetId(); ?>" >
                            <h2><?php echo $plugin->instance->getWidgetTitle($this); ?></h2>
                            <div class="dragbox-content" >
                                <?php echo $plugin->instance->getWidgetContent($this); ?>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
        <div class="column" id="column2" >
            <?php
            foreach ($this->column2 as $config) {
                foreach ($widgets as $key => $plugin) {
                    if ($config == $plugin->instance->getWidgetId()) {
                        ?>
                        <div class="dragbox" id="<?php echo $plugin->instance->getWidgetId(); ?>" >
                            <h2><?php echo $plugin->instance->getWidgetTitle($this); ?></h2>
                            <div class="dragbox-content" >
                                <?php echo $plugin->instance->getWidgetContent($this); ?>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
        <div style="clear:both;"></div>

    <?php } else { ?>
        <div>
            <?php echo $this->getTranslatedString('STAY_DASHBOARD_NO_WIDGETS'); ?>
        </div>
    <?php } ?>
    <!-- END -->
</div>

<div id="right">
    <div class="box">
        <ul id="tools">
            <li class="ui-corner-all"><a href="<?php echo $this->createURL('pages/edit'); ?>"><?php echo $this->getTranslatedString('STAY_PAGE_NEW_PAGE'); ?></a></li>
        </ul>
    </div>
</div>