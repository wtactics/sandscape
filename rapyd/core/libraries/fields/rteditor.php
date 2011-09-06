<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');


class rteditor_field extends field_field {

  public $type = "rteditor";
  public $css_class = "rteditor";

  function get_new_value()
  {
    parent::get_new_value();
    if (isset($this->new_value))
    {
      if (substr($this->new_value, strlen($this->new_value)-4, 4) == '<br>')
        $this->new_value =  substr($this->new_value, 0, strlen($this->new_value)-4);
    }
  }

  function build()
  {
    $output = "";
    rpd_html_helper::js('jquery/jquery.min.js');
    rpd_html_helper::js('jqueryrte/jquery.rte.js');
    rpd_html_helper::js('jqueryrte/jquery.rte.tb2.js');
    rpd_html_helper::css('jqueryrte/jquery.rte.css');


    if(!isset($this->cols))
    {
      $this->cols = 45;
    }
    if(!isset($this->rows)){
      $this->rows = 15;
    }
    unset($this->attributes['type'],$this->attributes['size']);
    if (parent::build() === false) return;


    switch ($this->status)
    {
      case "disabled":
      case "show":
        if (!isset($this->value))
        {
          $output = $this->layout['null_label'];
        }
        elseif ($this->value == "")
        {
          $output = "";
        }
        else
        {
          $output = '<div class="textarea_disabled">'.nl2br(htmlspecialchars($this->value)).'</div>';
        }
        break;

      case "create":
      case "modify":


        $output  = rpd_form_helper::textarea($this->attributes, $this->value);
        $output .= rpd_html_helper::script("

                                $(document).ready(function() {
                                        $('textarea#".$this->name."').rte({
                                            	css: ['".RAPYDASSETS."jqueryrte/rte.css'],
                                                controls_rte: rte_toolbar,
                                                controls_html: html_toolbar
                                        });
                                });");

        break;

      case "hidden":

        $output = rpd_form_helper::hidden($this->name, $this->value);
        break;

      default:
    }
    $this->output = "\n".$this->before_output.$output. $this->extra_output."\n";
  }

}
