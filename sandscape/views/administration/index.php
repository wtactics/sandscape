<?php
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.bubblepopup.v2.3.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile('_resources/css/jquery.bubblepopup.v2.3.1.css');

$js = <<<JS
$('.helpicon').CreateBubblePopup({
    position: 'right',
    align: 'center',
    tail: {
        align: 'center'
    },
    themeName: 'all-black',
    themePath: '_resources/images/jqBubblePopup',
    alwaysVisible: false,
    closingDelay: 100
});

$('#fixdecknr-help').SetBubblePopupInnerHtml('{$settings['fixdecknr']->description}');
$('#deckspergame-help').SetBubblePopupInnerHtml('{$settings['deckspergame']->description}');
$('#useanydice-help').SetBubblePopupInnerHtml('{$settings['useanydice']->description}');
JS;

Yii::app()->clientScript->registerScript('bublesinit', $js);

$this->title = 'Sandscape Administration';
?>
<div class="span-22 last">
    <h2>SandScape Administration</h2>
    <?php
    $this->widget('CTabView', array(
        'tabs' => array(
            'tab1' => array(
                'title' => 'Stats',
                'view' => '_stats',
            ),
            'tab2' => array(
                'title' => 'Settings',
                'view' => '_settings',
                'data' => array('settings' => $settings)
            ),
            'tab3' => array(
                'title' => 'Tools',
                'view' => '_tools'
            ),
            'tab4' => array(
                'title' => 'Word Filter',
                'view' => '_wordfilter',
                'data' => array('words' => $settings['wordfilter']->value)
            )
        ),
        'cssFile' => '_resources/css/tabs.css'
    ));
    ?>
</div>
