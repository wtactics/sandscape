<?php
$this->registerScript('js/textsizer.js');
$this->registerScript('js/rel.js');
$this->registerStyle('css/style.css');

$this->includeTemplateFile('header-start');

echo $this->renderPlugins('siteHeaderStarted');

echo $this->getStyleSection();
echo $this->getScriptSection();
echo $this->getInitScriptSection();

echo $this->renderPlugins('siteHeaderFinishing');

$this->includeTemplateFile('header-stop');

echo $this->renderPlugins('siteHeaderStopped');

echo $this->renderPlugins('siteContentStarting');

echo $this->getContentSection();

echo $this->renderPlugins('siteContentStopped');

$this->includeTemplateFile('footer-start');

echo $this->renderPlugins('siteFooterStarted');

echo $this->renderPlugins('siteCleanup');

$this->includeTemplateFile('footer-stop');