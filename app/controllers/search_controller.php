<?php

class SearchController extends AppController {

    var $name = "Search";

    function index() {
        $result = array();

        if (isset($this->passedArgs['Search.query'])) {
            $keyword = $this->passedArgs['Search.query'];

            $this->Search->setKeyword($keyword);
        }
        $this->paginate = array(
            'limit' => 20,
        );
        $result = $this->paginate();
        $this->set('result', $result);
    }

    function search() {
        // the page we will redirect to
        $url['action'] = 'index';

        // build a URL will all the search elements in it
        // the resulting URL will be
        // example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
        foreach ($this->data as $k => $v) {
            foreach ($v as $kk => $vv) {
                $url[$k . '.' . $kk] = $vv;
            }
        }

        // redirect the user to the url
        $this->redirect($url, null, true);
    }

}

?>