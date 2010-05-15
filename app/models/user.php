<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';
	var $actsAs = array('SoftDeletable' => array('field' => 'disabled', 'find' => false));
	var $validate = array(
		'id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'loginname' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
			),
			'unique' => array(
				'rule' => array('isUnique'),
			),
			'notempty' => array(
				'rule' => array('notempty'),
			),
			'between' => array(
				'rule' => array('between', 4, 20),
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
			),
			'between' => array(
				'rule' => array('between', 6, 20),
			),
		),
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
			'unique' => array(
				'rule' => array('isUnique'),
			),
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
			),
			'between' => array(
				'rule' => array('between', 4, 20),
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
			),
		),
	);

	var $hasMany = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => 'Task.disabled = 0',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Teammember' => array(
			'className' => 'Teammember',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	var $fields = array();

	function  __construct()
	{
		parent::__construct();

		// 通常
		$this->fields["add"] = array('name', 'loginname', 'password', 'username', 'email');
		$this->fields["edit"] = $this->fields["add"];
		//管理者用
		$this->fields["admin_add"] = $this->fields["add"];	$this->fields["admin_add"][] = "admin";
		$this->fields["admin_edit"] = $this->fields["admin_add"];
	}

	/**
	 * 現在有効なユーザー
	 */
	function getActiveUserList()
	{
		$conditions = array(
			'conditions' => array(
				'User.disabled' => 0,
			),
		);
		return $this->find('list', $conditions);
	}

	/**
	 * ユーザー名一覧から名前に合致するユーザーのIDを探す
	 */
	function getUserId($users, $name)
	{
		foreach($users as $key => $value)
		{
			if($value === $name)
			{
				return $key;
			}
		}
		return null;
	}


	/**
	 * 現在有効なユーザーがいるかどうか
	 */
	function hasActiveUser()
	{
		return (count($this->getActiveUserList()) > 0);
	}

	/**
	 * 管理者ユーザー
	 */
	function getAdminUserList()
	{
		$conditions = array(
			'conditions' => array(
				'User.disabled' => 0,
				'User.admin' => 1,
			),
		);
		return $this->find('list', $conditions);
	}

	/**
	 * 管理者ユーザーがいるかどうか
	 */
	function hasAdminUser()
	{
		return (count($this->getAdminUserList()) > 0);
	}

	/**
	 * パスワードをランダムに作成
	 */
	function make_password($length = 8)
	{
		$sCharList = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz123456789";
		mt_srand();
		$result = "";
		for($i = 0; $i < $length; $i++)
		{
			$result .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
		}
		return $result;
	}

	/**
	 * アカウントリマインダ等に備えてバリデーションを変更する
	 */
	function changeValidationRuleForReset()
	{
		unset($this->validate['username']['unique']);
		unset($this->validate['password']);
		unset($this->validate['new_password']);
		unset($this->validate['loginname']['unique']);
	}


	function addValidationRuleChangePassword()
	{
		$this->validate["new_password"] = $this->validate["password"];
	}

}
?>