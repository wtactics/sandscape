<?php

class HHtml extends TbHtml {

    /**
     * @param $action
     * @param string $method
     * @param array $htmlOptions
     * @return string
     */
    public static function loginForm($action, $method = 'post', $htmlOptions = array()) {
        if (isset($htmlOptions['visible']) && !$htmlOptions['visible']) {
            self::addCssClass('hide', $htmlOptions);
        }
        self::addCssClass('navbar-form', $htmlOptions);

        $output = '<div style="padding: 1em;">';
        $output .= self::beginFormTb(self::FORM_LAYOUT_INLINE, $action, $method, $htmlOptions);

        $output .= self::textField('LoginForm[email]', '', array(
                    'placeholder' => 'E-mail',
                    'size' => TbHtml::INPUT_SIZE_DEFAULT
        ));

        $output .= self::passwordField('LoginForm[password]', '', array(
                    'placeholder' => 'Password',
                    'size' => TbHtml::INPUT_SIZE_DEFAULT
        ));

        $output .= self::checkBox('LoginForm[rememberMe]', false, array('label' => 'Remember me'));

        $output .= '<div >';
        $output .= self::submitButton('Sign in');
        $output .= self::link('Register account', array('sandscape/register'), array('style' => 'margin-left: 2em;'));
        $output .= '</div>';
        $output .= parent::endForm();
        $output .= '</div>';

        return $output;
    }

}
