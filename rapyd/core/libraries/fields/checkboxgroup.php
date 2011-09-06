<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');

class checkboxgroup_field extends field_field {

  public $type = "checks";
  public $size = null;
  public $description = "";
  public $separator = "&nbsp;&nbsp;";
  public $format = "%s";
  public $css_class = "checkbox";
  public $checked_value = 1;
  public $unchecked_value = 0;

  function get_value()
  {
    parent::get_value();

    /*if ($this->options_table=="")
    {

    }*/
    $this->values = explode($this->serialization_sep, $this->value);
    $description_arr = array();
    foreach ($this->options as $value=>$description)
    {
      if (in_array($value,$this->values))
      {
        $description_arr[] = $description;
      }
    }
    $this->description = implode($this->separator, $description_arr);
  }

  function build()
  {
    $output = "";

    if(!isset($this->style))
    {
      $this->style = "margin:0 2px 0 0; vertical-align: middle";
    }
    unset($this->attributes['id']);
    if (parent::build() === false) return;



    switch ($this->status)
    {
      case "disabled":
      case "show":
        if (!isset($this->value))
        {
          $output = $this->layout['null_label'];
        } else {
          $output = $this->description;
        }
        break;

      case "create":
      case "modify":

        $i = 1;
        foreach ($this->options as $val => $label )
        {
          $attributes = $this->attributes;
          $attributes['name'] = $this->name.'[]';
          $attributes['id'] = $this->name.'_'.$i++;
          $this->checked = in_array($val,$this->values);
          $output .= sprintf($this->format, rpd_form_helper::checkbox($attributes, $val , $this->checked).$label).$this->separator;
        }
        $output .=  $this->extra_output();
        break;

      case "hidden":
        $output = rpd_form_helper::hidden($this->name, $this->value);
        break;

      default:
    }
    $this->output = $output;
  }


}
