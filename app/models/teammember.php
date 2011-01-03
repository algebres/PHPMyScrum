<?php

class Teammember extends AppModel {

    var $name = 'Teammember';
    var $actsAs = array('SoftDeletable' => array('field' => 'disabled', 'find' => false));
    var $validate = array(
        'team_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'user_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
    );
    var $fields = array(
        'save' => array('team_id', 'user_id'),
    );
    var $belongsTo = array(
        'Team' => array(
            'className' => 'Team',
            'foreignKey' => 'team_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}

?>