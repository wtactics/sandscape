<?php

$this->registerScript('!js/jquery-ui-1.8.13.min.js', 'ui');
$this->registerScript('!js/jquery-1.5.1.min.js', 'ui');
$this->registerStyle('!css/style.css');
$this->registerStyle('!css/jqueryui-redmond/jquery-ui-1.8.13.css', 'ui');

$this->includeTemplateFile('header-start');

echo $this->renderPlugins('headerStarted');

echo $this->getStyleSection();
echo $this->getScriptSection();
echo $this->getInitScriptSection();

echo $this->renderPlugins('headerFinishing');

$this->includeTemplateFile('header-stop');

echo $this->renderPlugins('headerStopped');

echo $this->renderPlugins('contentStarting');

echo $this->getContentSection();

echo $this->renderPlugins('contentStopped');

$this->includeTemplateFile('footer-start');

echo $this->renderPlugins('footerStarted');

echo $this->renderPlugins('cleanup');

$this->includeTemplateFile('footer-stop');
