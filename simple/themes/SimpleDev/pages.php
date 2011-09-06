<?php $this->registerScript('js/admin.js'); ?>
<?php //TODO: $this->registerInitScript('$(".sortable").sortable();$(".sortable").disableSelection();') ?>
<div id="left">
    <h2><?php echo $this->getTranslatedString('STAY_PAGE_TITLE_LIST'); ?></h2>
    <?php $this->includeTemplateFile('_messages'); ?>
    <form action="<?php echo $this->createURL('pages/deleteselected'); ?>" method="post" id="selection">
        <ul>
            <?php
            foreach ($this->pages as $page) {
                ?>
                <li>
                    <span style="margin-right: 1em"><?php echo new CheckBox(null, 'select[]', array('value' => $page->getName())); ?></span>
                    <span style=""><a href="<?php echo $this->createURL('pages/edit/' . $page->getName()); ?>"><?php echo ($page->getInMenu() ? '<strong>' . $page->getTitle() . '</strong>' : $page->getTitle()); ?></a></span>
                    <span style="float: right;">
                        <?php if ($page->getPublished()) { ?>
                            <img src="<?php echo $this->getAssetLink('images/icons/tick.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PAGE_PUBLISHED_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_PAGE_PUBLISHED_ICON_TITLE'); ?>" />&nbsp;&nbsp;
                        <?php } ?>
                        <a href="<?php echo $this->createURL('pages/edit'), '/', $page->getName(); ?>"><img src="<?php echo $this->getAssetLink('images/icons/pencil.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PAGE_EDIT_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_PAGE_EDIT_ICON_TITLE'); ?>" /></a>
                        <a href="<?php echo $this->createURL('pages/delete'), '/', $page->getName(); ?>"><img src="<?php echo $this->getAssetLink('images/icons/bin.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PAGE_DELETE_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_PAGE_DELETE_ICON_TITLE'); ?>" /></a>
                    </span>
                    <?php if ($page->hasChildren()) { ?>
                        <ul style="margin-left: 2.5em;" class="sortable">
                            <?php foreach ($page->getChildren() as $child) { ?>
                                <li>
                                    <span style="margin-right: 5px"><?php echo new CheckBox(null, 'select[]', array('value' => $child->getName())); ?></span>
                                    <span><a href="<?php echo $this->createURL('pages/edit/' . $child->getName()); ?>"><?php echo ($child->getInMenu() ? '<strong>' . $child->getTitle() . '</strong>' : $child->getTitle()); ?></a></span>
                                    <span style="float: right;">
                                        <?php if ($page->getPublished()) { ?>
                                            <img src="<?php echo $this->getAssetLink('images/icons/tick.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PAGE_PUBLISHED_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_PAGE_PUBLISHED_ICON_TITLE'); ?>" />&nbsp;&nbsp;
                                        <?php } ?>
                                        <a href="<?php echo $this->createURL('pages/edit'), '/', $child->getName(); ?>"><img src="<?php echo $this->getAssetLink('images/icons/pencil.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PAGE_EDIT_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_PAGE_EDIT_ICON_TITLE'); ?>" /></a>
                                        <a href="<?php echo $this->createURL('pages/delete'), '/', $child->getName(); ?>"><img src="<?php echo $this->getAssetLink('images/icons/bin.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_PAGE_DELETE_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_PAGE_DELETE_ICON_TITLE'); ?>" /></a>
                                    </span>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </form>
</div>
<div id="right">
    <div class="box">
        <ul id="tools">
            <li class="ui-corner-all"><a href="<?php echo $this->createURL('pages/edit'); ?>"><?php echo $this->getTranslatedString('STAY_PAGE_NEW_PAGE'); ?></a></li>
            <li class="ui-corner-all"><a href="javascript:deleteSelected('<?php echo $this->getTranslatedString('STAY_PAGE_DELETE_SELECTED_QUESTION') ?>');"><?php echo $this->getTranslatedString('STAY_PAGE_DELETE_SELECTED'); ?></a></li>
            <li class="ui-corner-all">
                <form action="<?php echo $this->createURL('pages'); ?>" method="post" id="filter">
                    <?php echo $this->getTranslatedString('STAY_PAGE_FILTER'); ?>:&nbsp;
                    <?php
                    echo new ComboBox(null, 'filter', $this->filterOptions, $this->filter,
                            array(
                                'style' => 'width: 10em;',
                                'onchange' => "$('#filter').submit();"
                    ));
                    ?>
                </form>
            </li>
        </ul>
    </div>
</div>