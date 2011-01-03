<?php

class Team extends AppModel {

    var $name = 'Team';
    var $displayField = 'name';
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
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
    );
    var $hasMany = array(
        'Teammember' => array(
            'className' => 'Teammember',
            'foreignKey' => 'team_id',
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
    var $fields = array(
        'save' => array('name', 'description'),
    );

    /**
     * 現在有効なチーム
     */
    function getActiveTeamList() {
        $conditions = array(
            'conditions' => array(
                'Team.disabled' => 0,
            ),
        );
        return $this->find('list', $conditions);
    }

    /**
     * チーム名一覧から名前に合致するチームのIDを探す
     */
    function getTeamId($teams, $name) {
        foreach ($teams as $key => $value) {
            if ($value === $name) {
                return $key;
            }
        }
        return null;
    }

}

?>