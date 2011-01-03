<?php

/**
 * wiki
 *
 * inspired and delivered by chaw.
 * original license information
 * @copyright  Copyright 2009, Garrett J. Woodworth (gwoohoo@gmail.com)
 * @license    GNU AFFERO GENERAL PUBLIC LICENSE v3 (http://opensource.org/licenses/agpl-v3.html)
 *
 */
class Wiki extends AppModel {

    var $name = 'Wiki';
    var $displayField = 'slug';
    var $useTable = 'wiki';
    var $actsAs = array('Directory');
    var $validate = array(
        'slug' => array(
            'required' => true,
            'rule' => 'notEmpty'
        ),
        'body' => array('notEmpty')
    );
    var $belongsTo = array(
        'User' => array(
            'foreignKey' => 'last_modified_user_id'
        ),
    );
    var $_findMethods = array('superList' => true);

    function slug($string) {
        $replace = (strpos($string, '-') !== false) ? '-' : '_';
        return Inflector::slug($string, $replace);
    }

    function _findSuperList($state, $query, $results = array()) {
        if ($state == 'before') {
            return $query;
        }

        if ($state == 'after') {
            if (!isset($query['separator'])) {
                $query['separator'] = ' ';
            }
            for ($i = 0; $i <= 2; $i++) {
                if (strpos($query['fields'][$i], '.') === false) {
                    $query['fields'][$i] = $this->alias . '/' . $query['fields'][$i];
                } else {
                    $query['fields'][$i] = str_replace('.', '/', $query['fields'][$i]);
                }
            }
            return Set::combine($results, '/' . $query['fields'][0], array(
                '%s' . $query['separator'] . '%s',
                '/' . $query['fields'][1],
                '/' . $query['fields'][2]
            ));
        }
    }

    function beforeValidate() {
        if (!empty($this->data['Wiki']['title'])) {
            $this->data['Wiki']['slug'] = $this->data['Wiki']['title'];
        }
        return true;
    }

    function beforeSave() {
        $this->data['Wiki']['slug'] = $this->slug($this->data['Wiki']['slug']);

        // 保存前に過去の同じIDのものを全部無効にする
        $this->recursive = -1;
        $this->updateAll(array(
            'Wiki.disabled' => 1,
            'Wiki.updated' => "'" . date('Y-m-d H:i:s') . "'"
                ),
                array(
                    'Wiki.slug' => $this->data['Wiki']['slug'],
                    'Wiki.path' => $this->data['Wiki']['path'],
        ));

        return true;
    }

    function activate($data = array()) {
        $this->set($data);
        $this->data['Wiki']['disabled'] = 0;
        return $this->save();
    }

}

?>