<?php
App::uses('AppController', 'Controller');
class WoodtypesController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array(
                'Woodtype.name' => 'ASC'
            ),
            'limit' => 100,
        );

        $this->set('tags', $this->Paginator->paginate('Woodtype'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Woodtype->exists($id)) {
            throw new NotFoundException('Invalid Woodtype');
        }
        $options = array('conditions' => array('Woodtype.id' => $id));
        $this->set('tag', $this->Woodtype->find('first', $options));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Woodtype->create();
            if ($this->Woodtype->save($this->request->data)) {
                $this->Session->setFlash('The Woodtype has been saved.');
                return $this->redirect($this->referer());
                // return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Woodtype could not be saved. Please, try again.');
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Woodtype->exists($id)) {
            throw new NotFoundException('Invalid Woodtype');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Woodtype->save($this->request->data)) {
                $this->Session->setFlash('The Woodtype has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Woodtype could not be saved. Please, try again.');
            }
        } else {
            $options = array('conditions' => array('Woodtype.id' => $id));
            $this->request->data = $this->Woodtype->find('first', $options);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Woodtype->id = $id;
        if (!$this->Woodtype->exists()) {
            throw new NotFoundException('Invalid Woodtype');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Woodtype->delete()) {
            $this->Session->setFlash('The Woodtype has been deleted.');
        } else {
            $this->Session->setFlash('The Woodtype could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
