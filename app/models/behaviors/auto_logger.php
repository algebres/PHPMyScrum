<?php
/**
 * Auto save the difference of old value from new value.
 *
 * @filesource
 * @author Ryutaro "Ryuzee" YOSHIBA
 * @link http://www.ryuzee.com
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package app
 * @subpackage app.models.behaviors
 * @description before using this behaviro, you have to create a new table named "change_logs".
 *
 * CREATE TABLE `change_logs` (
 *   `id` int(11) NOT NULL AUTO_INCREMENT,
 *   `mode` varchar(6) NOT NULL,
 *   `name` varchar(255) DEFAULT NULL,
 *   `old_value` text,
 *   `new_value` text,
 *   `created` datetime NOT NULL,
 *   PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 *
 */

/**
 * Model behavior to support auto-saving the difference from old value to new value.
 *
 * @package app
 * @subpackage app.models.behaviors
 */
class AutoLoggerBehavior extends ModelBehavior 
{

	var $__settings = array();

	function setup(&$Model, $settings = array())
	{
		$default = array('saveto' => 'ChangeLog');

		if (!isset($this->__settings[$Model->alias]))
		{
			$this->__settings[$Model->alias] = $default;
		}

		$this->__settings[$Model->alias] = am($this->__settings[$Model->alias], ife(is_array($settings), $settings, array()));
	}

	function beforeSave(&$Model)
	{
		$id = $Model->id;
		$new_value = $new_data = $Model->data;
		$old_value = array();
		$mode = "insert"; 
		if($id)
		{
			$mode = "update";
			$Model->recursive = -1;
			$old_value = $Model->find(
				'first', 
				array('conditions' => array($Model->alias . "." . $Model->primaryKey => $id))
			);
		}
		$diff_array = array();
		if(is_array(@$old_value[$Model->alias]) && is_array(@$new_value[$Model->alias]))
		{
			$diff_array = array_diff_assoc(@$old_value[$Model->alias], @$new_value[$Model->alias]);
			$diff_keys = array_keys($diff_array);
		}
		else
		{
			$diff_keys = array_keys($new_value[$Model->alias]);
		}
		$reserved_keys = array('created', 'updated', 'modified');
		if(is_array(@$old_value[$Model->alias]))
		{
			foreach($old_value[$Model->alias] as $k => $v)
			{
				if($k != $Model->primaryKey && (!in_array($k, $diff_keys) || in_array($k, $reserved_keys)))
				{
					unset($old_value[$Model->alias][$k]);
				}
			}
		}
		if(is_array(@$new_value[$Model->alias]))
		{
			foreach($new_value[$Model->alias] as $k => $v)
			{
				if($k != $Model->primaryKey && (!in_array($k, $diff_keys) || in_array($k, $reserved_keys)))
				{
					unset($new_value[$Model->alias][$k]);
				}
			}
		}
		$change["mode"] = $mode;
		$change["name"] = $Model->alias;
		$change["old_value"] = serialize($old_value);
		$change["new_value"] = serialize($new_value);
		$result = $this->saveLog($Model, $change);

		$Model->data = $new_data;
		return $result;
	}

	function beforeDelete(&$Model)
	{
		$Model->recursive = -1;
		$old_value = $Model->find('first', array('conditions' => array($Model->alias . "." . $Model->primaryKey => $Model->id)));
		$new_value = array();
		$change["mode"] = "delete";
		$change["name"] = $Model->alias;
		$change["old_value"] = serialize($old_value);
		$change["new_value"] = serialize($new_value);
		return $this->saveLog($Model, $change);
	}

	private function saveLog(&$Model, $change)
	{
		$m = $this->__settings[$Model->alias]["saveto"];
		$t = ClassRegistry::init($m);
		$t->create();
		return $t->save($change);
	}
}
?>
