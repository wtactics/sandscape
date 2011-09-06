<div id="left">
    <h2><?php echo $this->getTranslatedString('STAY_PLUGINS_TITLE_LIST'); ?></h2>
    <?php $this->includeTemplateFile('_messages'); ?>
    <ul>
        <?php foreach ($this->plugins as $plugin) { ?>
            <li>
                <span><?php echo $plugin ?></span>
                <span style="float: right">
                    <?php
                    if (Plugin::isActive($plugin)) {
                        if (($instance = Plugin::plugin($plugin)) instanceof IPluginConfigurable) {
                            ?> 
                            <a href="<?php echo $this->createURL(strtolower($instance::configController())); ?>"><img src="<?php echo $this->getAssetLink('images/icons/plugin_edit.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PLUGINS_CONFIGURE_ICON_TITLE', array($plugin)); ?>" title="<?php echo $this->getTranslatedString('STAY_PLUGINS_CONFIGURE_ICON_TITLE', array($plugin)); ?>" /></a>
                        <?php } ?> 
                        <a href="<?php echo $this->createURL('plugins/disable'), '/', $plugin; ?>"><img src="<?php echo $this->getAssetLink('images/icons/plugin.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PLUGINS_DEACTIVATE_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_PLUGINS_DEACTIVATE_ICON_TITLE'); ?>" /></a> 
                    <?php } else { ?> 
                        <a href="#" onclick="
                                    $.ajax({
                                        type: 'GET',
                                        url: '<?php echo $this->createURL('plugins/enable'), '/', $plugin; ?>',
                                        success: function (data) { 
                                            if (data == 'success') location.reload(true); 
                                            else location.href='<?php echo $this->createURL('plugins/activationError'), '/', $plugin; ?>';
                                        }
                                    });
                           ">
                            <img src="<?php echo $this->getAssetLink('images/icons/plugin_disabled.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PLUGINS_ACTIVATE_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_PLUGINS_ACTIVATE_ICON_TITLE'); ?>" />
                        </a> 
                    <?php } ?>
                    <a href="<?php echo $this->createURL('plugins/uninstall'), '/', $plugin ?>"><img src="<?php echo $this->getAssetLink('images/icons/plugin_delete.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PLUGINS_UNINSTALL_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_PLUGINS_UNINSTALL_ICON_TITLE'); ?>" /></a>
                </span>
            </li>
        <?php } ?>
    </ul>
</div>

<div id="right">
    <div class="box">
        <ul id="tools">
            <li class="ui-corner-all">
                <form action="<? echo $this->createURL('plugins/install') ?>" method="post" enctype="multipart/form-data" >
                    <input type="file" name="plugin" style="width: 17em"/>
                    <button type="submit" style="width: 16px; height: 16px; float: right;margin-right: 0.5em;" title="<?php echo $this->getTranslatedString('STAY_PLUGINS_UPLOAD_ICON_TITLE'); ?>"><img src="<?php echo $this->getAssetLink('images/icons/plugin_add.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PLUGINS_UPLOAD_ICON_TITLE'); ?>" /></button>
                </form>
                <?php echo base64_decode('PCEtLQogICAgTXkgcGx1ZyBpbiBiYWJ5CiAgICBDcnVjaWZpZXMgbXkgZW5lbWllcwogICAgV2hlbiBJJ20gdGlyZWQgb2YgZ2l2aW5nCiAgICBNeSBwbHVnIGluIGJhYnkKICAgIEluIHVuYnJva2VuIHZpcmdpbiByZWFsaXRpZXMKICAgIElzIHRpcmVkIG9mIGxpdmluZwotLT4K'); ?>
            </li>
        </ul>
    </div>
</div>
