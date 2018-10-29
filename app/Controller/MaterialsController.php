<?php
App::uses('AppController', 'Controller');
class MaterialsController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array(
                'Material.name' => 'ASC'
            ),
            'limit' => 100,
        );

        $this->set('Material', $this->Paginator->paginate('Material'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Material->exists($id)) {
            throw new NotFoundException('Invalid Material');
        }
        $options = array('conditions' => array('Material.id' => $id));
        $this->set('Material', $this->Material->find('first', $options));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Material->create();
            if ($this->Material->save($this->request->data)) {
                $this->Session->setFlash('The Material has been saved.');
                return $this->redirect($this->referer());
                // return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Material could not be saved. Please, try again.');
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Material->exists($id)) {
            throw new NotFoundException('Invalid Material');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Material->save($this->request->data)) {
                $this->Session->setFlash('The Material has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Material could not be saved. Please, try again.');
            }
        } else {
            $options = array('conditions' => array('Material.id' => $id));
            $this->request->data = $this->Material->find('first', $options);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Material->id = $id;
        if (!$this->Material->exists()) {
            throw new NotFoundException('Invalid Material');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Material->delete()) {
            $this->Session->setFlash('The Material has been deleted.');
        } else {
            $this->Session->setFlash('The Material could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
