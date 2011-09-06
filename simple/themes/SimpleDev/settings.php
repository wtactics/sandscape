<?php
$yesNoOptions = array(
    array('0', $this->getTranslatedString('STAY_GENERAL_NO')),
    array('1', $this->getTranslatedString('STAY_GENERAL_YES'))
);

$text = $this->getTranslatedString('STAY_SETTINGS_HIDEINDEX_HELP');

$this->registerStyle('css/bubblepopup/jquery.bubblepopup.v2.3.1.css', 'ui');
$this->registerScript('js/bubblepopup/jquery.bubblepopup.v2.3.1.min.js', 'ui');

$themePath = $this->getAssetLink('images', 'ui');

$this->registerInitScript("
$(document).ready(function() {
    $('#bubble1').CreateBubblePopup({
        position: 'right',
        align: 'middle',
        tail: {
            align: 'middle'
        },
        themeName: 'all-azure',
        themePath: '{$themePath}',
        alwaysVisible: false,
        closingDelay: 200
    });
    
    $('#bubble1').SetBubblePopupInnerHtml('{$text}');
});
");

$this->registerScript('js/fancybox/jquery.fancybox-1.3.4.pack.js', 'ui');
$this->registerStyle('css/fancybox/jquery.fancybox-1.3.4.css', 'ui');

$processedThemes = array();
$fboptions = array();
foreach ($this->themes as $theme) {
    $url = $this->createURL('settings/previewTheme/' . $theme->getFolder());
    $themeTitle = $theme->getName();
    $fboptions[] = "{ 'href': '{$url}', 'title': '{$themeTitle}' } ,";

    $processedThemes[] = array($theme->getFolder(), $theme->getName());
}

$fboptions = implode($fboptions);
?>

<div id="left">
    <h2><?php echo $this->getTranslatedString('STAY_SETTINGS_TITLE'); ?></h2>
    <?php $this->includeTemplateFile('_messages'); ?>
    <form action="<?php echo $this->createURL('settings'); ?>" method="post">
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_SETTINGS_SITE_SECTION'); ?></legend>
            <p>
                <label for="name"><?php echo $this->getTranslatedString('STAY_SETTINGS_SITE_NAME'); ?></label>
                <?php echo new TextField(null, 'name', array('value' => $this->settings->site->name)); ?>
            </p>
            <p>
                <label for="sitheme"><?php echo $this->getTranslatedString('STAY_SETTINGS_SITE_THEME'); ?></label>
                <?php echo new ComboBox(null, 'sitheme', $processedThemes, $this->settings->site->theme); ?>
                <img src="<?php echo $this->getAssetLink('images/icons/application_view_tile.png', 'ui'); ?>" onclick="$.fancybox([ <?php echo $fboptions; ?> ], {'type': 'ajax', 'autoDimensions': true, 'autoScale': true});" />
            </p>
            <p>
                <label for="home"><?php echo $this->getTranslatedString('STAY_SETTINGS_SITE_HOME'); ?></label>
                <?php echo new ComboBox(null, 'home', $this->toppages, $this->settings->site->home); ?>
            </p>
            <p>
                <label for="hideindex"><?php echo $this->getTranslatedString('STAY_SETTINGS_SITE_HIDE_INDEX'); ?></label>
                <?php echo new ComboBox(null, 'hideindex', $yesNoOptions, $this->settings->site->hideindex); ?>
                <img src="<?php echo $this->getAssetLink('images/icons/information.png', 'ui'); ?>" id="bubble1" />
        </fieldset>
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_SETTINGS_SYSTEM_SECTION'); ?></legend>
            <p>
                <label for="path"><?php echo $this->getTranslatedString('STAY_SETTINGS_SYSTEM_PATH'); ?></label>
                <?php echo new TextField(null, 'path', array('value' => $this->settings->system->path)); ?>
            </p>
            <p>
                <label for="email"><?php echo $this->getTranslatedString('STAY_GENERAL_EMAIL'); ?></label>
                <?php echo new TextField(null, 'email', array('value' => $this->settings->system->email)); ?>
            </p>
            <p>
                <label for="systheme"><?php echo $this->getTranslatedString('STAY_SETTINGS_SYSTEM_THEME'); ?></label>
                <?php echo new ComboBox(null, 'systheme', $this->devthemes, $this->settings->system->theme); ?>
            </p>
            <p>
                <label for="pingengines"><?php echo $this->getTranslatedString('STAY_SETTINGS_SYSTEM_PINGENGINES'); ?></label>
                <?php echo new ComboBox(null, 'pingengines', $yesNoOptions, $this->settings->system->pingengines); ?>
            </p>
        </fieldset>
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_SETTINGS_LOCALE_SECTION'); ?></legend>
            <p>
                <label for="language"><?php echo $this->getTranslatedString('STAY_SETTINGS_LOCALE_LANGUAGE'); ?></label>
                <?php echo new ComboBox(null, 'language', $this->languages, $this->settings->system->locale->language); ?>
            </p>
            <p>
                <label for="shortdateformat"><?php echo $this->getTranslatedString('STAY_SETTINGS_LOCALE_SHORTDATE'); ?></label>
                <?php echo new TextField(null, 'shortdateformat', array('value' => $this->settings->system->locale->shortdateformat)); ?>
            </p>
            <p>
                <label for="longdateformat"><?php echo $this->getTranslatedString('STAY_SETTINGS_LOCALE_LONGDATE'); ?></label>
                <?php echo new TextField(null, 'longdateformat', array('value' => $this->settings->system->locale->longdateformat)); ?>
            </p>
            <p>
                <label for="timeformat"><?php echo $this->getTranslatedString('STAY_SETTINGS_LOCALE_TIME'); ?></label>
                <?php echo new TextField(null, 'timeformat', array('value' => $this->settings->system->locale->timeformat)); ?>
            </p>
        </fieldset>     
        <p>
            <?php echo new SubmitButton($this->getTranslatedString('STAY_GENERAL_SAVE'), 'submit2'); ?>
            &nbsp;&nbsp;
            <a href="<?php echo $this->createURL('dashboard'); ?>"><?php echo $this->getTranslatedString('STAY_GENERAL_CANCEL'); ?></a>
        </p>
        <input type="hidden" name="Settings" id="Settings" value="Settings" />
    </form>
</div>

<div id="right">
    <div class="box">
        <ul id="tools">
            <li class="ui-corner-all"><a href="<?php echo $this->createURL('settings/backup'); ?>"><?php echo $this->getTranslatedString('STAY_SETTINGS_TOOLS_DOWNLOAD_BACKUP'); ?></a></li>
            <li class="ui-corner-all"><a href="<?php echo $this->createURL('settings/prune'); ?>"><?php echo $this->getTranslatedString('STAY_SETTINGS_TOOLS_PRUNE_BACKUPS'); ?></a></li>
            <li class="ui-corner-all">
                <form action="<? echo $this->createURL('settings/installtheme') ?>" method="post" enctype="multipart/form-data" >
                    <input type="file" name="themefile" style="width: 17em"/>
                    <button type="submit" style="width: 16px; height: 16px; float: right;margin-right: 0.5em;" title="<?php echo $this->getTranslatedString('STAY_SETTINGS_UPLOAD_THEME_ICON_TITLE'); ?>"><img src="<?php echo $this->getAssetLink('images/icons/application_get.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_SETTINGS_UPLOAD_THEME_ICON_TITLE'); ?>" /></button>
                </form>
                <?php echo base64_decode(<<<ENC64
PCEtLQ0KV2hlbiB5b3Ugd2FsayBhd2F5DQpZb3UgZG9uJ3QgaGVhciBtZSBzYXkgcGxlYXNlDQpPaCBiYWJ5LCBkb24ndCBnbw0K
U2ltcGxlIGFuZCBjbGVhbiBpcyB0aGUgd2F5IHRoYXQgeW91J3JlIG1ha2luZyBtZSBmZWVsIHRvbmlnaHQNCkl0J3MgaGFyZCB0
byBsZXQgaXQgZ28NCg0KWW91J3JlIGdpdmluZyBtZSB0b28gbWFueSB0aGluZ3MNCkxhdGVseSB5b3UncmUgYWxsIEkgbmVlZA0K
WW91IHNtaWxlZCBhdCBtZSBhbmQgc2FpZCwNCg0KRG9uJ3QgZ2V0IG1lIHdyb25nIEkgbG92ZSB5b3UNCkJ1dCBkb2VzIHRoYXQg
bWVhbiBJIGhhdmUgdG8gbWVldCB5b3VyIGZhdGhlcj8NCldoZW4gd2UgYXJlIG9sZGVyIHlvdSdsbCB1bmRlcnN0YW5kDQpXaGF0
IEkgbWVhbnQgd2hlbiBJIHNhaWQgIk5vLA0KSSBkb24ndCB0aGluayBsaWZlIGlzIHF1aXRlIHRoYXQgc2ltcGxlIg0KDQpXaGVu
IHlvdSB3YWxrIGF3YXkNCllvdSBkb24ndCBoZWFyIG1lIHNheSBwbGVhc2UNCk9oIGJhYnksIGRvbid0IGdvDQpTaW1wbGUgYW5k
IGNsZWFuIGlzIHRoZSB3YXkgdGhhdCB5b3UncmUgbWFraW5nIG1lIGZlZWwgdG9uaWdodA0KSXQncyBoYXJkIHRvIGxldCBpdCBn
bw0KDQpUaGUgZGFpbHkgdGhpbmdzDQp0aGF0IGtlZXAgdXMgYWxsIGJ1c3kNCmFsbCBjb25mdXNpbmcgbWUgdGhhdHMgd2hlbiB1
IGNhbWUgdG8gbWUgYW5kIHNhaWQsDQoNCldpc2ggaSBjb3VsZCBwcm92ZSBpIGxvdmUgeW91DQpidXQgZG9lcyB0aGF0IG1lYW4g
aSBoYXZlIHRvIHdhbGsgb24gd2F0ZXI/DQpXaGVuIHdlIGFyZSBvbGRlciB5b3UnbGwgdW5kZXJzdGFuZA0KSXQncyBlbm91Z2gg
d2hlbiBpIHNheSBzbywNCkFuZCBtYXliZSBzb21ldGhpbmdzIGFyZSB0aGF0IHNpbXBsZQ0KDQpXaGVuIHlvdSB3YWxrIGF3YXkN
CllvdSBkb24ndCBoZWFyIG1lIHNheSBwbGVhc2UNCk9oIGJhYnksIGRvbid0IGdvDQpTaW1wbGUgYW5kIGNsZWFuIGlzIHRoZSB3
YXkgdGhhdCB5b3UncmUgbWFraW5nIG1lIGZlZWwgdG9uaWdodA0KSXQncyBoYXJkIHRvIGxldCBpdCBnbw0KDQpIb2xkIG1lDQpX
aGF0ZXZlciBsaWVzIGJleW9uZCB0aGlzIG1vcm5pbmcNCklzIGEgbGl0dGxlIGxhdGVyIG9uDQpSZWdhcmRsZXNzIG9mIHdhcm5p
bmdzIHRoZSBmdXR1cmUgZG9lc24ndCBzY2FyZSBtZSBhdCBhbGwNCk5vdGhpbmcncyBsaWtlIGJlZm9yZQ0KDQpXaGVuIHlvdSB3
YWxrIGF3YXkNCllvdSBkb24ndCBoZWFyIG1lIHNheSBwbGVhc2UNCk9oIGJhYnksIGRvbid0IGdvDQpTaW1wbGUgYW5kIGNsZWFu
IGlzIHRoZSB3YXkgdGhhdCB5b3UncmUgbWFraW5nIG1lIGZlZWwgdG9uaWdodA0KSXQncyBoYXJkIHRvIGxldCBpdCBnbw0KDQpI
b2xkIG1lDQpXaGF0ZXZlciBsaWVzIGJleW9uZCB0aGlzIG1vcm5pbmcNCklzIGEgbGl0dGxlIGxhdGVyIG9uDQpSZWdhcmRsZXNz
IG9mIHdhcm5pbmdzIHRoZSBmdXR1cmUgZG9lc24ndCBzY2FyZSBtZSBhdCBhbGwNCk5vdGhpbmcncyBsaWtlIGJlZm9yZQ0KDQpI
b2xkIG1lDQpXaGF0ZXZlciBsaWVzIGJleW9uZCB0aGlzIG1vcm5pbmcNCklzIGEgbGl0dGxlIGxhdGVyIG9uDQpSZWdhcmRsZXNz
IG9mIHdhcm5pbmdzIHRoZSBmdXR1cmUgZG9lc24ndCBzY2FyZSBtZSBhdCBhbGwNCk5vdGhpbmcncyBsaWtlIGJlZm9yZQ0KLS0+
ENC64
                ); ?>
            </li>
        </ul>
    </div>
</div>





