<div id="left">
    <h2><?php echo ($this->page->getName() ? $this->getTranslatedString('STAY_PAGE_TITLE_EDIT') : $this->getTranslatedString('STAY_PAGE_TITLE_CREATE')); ?></h2>
    <?php $this->includeTemplateFile('_messages'); ?>
    <form action="<?php echo $this->createURL('pages/edit'), ($this->page->getName() ? '/' . $this->page->getName() : ''); ?>" method="post">
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_PAGE_GENERAL_SECTION'); ?></legend>
            <p>
                <label for="title"><?php echo $this->getTranslatedString('STAY_PAGE_TITLE'); ?></label>
                <?php echo new TextField($this->page, 'title'); ?>
            </p>
            <p>
                <label for="name"><?php echo $this->getTranslatedString('STAY_PAGE_NAME'); ?></label>
                <?php echo new TextField($this->page, 'name'); ?>
            </p>
            <p>
                <label for="parent"><?php echo $this->getTranslatedString('STAY_PAGE_PARENT'); ?></label>
                <?php
                if (count($this->parentPages)) {
                    echo new ComboBox($this->page, 'parent', $this->parentPages);
                } else {
                    echo $this->getTranslatedString('STAY_PAGE_NOPARENT');
                }
                ?>
            </p>
            <p>
                <label for="template"><?php echo $this->getTranslatedString('STAY_PAGE_TEMPLATE_SECTION'); ?></label>
                <?php echo new ComboBox($this->page, 'template', $this->pageTemplates); ?>
            </p>
            <p>
                <label for="private"><?php echo $this->getTranslatedString('STAY_PAGE_PUBLISHED'); ?></label>
                <?php echo new CheckBox($this->page, 'published'); ?>
            </p>
        </fieldset>
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_PAGE_META_SECTION'); ?></legend>
            <p>
                <label for="metakeywords"><?php echo $this->getTranslatedString('STAY_PAGE_KEYWORDS'); ?></label>
                <?php echo new TextField($this->page, 'metaKeywords'); ?>
            </p>
            <p>
                <label for="metadescription"><?php echo $this->getTranslatedString('STAY_PAGE_DESCRIPTION'); ?></label>
                <?php echo new TextField($this->page, 'metaDescription'); ?>
            </p>
        </fieldset>
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_PAGE_MENU_SECTION'); ?></legend>
            <p>
                <label><?php echo $this->getTranslatedString('STAY_PAGE_INMENU'); ?></label>
                <?php echo new CheckBox($this->page, 'inMenu'); ?>
            </p>
            <p>
                <label for="menutitle"><?php echo $this->getTranslatedString('STAY_PAGE_MENU_TITLE'); ?></label>
                <?php echo new TextField($this->page, 'menuTitle'); ?>
            </p>
            <p>
                <label for="menuorder"><?php echo $this->getTranslatedString('STAY_PAGE_MENU_ORDER'); ?></label>
                <?php echo new TextField($this->page, 'menuOrder'); ?>
            </p>
        </fieldset>
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_PAGE_TEXT'); ?></legend>
            <p>
                <?php
                $title = $this->getTranslatedString('STAY_PAGE_FILE_BROWSER_TITLE');
                $connector = $this->createURL('connector/get');
                echo new TextEditor($this, $this->page, 'text',
                        array('class' => 'big'),
                        array(
                            'styleWithCSS' => 'false',
                            'height' => '400',
                            'toolbar' => "'maxi'",
                            'fmAllow' => 'true'
                        ),
                        array(
                            'url' => "'{$connector}'",
                            'dialog' => "{ width : 900, modal : true, title : '{$title}' }",
                            'closeOnEditorCallback' => 'true'
                        )
                );
                ?>
            </p>
        </fieldset>
        <p>
            <?php echo new SubmitButton($this->getTranslatedString('STAY_GENERAL_SAVE')); ?>
            &nbsp;&nbsp;
            <a href="<?php echo $this->createURL('pages'); ?>"><?php echo $this->getTranslatedString('STAY_GENERAL_CANCEL'); ?></a>
        </p>

        <input type="hidden" name="Page" id="Page" value="Page" />
    </form>
</div>
<div id="right">
    <div class="box">
        <ul id="tools">
            <li class="ui-corner-all"><a href="<?php echo $this->createURL('pages/edit'); ?>"><?php echo $this->getTranslatedString('STAY_PAGE_NEW_PAGE'); ?></a></li>
            <?php if ($this->page->getName()) { ?>
                <li class="ui-corner-all"><a href="<?php echo $this->createURL('pages/delete'), '/', $this->page->getName(); ?>"><?php echo $this->getTranslatedString('STAY_PAGE_DELETE_THIS'); ?></a></li>
                <?php
            }
            if ($this->revisions) {
                $this->registerScript('js/fancybox/jquery.fancybox-1.3.4.pack.js', 'ui');
                $this->registerStyle('css/fancybox/jquery.fancybox-1.3.4.css', 'ui');
                ?>
                <li class="ui-corner-all"><a href="javascript:;" onclick="
                        $.fancybox([
                                             <?php foreach ($this->revisions as $rev) { ?>
                                                             {
                                                                 'href'	: '<?php echo $this->createURL('pages/preview/' . $this->page->getName() . '/' . $rev); ?>',
                                                                 'title'	: '<?php echo date($this->getShortDateFormat() . ' ' . $this->getTimeFormat(), $rev); ?>'
                                                             },
                                             <?php } ?>], {'type': 'ajax'});"><?php echo $this->getTranslatedString('STAY_PAGE_REVISIONS'); ?></a>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>