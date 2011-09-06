<?php

$this->registerScript('!js/jquery-ui-1.8.13.min.js', 'ui');
$this->registerScript('!js/jquery-1.5.1.min.js', 'ui');
$this->registerStyle('!css/jqueryui-redmond/jquery-ui-1.8.13.css', 'ui');
$this->registerStyle('login/css/style.css');

$this->includeTemplateFile('login/header-start');

echo $this->getStyleSection();
echo $this->getScriptSection();
echo $this->getInitScriptSection();

$this->includeTemplateFile('login/header-stop');

echo $this->getContentSection();

$this->includeTemplateFile('login/footer');