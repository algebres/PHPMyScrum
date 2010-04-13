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

	// sjisに変換する
	function sjis($str)
	{
		if(function_exists('mb_convert_encoding'))
		{
			return mb_convert_encoding($str, "SJIS", "UTF-8");
		}
		else
		{
			return $str;
		}
	}

	// csvでダウンロード
	function makeCSV($filename, $list)
	{
		$out = '';
		if (!empty($list)) {
			$fp = fopen("php://memory", 'r+');
			foreach ($list as $row)
			{
				fputcsv($fp, $row);
			}
			rewind($fp);
			//$out = mb_convert_encoding(stream_get_contents($fp), 'SJIS', mb_internal_encoding());
			$out = stream_get_contents($fp);
		}
		header("Cache-Control:");
		header("Pragma:");
		header('Content-Type: application/octet-stream; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $out;
		exit;
	}
}
?>