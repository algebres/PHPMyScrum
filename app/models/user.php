<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';
	var $actsAs = array('SoftDeletable' => array('field' => 'disabled', 'find' => false)); 
	var $validate = array(
		'id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'loginname' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => array('isUnique'),
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => array('isUnique'),
			),
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

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

		// �ʏ�
		$this->fields["add"] = array('name', 'loginname', 'password', 'username', 'email');
		$this->fields["edit"] = $this->fields["add"];
		//�Ǘ��җp
		$this->fields["admin_add"] = $this->fields["add"];	$this->fields["admin_add"][] = "admin";
		$this->fields["admin_edit"] = $this->fields["admin_add"];
	}

	/**
	 * ���ݗL���ȃ��[�U�[
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
	 * ���ݗL���ȃ��[�U�[�����邩�ǂ���
	 */
	function hasActiveUser()
	{
		return (count($this->getActiveUserList()) > 0);
	}

	/**
	 * �Ǘ��҃��[�U�[
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
	 * �Ǘ��҃��[�U�[�����邩�ǂ���
	 */
	function hasAdminUser()
	{
		return (count($this->getAdminUserList()) > 0);
	}

	/**
	 * �p�X���[�h�������_���ɍ쐬
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
	 * �A�J�E���g���}�C���_���ɔ����ăo���f�[�V������ύX����
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