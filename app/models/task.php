<?php

App::import('Mode', 'RemainingTime');

class Task extends AppModel {

    var $name = 'Task';
    var $displayField = 'name';
    var $actsAs = array(
        'SoftDeletable' => array('field' => 'disabled', 'find' => false),
        'AutoLogger' => array('saveto' => 'ChangeLog'),
    );
    var $validate = array(
        'id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'sprint_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'story_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'estimate_hours' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
    );
    var $belongsTo = array(
        'Sprint' => array(
            'className' => 'Sprint',
            'foreignKey' => 'sprint_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
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
        ),
        'Resolution' => array(
            'className' => 'Resolution',
            'foreignKey' => 'resolution_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasMany = array(
        'RemainingTime' => array(
            'className' => 'RemainingTime',
            'foreignKey' => 'task_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'RemainingTime.created desc',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    var $fields = array(
        'save' => array('name', 'description', 'sprint_id', 'story_id', 'estimate_hours', 'resolution_id', 'user_id'),
        'simple_save' => array('description', 'estimate_hours', 'resolution_id', 'user_id'),
    );

    /**
     * タスク更新の際には時間を残時間テーブルにも突っ込む
     */
    function afterSave($created) {
        if ($created) {
            $task_id = $this->getInsertID();
        } else {
            $task_id = @$this->data["Task"]["id"];
            if (!$task_id) {
                $task_id = $this->getID();
            }
        }
        $this->recursive = 0;
        $data = $this->findById($task_id);
        if (empty($data)) {
            return;
        }
        $hours = $data["Task"]["estimate_hours"];
        $disabled = $data["Task"]["disabled"];
        $created = date('Y-m-d');
        if ($disabled == 0) {
            $this->RemainingTime = new RemainingTime();
            $rec = $this->RemainingTime->findByTaskIdAndCreated($task_id, $created);
            if ($rec) {
                $d["RemainingTime"]["id"] = $rec["RemainingTime"]["id"];
            }
            $d["RemainingTime"]["task_id"] = $task_id;
            $d["RemainingTime"]["hours"] = $hours;
            $this->RemainingTime->save($d);
        } else {
            $this->deleteRemaining($task_id);
        }
    }

    /**
     * タスクを削除したあと残時間データも削除
     */
    function deleteRemaining($task_id) {
        $this->RemainingTime = new RemainingTime();
        $conditions = array(
            'RemainingTime.task_id' => $task_id,
        );
        $this->RemainingTime->deleteAll($conditions, false);
    }

    /**
     * 自分のタスクを取得
     */
    function getUserTask($user_id, $include_finished_data = false) {
        $belongsto = $this->belongsTo;
        $this->recursive = 1;
        $this->belongsTo["Sprint"]["order"] = "Sprint.startdate asc";
        $this->belongsTo["Story"]["order"] = "Story.id asc";

        $conditions = array(
            'conditions' => array(
                'Task.user_id' => $user_id,
                'Task.disabled' => 0,
            ),
        );
        $records = $this->find('all', $conditions);
        $this->belongsTo = $belongsto;

        // 完了済みを含めない場合は掃除
        if (!$include_finished_data) {
            for ($i = count($records) - 1; $i >= 0; $i--) {
                if ($records[$i]["Resolution"]["is_fixed"] == true) {
                    unset($records[$i]);
                }
            }
        }
        return $records;
    }

    function getRemainingHours($story_id) {
        // 関連するタスクの残り時間を取得
        $conditions = array(
            'conditions' => array(
                'Task.disabled' => 0,
                'Task.story_id' => $story_id,
            ),
        );
        $tasks = $this->find('all', $conditions);
        $total_remaining_hours = 0;
        foreach ($tasks as $task) {
            $total_remaining_hours += $task["Task"]["estimate_hours"];
        }
        return $total_remaining_hours;
    }

    /**
     * Excel保存
     */
    function saveToExcel($data, $filename) {
        Configure::write('debug', 0);
        App::import('Vendor', 'include_path');
        App::import(
                        'Vendor',
                        'Spreadsheet_Excel_Writer',
                        array('file' => 'Spreadsheet' . DS . 'Excel' . DS . 'Writer.php')
        );

        $workbook = new Spreadsheet_Excel_Writer();
        $workbook->send($filename);
        $worksheet = & $workbook->addWorksheet('task');
        $format = & $workbook->addFormat();
        $format->setSize(9);
        $header_format = & $workbook->addFormat();
        $header_format->setSize(9);
        $header_format->setFgColor('gray');

        // ヘッダー
        $header = array('Task Id', 'Sprint', 'Story', 'Task', 'Description',
            'Estimate Hours', 'Username', 'Resolution', 'Created'
        );
        $row = 0;
        $col = 0;
        for ($i = 0; $i < count($header); $i++) {
            $worksheet->write($row, $col, $this->sjis(__($header[$i], true)), $header_format);
            $col++;
        }

        // データ
        $row++;
        foreach ($data as $item) {
            $col = 0;
            $worksheet->writeNumber($row, $col, $this->sjis($item["Task"]["id"]), $format);
            $col++;
            $worksheet->write($row, $col, $this->sjis($item["Sprint"]["name"]), $format);
            $col++;
            $worksheet->write($row, $col, $this->sjis($item["Story"]["name"]), $format);
            $col++;
            $worksheet->write($row, $col, $this->sjis($item["Task"]["name"]), $format);
            $col++;
            $worksheet->write($row, $col, $this->sjis($item["Task"]["description"]), $format);
            $col++;
            $worksheet->writeNumber($row, $col, $this->sjis($item["Task"]["estimate_hours"]), $format);
            $col++;
            $worksheet->write($row, $col, $this->sjis($item["User"]["username"]), $format);
            $col++;
            $worksheet->write($row, $col, $this->sjis($item["Resolution"]["name"]), $format);
            $col++;
            $worksheet->write($row, $col, date('Y-m-d', strtotime($item["Task"]["created"])), $format);
            $col++;
            $row++;
        }

        // 横幅設定
        $width = array(4, 14, 50, 50, 50, 10, 10, 10, 10);
        for ($i = 0; $i < count($width); $i++) {
            $worksheet->setColumn($i, $i, $width[$i]);
        }

        $workbook->close();
        exit;
    }

    /**
     * CSVのヘッダー
     */
    function getCSVHeader() {
        $header = array('Task Id', 'Sprint', 'Story Id', 'Story', 'Task', 'Description',
            'Estimate Hours', 'Username', 'Resolution', 'Created'
        );
        $row = array();
        for ($i = 0; $i < count($header); $i++) {
            $row[] = __($header[$i], true);
        }
        return $row;
    }

    /**
     * CSV保存
     */
    function saveToCSV($data, $filename) {
        Configure::write('debug', 0);

        $list = array();
        $list[] = $this->getCSVHeader();

        // data
        foreach ($data as $item) {
            $row = array();
            $row[] = $item["Task"]["id"];
            $row[] = $item["Sprint"]["name"];
            $row[] = $item["Story"]["id"];
            $row[] = $item["Story"]["name"];
            $row[] = $item["Task"]["name"];
            $row[] = $item["Task"]["description"];
            $row[] = $item["Task"]["estimate_hours"];
            $row[] = $item["User"]["username"];
            $row[] = $item["Resolution"]["name"];
            $row[] = date('Y-m-d', strtotime($item["Task"]["created"]));
            $list[] = $row;
        }
        $this->makeCSV($filename, $list);
        exit;
    }

    /**
     * 検索条件
     */
    function getSelectConditon($param, $user_id) {
        if ($param == "yours") {
            return array(
                'conditions' => array(
                    'Task.disabled' => 0,
                    'Task.user_id' => $user_id,
                ),
            );
        }
        if ($param == "unfinished") {
            return array(
                'conditions' => array(
                    'Task.disabled' => 0,
                    'or' => array(
                        'Resolution.is_fixed !=' => 1,
                        'Task.resolution_id' => null,
                    ),
                ),
            );
        }
        if ($param == "your_unfinished") {
            return array(
                'conditions' => array(
                    'Task.disabled' => 0,
                    'Task.user_id' => $user_id,
                    'or' => array(
                        'Resolution.is_fixed !=' => 1,
                        'Task.resolution_id' => null,
                    ),
                ),
            );
        }
        return array(
            'conditions' => array(
                'Task.disabled' => 0,
            ),
        );
    }

}

?>
