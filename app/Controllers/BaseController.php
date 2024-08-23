<?php
namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\CategoryExtModel;
use App\Models\ActionCategoryModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'html'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		helper('operadores');
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}


	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// validar autenticacion activa
	public function validateAuth(){
		session();
		if(empty(session('Id')) || session('Id') == "" ){
			return $this->response->redirect(site_url('/'));
		}
		return true;
	}

	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// Index o home del sitio
	public function index()
	{

		$message = session('mensaje');
		return 	view('layouts/header', ['message' => $message]).
				view('layouts/nav').
				view('home').
				view('layouts/footer');
	}

	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// obtener todas las categorias
	public function categoryMo(){
		$categoriaModelo = new categoryModel();
		return $categoriaModelo->getAll();
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// obtener todas las categorias Externas
	public function categoryExt(){
		$categoriaModelo = new categoryExtModel();
		return $categoriaModelo->getAll();
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// obtener el id de la categoria
	public function categorySetMo(){
		$setCatModelo = new ActionCategoryModel();
		return $setCatModelo->getId(['id_type' => session('Id')]);
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// vista del editar perfil del usuario
	public function subcategory(){
		$categoriaModelo = new categoryModel();
		$subcategorias = $categoriaModelo->getAllSubcategory($_POST['id']);

		$datosSetCat = $this->categorySetMo();

		if($datosSetCat){
			return view('categorias/subcategoria',['subcategorias' => $subcategorias]);
		}else{

			if(!$datosSetCat){
				$datosSetCategoria = false;
			}else{
				$datosSetCategoria = json_decode($datosSetCat[0]['cat_json'],true);
			}

			return view('categorias/subcategoria',['subcategorias' => $subcategorias, 'setSubCat' => $datosSetCategoria]);
		}
	}

	public function btn_generator($name){
		return '<button class="btn btn-outline-dark btn-lg fs-6 col-md-2 fw-bolder d-inline-flex p-2 bd-highlight">'. $name .'</button>';
	}
	public function btn_generator_a($name, $action){
		return '<a href ="'.$action.'" class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder d-inline-flex p-2 bd-highlight">'.$name.'</a>';
	}
	public function base64Decode($encodedStr) {
		// Using base64_decode() function to decode the Base64 encoded string
		return base64_decode($encodedStr);
	}
}
