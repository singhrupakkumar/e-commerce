<?php
App::uses('AppController', 'Controller');
class ThemesController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array(
                'Theme.name' => 'ASC'
            ),
            'limit' => 100,
        );

        $this->set('Theme', $this->Paginator->paginate('Theme'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Theme->exists($id)) {
            throw new NotFoundException('Invalid Theme');
        }
        $options = array('conditions' => array('Theme.id' => $id));
        $this->set('Theme', $this->Theme->find('first', $options));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Theme->create();
            if ($this->Theme->save($this->request->data)) {
                $this->Session->setFlash('The Theme has been saved.');
                return $this->redirect($this->referer());
                // return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Theme could not be saved. Please, try again.');
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Theme->exists($id)) {
            throw new NotFoundException('Invalid Theme');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Theme->save($this->request->data)) {
                $this->Session->setFlash('The Theme has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Theme could not be saved. Please, try again.');
            }
        } else {
            $options = array('conditions' => array('Theme.id' => $id));
            $this->request->data = $this->Theme->find('first', $options);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Theme->id = $id;
        if (!$this->Theme->exists()) {
            throw new NotFoundException('Invalid Theme');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Theme->delete()) {
            $this->Session->setFlash('The Theme has been deleted.');
        } else {
            $this->Session->setFlash('The Theme could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
