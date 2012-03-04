<div id="counter-dlg">
    <h2>Add Card Counter</h2>
    <p>
        <?php
        echo CHtml::label('Name', 'counter-name', array('class' => 'standard')),
        CHtml::textField('counter-name', '', array('size' => 16, 'class' => 'text'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Start', 'counter-value', array('class' => 'standard')),
        CHtml::textField('counter-value', 0, array('size' => 4, 'class' => 'text'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Step', 'counter-step', array('class' => 'standard')),
        CHtml::textField('counter-step', 1, array('size' => 4, 'class' => 'text'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Color', 'counter-class', array('class' => 'standard')),
        CHtml::dropDownList('counter-class', null, array(
            'cl-default' => 'cl-default',
            'cl-redish' => 'cl-redish',
            'cl-chrome' => 'cl-chrome',
            'cl-blueish' => 'cl-blueish'
        ));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::button('Add', array(
            'onclick' => 'addCounter();',
            'class' => 'simplemodal-close button'
        )),
        CHtml::link('Cancel', 'javascript:;', array('class' => 'simplemodal-close'));
        ?>
    </p>
    <input type="hidden" id="counter-card-id" />
</div>