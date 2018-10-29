<?php
App::uses('AppController', 'Controller');
class MechanismsController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array( 
                'Mechanism.name' => 'ASC'
            ),
            'limit' => 100,
        );

        $this->set('mechanism', $this->Paginator->paginate('Mechanism'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Mechanism->exists($id)) {
            throw new NotFoundException('Invalid Mechanism');
        }
        $options = array('conditions' => array('Mechanism.id' => $id));
        $this->set('Mechanism', $this->Mechanism->find('first', $options));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Mechanism->create();
            if ($this->Mechanism->save($this->request->data)) {
                $this->Session->setFlash('The Mechanism has been saved.');
                return $this->redirect($this->referer());
                // return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Mechanism could not be saved. Please, try again.');
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Mechanism->exists($id)) {
            throw new NotFoundException('Invalid Mechanism');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Mechanism->save($this->request->data)) {
                $this->Session->setFlash('The Mechanism has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Mechanism could not be saved. Please, try again.');
            }
        } else {
            $options = array('conditions' => array('Mechanism.id' => $id));
            $this->request->data = $this->Mechanism->find('first', $options);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Mechanism->id = $id;
        if (!$this->Mechanism->exists()) {
            throw new NotFoundException('Invalid Mechanism');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Mechanism->delete()) {
            $this->Session->setFlash('The Mechanism has been deleted.');
        } else {
            $this->Session->setFlash('The Mechanism could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
