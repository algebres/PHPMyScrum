<?php

class Search extends AppModel {

    var $useTable = false;
    var $base_sql = " SELECT ? as itemtype, resolution_id, id, name, description FROM stories where disabled ='f' and ( name like ? or description like ?) UNION SELECT ? as itemtype, resolution_id, id, name, description FROM tasks where disabled = 'f' and ( name like ? or description like ?) ";
    var $keyword = "";
    var $bind_param = array(ITEMTYPE_STORY, "", "", ITEMTYPE_TASK, "", "");

    function setKeyword($value) {
        $this->keyword = "%" . $value . "%";
        $this->bind_param = array(
            ITEMTYPE_STORY,
            $this->keyword,
            $this->keyword,
            ITEMTYPE_TASK,
            $this->keyword,
            $this->keyword,
        );
    }

    /**     * Overridden paginate method */
    function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
        if ($page == 0) {
            $page = 1;
        }
        $recursive = -1;
        $sql = $this->base_sql . ' LIMIT ' . (($page - 1) * $limit) . ',' . $limit;
        return $this->query($sql, $this->bind_param);
    }

    /**     * Overridden paginateCount method */
    function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        $this->recursive = $recursive;
        $results = $this->query($this->base_sql, $this->bind_param);
        return count($results);
    }

}

?>