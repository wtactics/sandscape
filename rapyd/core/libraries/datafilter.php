<?php

if (!defined('RAPYD_PATH'))
	exit('No direct script access allowed');

/**
 * Datafilter library
 * 
 * @package    Core
 * @author     Felice Ostuni
 * @copyright  (c) 2011 Rapyd Team
 * @license    http://www.rapyd.com/license
 */
class datafilter_library extends dataform_library
{

	/**
	 * datafilter basically work with active record db class to build a where clause
	 * 
	 * @todo check if source can be also a model, then change code otherwise it will not work
	 * @param array $config 
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->connect();
		if (isset($this->source))
		{
			$this->db->select('*');
			$this->db->from($this->source);
		}
		$this->status = 'create';
		//sniff current action
		$this->sniff_action();
	}

	/**
	 * detect current dataform "action" checking current url
	 */
	protected function sniff_action()
	{
		$url = rpd_url_helper::remove_all();
		$this->reset_url = rpd_url_helper::append('reset', 1, $url);
		$this->process_url = rpd_url_helper::append('search', 1, $url);
		///// search /////
		if (rpd_url_helper::value('search'))
		{
			$this->action = "search";
			// persistence
			rpd_sess_helper::save_persistence();
		}
		///// reset /////
		elseif (rpd_url_helper::value("reset"))
		{
			$this->action = "reset";
			// persistence cleanup
			rpd_sess_helper::clear_persistence();
		}
		///// show /////
		else
		{
			// persistence
			rpd_sess_helper::save_persistence();
		}
	}

	/**
	 * internal, process an action: (reset or search)
	 * check each field value and prepare a WHERE  clause using active record 
	 * 
	 * @todo fix for checkboxgroup as nico suggested http://www.rapyd.com/forum/post/21/#p21
	 * @return type 
	 */
	public function process()
	{
		$result = parent::process();
		switch ($this->action)
		{
			case "search":
				// prepare the WHERE clause
				foreach ($this->fields as $field)
				{
					if ($field->value != "")
					{
						if (strpos($field->name, "_copy") > 0)
						{
							$name = substr($field->db_name, 0, strpos($field->db_name, "_copy"));
						} else
						{
							$name = $field->db_name;
						}
						$field->get_value();
						$field->get_new_value();
						$value = $field->new_value;
						switch ($field->clause)
						{
							case "like":
								$this->db->like($name, $value);
								break;
							case "orlike":
								$this->db->orlike($name, $value);
								break;
							case "where":
								$this->db->where($name . " " . $field->operator, $value);
								break;
							case "orwhere":
								$this->db->orwhere($name . " " . $field->operator, $value);
								break;
						}
					}
				}
				$this->build_buttons();
				return $this->build_form();
				break;
			case "reset":
				//pulire sessioni
				$this->build_buttons();
				return $this->build_form();
				break;
			default:
				$this->build_buttons();
				return $this->build_form();
				break;
		}
	}

	/**
	 * internal, add a submit button
	 * 
	 * @param array $config 
	 */
	function search_button($config = null)
	{
		$caption = (isset($config['caption'])) ? $config['caption'] : rpd::lang('btn.search');
		$this->submit("btn_submit", $caption, "BL");
	}

	/**
	 * internal, add a reset button
	 * 
	 * @param array $config 
	 */
	function reset_button($config = null)
	{
		$caption = (isset($config['caption'])) ? $config['caption'] : rpd::lang('btn.reset');
		$action = "javascript:window.location='" . $this->reset_url . "'";
		$this->button("btn_reset", $caption, $action, "BL");
	}

	/**
	 * main method it detect status, process form and build output
	 */
	function build()
	{
		$this->reset_url = $this->reset_url . $this->hash;
		$this->process_url = $this->process_url . $this->hash;
		//sniff and build fields
		$this->sniff_fields();
		//build fields
		$this->build_fields();
		$this->output = $this->process();
	}

}
