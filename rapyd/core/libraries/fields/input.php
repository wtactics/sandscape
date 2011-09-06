<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');


class input_field extends field_field {

  public $type = "text";
  public $css_class = "input";

  public function build()
  {
    $output = "";
    if(!isset($this->size))
    {
      $this->size = 35;
    }
    unset($this->attributes['type']);
    if (parent::build() === false) return;


    //http://digitalbush.com/projects/masked-input-plugin
    if (isset($this->mask))
    {
      rpd_html_helper::js('jquery/jquery.min.js');
      rpd_html_helper::js('jquery/jquery.maskedinput.js');
    }

    switch ($this->status)
    {
      case "disabled":
      case "show":
        if ( (!isset($this->value)) )
        {
          $output = $this->layout['null_label'];
        } elseif ($this->value == ""){
          $output = "";
        } else {
          $output = nl2br(htmlspecialchars($this->value));
        }
        break;

      case "create":
      case "modify":
        $output = rpd_form_helper::input($this->attributes, $this->value);
        if (isset($this->mask))
        {
          $output .= rpd_html_helper::script('
                $(function(){
                  $("#'.$this->name.'").mask("'.$this->mask.'");
                });');
        }
        break;

      case "hidden":
        $output = rpd_form_helper::hidden($this->attributes, $this->value);
        break;

      default:;
    }
    $this->output = "\n".$this->before_output."\n".$output."\n". $this->extra_output."\n";
  }

}
