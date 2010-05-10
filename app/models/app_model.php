<?php

class AppModel extends Model
{
	/**
	 * Concatenate a field name with each validation error message in replaceValidationErrorMessagesI18n().
	 * Field name is set with gettext __()
	 *   true: Concatenate
	 *   false: not Concatenate
	 *
	 * @var boolean
	 * @access protected
	 */
	var $_withFieldName = false;


	/**
	 * Error messages
	 *
	 * @var array
	 * @access protected
	 */
	var $_error_messages = array();
	/**
	 * Define default validation error messages
	 * $default_error_messages can include gettext __() value.
	 *
	 * @return array
	 * @access protected
	 */
	function _getDefaultErrorMessagesI18n(){
		//Write Default Error Message
		$default_error_messages = array(
			'notempty'	=> __('This field can not leave empty.', true),
			'require' 	=> __('This field can not leave empty.', true),
			'email' => __('Invalid Email address.',true),
			'alphanumeric' => __('Please input numerical and alphabetical characters.', true),
			'between' => __('Between %2$d and %3$d characters.',true),
			'numeric' => __('Please input numerical characters.', true),
			'isUnique' => __('This value is not a unique.', true),
			'boolean' => __('This field can set boolean value.', true),
		);

		return $default_error_messages;
	}


	/**
	 * Set validation error messages.
	 *
	 * To change default validation error messages,
	 *  set $add_error_message in each model.
	 *
	 * @param array $add_error_message
	 * @param boolean $all_change_flag
	 *    true: change all default validation error messages
	 *    false: merge $add_error_message with default validation error messages
	 * @access public
	 */
	function setErrorMessageI18n( $add_error_message = null, $all_change_flag=false ) {


		$default_error_messages = $this->_getDefaultErrorMessagesI18n();

		if( !empty( $add_error_message ) && is_array( $add_error_message ) ){
			if( $all_change_flag ){
				$default_error_messages = $add_error_message;
			}else{
				$default_error_messages = array_merge( $default_error_messages, $add_error_message );
			}
			$this->_error_messages = $default_error_messages;

		}elseif( empty($this->_error_messages)  ){
			$this->_error_messages = $default_error_messages;
		}


	}

	/**
	 * get validation error messages
	 *
	 * @return array
	 * @access protected
	 */
	function _getErrorMessageI18n(){
		return $this->_error_messages;
	}


	/**
	 * Replace validation error messages for i18n
	 *
	 * @access public
	 */
	function replaceValidationErrorMessagesI18n(){
		$this->setErrorMessageI18n();

		foreach( $this->validate as $fieldname => $ruleSet ){
			foreach( $ruleSet as $rule => $rule_info ){

				$rule_option = array();
				if(!empty($this->validate[$fieldname][$rule]['rule'])) {
					$rule_option = $this->validate[$fieldname][$rule]['rule'];
				}

				$error_message_list = $this->_getErrorMessageI18n();
				$error_message = ( array_key_exists($rule, $error_message_list ) ? $error_message_list[$rule] : null ) ;

				if( !empty( $error_message ) ) {
					$this->validate[$fieldname][$rule]['message'] = vsprintf($error_message, $rule_option);

				}elseif( !empty($this->validate[$fieldname][$rule]['message']) ){
					$this->validate[$fieldname][$rule]['message'] = __( $this->validate[$fieldname][$rule]['message'], true);
				}


				if( $this->_withFieldName && !empty($this->validate[$fieldname][$rule]['message']) ){
					$this->validate[$fieldname][$rule]['message'] = __( $fieldname ,true) . ' : ' . $this->validate[$fieldname][$rule]['message'];
				}
			}
		}
	}


	function beforeValidate(){
		$this->replaceValidationErrorMessagesI18n();
		return true;
	}


	/**
	 * Transaction Support for multi RDBMS
	 *
	 * @access public
	 */
	function begin()
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->begin($this);
	}

	/**
	 * Transaction Support for multi RDBMS
	 *
	 * @access public
	 */
	function commit()
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->commit($this);
	}

	/**
	 * Transaction Support for multi RDBMS
	 *
	 * @access public
	 */
	function rollback()
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->rollback($this);
	}


	/**
	 * Release bind rules
	 *
	 * @access public
	 */
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

	/**
	 * convert string to sjis
	 *
	 * @access public
	 */
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

	/**
	 * output csv
	 *
	 * @access public
	 */
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