<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');



class date_field extends field_field {

  public $type = "date";
  public $css_class = "input";
  public $clause = "where";

	// --------------------------------------------------------------------

  public function get_new_value()
  {
    parent::get_new_value();
    if (isset($_POST[$this->name]))
    {
      $this->new_value = rpd_date_helper::human2iso($this->new_value);
    }
  }

	// --------------------------------------------------------------------

  function build()
  {
		$output = "";
    rpd_html_helper::css('jscalendar/calendar.css');
    rpd_html_helper::js('jscalendar/calendar.js');
    rpd_html_helper::js('jscalendar/calendar-setup.js');
    rpd_html_helper::head_script('
          Calendar._DN = new Array("Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica");
          Calendar._SMN = new Array("Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic");
          Calendar._SDN = new Array("", "Lu", "Ma", "Me", "Gi", "Ve", "Sa", "");
          Calendar._MN = new Array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
          Calendar._TT = {};
          Calendar._TT["TODAY"] = "Oggi"');

    if(!isset($this->size))
    {
      $this->size = 25;
    }
    unset($this->attributes['type']);
    if (parent::build() === false) return;

    switch ($this->status)
    {

      case "show":
        if (!isset($this->value))
        {
          $value = $this->layout['null_label'];
        } elseif ($this->value == ""){
          $value = "";
        } else {
          $value = rpd_date_helper::iso2human($this->value);
        }
        $output = $value;
        break;

      case "create":
      case "modify":

        $value = "";
        if ($this->value != ""){
           if ($this->is_refill){
             $value = $this->value;
           } else {
             $value = rpd_date_helper::iso2human($this->value);
           }
        }
        $output  = rpd_form_helper::input($this->attributes, $value);
        //$output .= html::image('jscalendar/calender_icon.gif', array('id'=>$this->name.'_button', 'border'=>0, 'style'=>'vertical-align:middle')).$this->extra_output;
        $output .= rpd_html_helper::script('
                   Calendar.setup({
                   inputField  : "'.$this->name.'",
                   ifFormat    : "%d/%m/%Y",
                   align       : "Bl",
                   singleClick : false,
                   mondayFirst : true,
                   weekNumbers : false
                  });');
                  //button      : "'.$this->name.'_button",
        break;

      case "disabled":
        //versione encoded
        $output = rpd_date_helper::iso2human($this->value);
        break;

      case "hidden":
        $output =  rpd_form_helper::hidden($this->name, $this->value);
        break;

      default:
    }
    $this->output = $output;
  }

}
