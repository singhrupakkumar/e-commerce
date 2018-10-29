<?php
App::uses('AppController', 'Controller');
class SeriesController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {
		
        $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array(
                'Series.name' => 'ASC'
            ),
            'limit' => 100,
        );

        $this->set('series', $this->Paginator->paginate('Series'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Series->exists($id)) {
            throw new NotFoundException('Invalid Series');
        }
        $options = array('conditions' => array('Series.id' => $id));
        $this->set('Series', $this->Series->find('first', $options));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Series->create();
            if ($this->Series->save($this->request->data)) {
                $this->Session->setFlash('The Series has been saved.');
                return $this->redirect($this->referer());
                // return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Series could not be saved. Please, try again.');
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Series->exists($id)) {
            throw new NotFoundException('Invalid Series');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Series->save($this->request->data)) {
                $this->Session->setFlash('The Series has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Series could not be saved. Please, try again.');
            }
        } else {
            $options = array('conditions' => array('Series.id' => $id));
            $this->request->data = $this->Series->find('first', $options);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Series->id = $id;
        if (!$this->Series->exists()) {
            throw new NotFoundException('Invalid Series');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Series->delete()) {
            $this->Session->setFlash('The Series has been deleted.');
        } else {
            $this->Session->setFlash('The Series could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
