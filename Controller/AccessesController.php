<?php
App::uses('AuthoriseAppController', 'Authorise.Controller');
App::uses('CakeEmail', 'Network/Email');
Configure::load('Authorise.authorise_options');

class AccessesController extends AuthoriseAppController {
    public function index()
    {
        $this->set(Configure::read('Authorise'));
        $fields=Configure::read('Authorise.fields');
        $this->Access->recursive = 0;
        $this->paginate = array('order' => array('order' => 'ASC'));
        $accesses = $this->paginate();
        $this->set(compact('accesses','fields'));
    }
    
    public function add()
    {
        $this->set(Configure::read('Authorise'));
        $fields=Configure::read('Authorise.fields');
		if($this->request->is('post')) {
            $this->Access->create();
            if ($this->Access->save($this->request->data)) {
               // $this->Session->setFlash(__('The Access information has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('fields'));
    }
    
    public function edit($id = null) {
        $this->set(Configure::read('Authorise'));
        $fields=Configure::read('Authorise.fields');
        $this->Access->id = $id;
        if (!$this->Access->exists()) {
            throw new NotFoundException(__('Invalid Access ID'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Access->save($this->request->data)) {
                $this->Session->setFlash(__('The Access information has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Access->read(null, $id);
        }
        $this->set(compact('fields'));
        $this->render('add');
    }
    public function delete_access($id = null){
		$this->Access->id = $id;
		if (!$this->Access->exists()) {
			throw new NotFoundException(__('Invalid access'));
		}
		if ($this->Access->delete($id)) {
			$this->Session->setFlash(__('Access is deleted'));
			$this->redirect(array('controller'=>'accesses','action' => 'index'));
		}
		$this->Session->setFlash(__('Access was not deleted'));
		$this->redirect(array('action' => 'index'));
    }
    
}
