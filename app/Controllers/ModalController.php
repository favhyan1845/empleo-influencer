<?php namespace App\Controllers;

use CodeIgniter\Controller;

class ModalController extends BaseController
{
    public function index()
    {
        return view('layouts/modal/modal_view');
    }

    public function loadModalContent()
    {
        // Obtener el parámetro 'id' de la solicitud
        $id = $this->request->getVar('id');
        
        // Aquí puedes hacer consultas a la base de datos o procesar el dato como necesites
        // Por ejemplo, obtener datos de una base de datos usando el ID
        // $model = new \App\Models\SomeModel();
        // $data = $model->find($id);
        
        // Para este ejemplo, solo pasaremos el ID a la vista
        return view('modal_content', ['id' => $id]);
    }
}
