<?php
App::uses('AppController', 'Controller');
class StylesController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array(
                'Style.name' => 'ASC'
            ),
            'limit' => 100,
        );

        $this->set('Style', $this->Paginator->paginate('Style'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Style->exists($id)) {
            throw new NotFoundException('Invalid Style');
        }
        $options = array('conditions' => array('Style.id' => $id));
        $this->set('Style', $this->Style->find('first', $options));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Style->create();
            if ($this->Style->save($this->request->data)) {
                $this->Session->setFlash('The Style has been saved.');
                return $this->redirect($this->referer());
                // return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Style could not be saved. Please, try again.');
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Style->exists($id)) {
            throw new NotFoundException('Invalid Style');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Style->save($this->request->data)) {
                $this->Session->setFlash('The Style has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Style could not be saved. Please, try again.');
            }
        } else {
            $options = array('conditions' => array('Style.id' => $id));
            $this->request->data = $this->Style->find('first', $options);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Style->id = $id;
        if (!$this->Style->exists()) {
            throw new NotFoundException('Invalid Style');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Style->delete()) {
            $this->Session->setFlash('The Style has been deleted.');
        } else {
            $this->Session->setFlash('The Style could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
