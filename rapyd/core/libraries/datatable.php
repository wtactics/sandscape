<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');

rpd::load('component','dataset');

class datatable extends dataset {

  protected $fields	= array();
  protected $header_footer = true;

  public $per_row = 2;
  public $cell_template = "";
  public $cell_attributes = array('style'=>'vertical-align:top;');



  protected function build_table()
  {
    rpd_html_helper::css('datatable.css');

    $data = get_object_vars($this);

    $this->build_buttons();
    $data['container'] = $this->button_containers();


		$dataset = $this->data;
		$num_rows = ceil(count($dataset) / $this->per_row);
		$itrations = $this->per_row;

		//table rows
		for($i=0; $i< $num_rows; $i++)
    {
			unset($tds);

			//table-cells
			for($j=1; $j<= $itrations; $j++)
      {
				if (isset($dataset[0]))
        {
					if (!is_array($dataset[0]))
          {
						$this->cell_template = "&nbsp;";
					}
				} else {
						$this->cell_template = "&nbsp;";
				}

				$cell = new datatable_cell(array('pattern'=>$this->cell_template));

				if (isset($dataset[0]))
        {
					$cell->set_value($dataset[0]);
				} else {
					$cell->set_value("");
				}

				$td["attributes"] = rpd_html_helper::attributes($this->cell_attributes);
				$td["content"] = $cell->get_value();
				$tds[] = $td;
				array_shift($dataset);
			}
			$trs[] = $tds;
		}
    $data["trs"] = $trs;

    $data["pagination"] = $this->pagination;
    $data["total_rows"] = $this->total_rows;

    return rpd::view('datatable', $data);
  }


  public function build($method = 'table')
  {
    parent::build();
    $method = 'build_'.$method;
    $this->output = $this->$method();
  }

}




class datatable_cell extends rpd_component {

  protected $pattern = "";
  protected $field_list = array();

  // --------------------------------------------------------------------

  public function __construct($config = array())
  {
    parent::__construct($config);
     $this->field_list = parent::parse_pattern($this->pattern);
  }

  // --------------------------------------------------------------------

  function set_value($data_row)
  {
    $this->rpattern = $this->replace_pattern($this->pattern,$data_row);
  }

  // --------------------------------------------------------------------

  function get_value()
  {
    if ($this->rpattern == "")
    {
      $this->rpattern = "&nbsp;";
    }
    $this->rpattern = parent::replace_functions($this->rpattern);
    return $this->rpattern;
  }

}

?>
