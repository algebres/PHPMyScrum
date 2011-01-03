<?php

class StoryComment extends AppModel {

    var $name = 'StoryComment';
    var $validate = array(
        'story_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'user_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'comment' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'disabled' => array(
            'boolean' => array(
                'rule' => array('boolean'),
            ),
        ),
    );
    var $belongsTo = array(
        'Story' => array(
            'className' => 'Story',
            'foreignKey' => 'story_id',
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
    var $fields = array(
        'save' => array('story_id', 'user_id', 'comment'),
    );

}

?>