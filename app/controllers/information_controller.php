<?php

class InformationController extends AppController {

    var $name = 'Information';
    var $components = array('Session');

    function index() {
        $this->Information->recursive = 0;
        $this->set('information', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), __('Information', true)));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('information', $this->Information->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Information->create();
            if ($this->Information->save($this->data, array('fieldList' => $this->Information->fields['save']))) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Information', true)));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Information', true)));
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), __('Information', true)));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Information->save($this->data, array('fieldList' => $this->Information->fields['save']))) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), __('Information', true)));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), __('Information', true)));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Information->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid id for %s', true), __('Information', true)));
            $this->redirect(array('action' => 'index'));
        }
        $this->Information->delete($id);
        $this->Session->setFlash(sprintf(__('%s deleted', true), __('Information', true)));
        $this->redirect(array('action' => 'index'));
    }

}

?>