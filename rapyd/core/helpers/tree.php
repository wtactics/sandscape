<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');



class rpd_tree_helper
{
	public $tree;
	public $options;

	public $categories = array();
	public $path = '';
	public $path_separator;
	public $current_cat_id;
	public $separator = ' > ';

	public $table;
	public $field_cat_id;
	public $field_parent_id;
	public $field_label;
	public $field_orderby = 'priority';
	public $hide_cat_id;

	public function clear()
	{
		$vars = get_class_vars('rpd_tree');
		foreach($vars as $property=>$value)
		{
			$this->$property = $value;
		}
	}

	function get_tree($parent_id, $level=0)
	{
		static $tree;

		$cid = $this->field_cat_id;
		$pid = $this->field_parent_id;
		$label = $this->field_label;
		$table = $this->table;
		$orderby = $this->field_orderby;

		$andwhere = '';
		if ($this->hide_cat_id!="")
		{
			$notincat = (array)$this->hide_cat_id;
			$andwhere .= ' AND '.$cid.' NOT IN ('.implode(',',$notincat).')';
		}

		$sql = ' SELECT '. $cid.', '. $pid.', '. $label
					.' FROM '.$table
					.' WHERE '.$pid.' = '.$parent_id
					.  $andwhere
					.' ORDER BY '.$orderby.' ASC ';

		rpd::$db->query($sql);


		if (rpd::$db->num_rows())
		{
			$tree .= "\n".str_repeat("\t", $level)."<ul>\n";
			$rows = rpd::$db->result_array();
			foreach ($rows as $row)
			{
			  $this->options[$row[$cid]] = str_repeat("&nbsp;&nbsp;", $level) . $row[$label];
				$tree .= str_repeat("\t", $level).'<li><p>'.$row[$label];
				$this->get_tree($row[$cid], $level+1);
				$tree .= str_repeat("\t", $level)."</p></li>\n";
			}
			$tree .= str_repeat("\t", $level)."</ul>\n";
		}
		return $tree;
	}


	//breadcrumbs

	function get_categories()
	{
		$sql = ' SELECT '. $cid.', '. $pid.', '. $label.' FROM '.$table;
		rpd::$db->query($sql);
		if (rpd::$db->num_rows())
		{
			$this->categories = rpd::$db->result_array();
		}
	}

	function get_parent($id)
	{
		foreach ($this->categories as $value)
		{
			if ($value[$this->field_cat_id] == $id)
			{
				$this->path = $this->separator.$value[$this->field_label] . $this->path;
				return $value[$this->field_parent_id];
			}
		}
		return 0;
	}

	function get_path($cat_id)
	{
		$this->get_categories();
		$this->current_cat_id = $cat_id;
		do {
			$this->current_cat_id = $this->get_parent($this->current_cat_id);
		} while ($this->current_cat_id!==0);

		return $this->path;
	}




}
