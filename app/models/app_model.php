<?php

class AppModel extends Model
{
	function begin()
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->begin($this);
	}

	function commit()
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->commit($this);
	}

	function rollback()
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->rollback($this);
	}

	function unbindFully() 
	{
		$unbind = array();
		foreach ($this->belongsTo as $model=>$info) 
		{
			$unbind['belongsTo'][] = $model;
		}
		foreach ($this->hasOne as $model=>$info) 
		{
			$unbind['hasOne'][] = $model;
		}
		foreach ($this->hasMany as $model=>$info) 
		{
			$unbind['hasMany'][] = $model;
		}
		foreach ($this->hasAndBelongsToMany as $model=>$info) 
		{
			$unbind['hasAndBelongsToMany'][] = $model;
		}
		$this->unbindModel($unbind,false);
	}
}
?>