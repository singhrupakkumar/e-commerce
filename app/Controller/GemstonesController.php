<?php
App::uses('AppController', 'Controller');
class GemstonesController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array(
                'Gemstone.name' => 'ASC'
            ),
            'limit' => 100,
        );

        $this->set('Gemstone', $this->Paginator->paginate('Gemstone'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Gemstone->exists($id)) {
            throw new NotFoundException('Invalid Gemstone');
        }
        $options = array('conditions' => array('Gemstone.id' => $id));
        $this->set('Gemstone', $this->Gemstone->find('first', $options));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Gemstone->create();
            if ($this->Gemstone->save($this->request->data)) {
                $this->Session->setFlash('The Gemstone has been saved.');
                return $this->redirect($this->referer());
                // return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Gemstone could not be saved. Please, try again.');
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Gemstone->exists($id)) {
            throw new NotFoundException('Invalid Gemstone');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Gemstone->save($this->request->data)) {
                $this->Session->setFlash('The Gemstone has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Gemstone could not be saved. Please, try again.');
            }
        } else {
            $options = array('conditions' => array('Gemstone.id' => $id));
            $this->request->data = $this->Gemstone->find('first', $options);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Gemstone->id = $id;
        if (!$this->Gemstone->exists()) {
            throw new NotFoundException('Invalid Gemstone');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Gemstone->delete()) {
            $this->Session->setFlash('The Gemstone has been deleted.');
        } else {
            $this->Session->setFlash('The Gemstone could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
