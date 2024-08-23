<?php namespace App\Controllers;
use App\Models\ActionCategoryModel;
use App\Models\CampaignModel;
use App\Models\InfluencerCampaignModel;
use App\Models\CategoryExtModel;
class CampaignController extends BaseController
{
//--------------------------------------------------------------------

	// inicio App
	public function inicio()
	{
		$model=new CampaignModel();
		$datosCategoria = $this->categoryMo();
		$modelInfluCamp = new InfluencerCampaignModel();
		$datas['campaigns']=$model->getAll();
		$id = $this->request->getGet('id');
		if($id){
			if($id){
				$datas['campaign']=$model->getId($id);
			}
		}else{
			$datas['campaign']= 0;
		}

		$datas['categorias'] = $datosCategoria;
		$datas['session'] = session('Id');
		$influCamp = $modelInfluCamp->influCamp($datas);

		if($influCamp){
			$datas['campaigns'] = $this->removeTotalDuplicates($datas['campaigns'], $influCamp);
		}


		return 	view('layouts/header').
				view('layouts/nav').
				view('inicio',  $datas).
				view('layouts/footer');
	}

	public function removeTotalDuplicates($array1, $array2) {
		// Crear un array con los ids de array1 y array2
		$idsArray1 = array_column($array1, 'id');
		$idsArray2 = array_column($array2, 'id');

		// Encontrar los ids duplicados
		$duplicateIds = array_intersect($idsArray1, $idsArray2);

		// Filtrar array1, removiendo los elementos con ids duplicados
		$filteredArray1 = array_filter($array1, function($item) use ($duplicateIds) {
			return !in_array($item['id'], $duplicateIds);
		});

		// Filtrar array2, removiendo los elementos con ids duplicados
		$filteredArray2 = array_filter($array2, function($item) use ($duplicateIds) {
			return !in_array($item['id'], $duplicateIds);
		});

		// Combinar los arrays filtrados
		$mergedArray = array_merge($filteredArray1, $filteredArray2);

		// Reindexar el array combinado
		$mergedArray = array_values($mergedArray);

		return $mergedArray;
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// muestra el contenido de la campaña
	public function campaign(){
		$this->validateAuth();
		$model=new CampaignModel();
		$id = $this->request->getGet('id');

		if($id){
			$datas['campaign']=$model->getId($id);

		}else{
			$datas['campaign']= 0;
		}
		$datas['campaigns']=$model->getAll();
		return 	view('campaign/contenido-caja', $datas);
	}

	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// Crear una campaña
	public function create_view_campaign(){
		$this->validateAuth();
		$datosCategoria = $this->categoryMo();
		$datosSetCat = $this->categorySetMo();
		$datosCategoria_ext = $this->categoryExt();

		return 	view('layouts/header').

				view('layouts/nav').
				view('campaign/registro',['categorias' => $datosCategoria, 'setCat' => false, 'categorias_ext' => $datosCategoria_ext]).
				view('layouts/footer');
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// insertar una campaña
	public function insert_campaign(){

		$this->validateAuth();
		$campaignModelo = new CampaignModel();
		$catModelo = new ActionCategoryModel();

		$IdCompany = session('Id');
		$CName = $this->request->getPost('campana_name');
		$DateFinish = $this->request->getPost('date_campana');
		$CDescription = $this->request->getPost('campana');
		$cat = array();
		$subCat = array();
		$catExt = array();

		$data =[
			'id_company' => $IdCompany,
			'name_camp' => $CName,
			'Description' => $CDescription,
			'date_finish' => $DateFinish,
			'date_create' => date("Y-m-d H:i:s"),
			'active' => '1'
		];

		$insert = $campaignModelo->insertCampaign([$data], 0);
		if(!empty($_POST['inlineCheckbox'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckbox'] as $selected){
				array_push($cat, $selected);
			}
		}
		if(!empty($_POST['inlineCheckboxSub'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckboxSub'] as $selectedSub){
				array_push($subCat, $selectedSub);
			}
		}
		if(!empty($_POST['inlineCheckboxExt'])){
			// Loop to store and display values of individual checked checkbox.
			foreach($_POST['inlineCheckboxExt'] as $selectedSub){
				array_push($catExt, $selectedSub);
			}
		}
		$dataCat =[
			'id_type' => $insert,
			'cat_json' => $cat,
			'sub_json' => $subCat,
			'catExt_json' => $catExt
		];

		$catModelo->updateCat([$dataCat], 2);

		if($insert){
			$msg = 'Campaña creada exitosamente.';
			$alertClass = 'alert-success';
			return redirect()->to(base_url('/crear-campaña'))->with('msg',$msg)->with('alertClass',$alertClass);
		}else{
			$msg = 'La campaña no fue creada';
			$alertClass = 'alert-danger';
			return redirect()->to(base_url('/crear-campaña'))->with('msg',$msg)->with('alertClass',$alertClass);
		}
	}

	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// validar campaña cuando viene del tipo de categoria
	public function inCamp($camp){
		if(!empty($camp)){
			foreach($camp as $selectedCampaing){
				return  $selectedCampaing;
			}
		}
		return false;
	}
	//--------------------------------------------------------------------

	//-
	//--------------------------------------------------------------------
	// buscador de campañas
	public function searchCampaign(){

		$word = $this->request->getGet('q');
		$arrVal = array();
		$model=new CampaignModel();
		$campaingName = $model->getByWord($word);

		foreach ($campaingName as $item) {
			array_push($arrVal, $item);
		}

		$modelCatExt=new CategoryExtModel();
		$catExtId = $modelCatExt->getByWord($word);

		if(!empty($catExtId)){
			$modelCat=new ActionCategoryModel();
			$catId = $modelCat->getById($catExtId);
			if(!empty($catId)){
				foreach ($catId as $item) {
					$campaingName = $model->getId($item['id_type']);
					$val = $this->inCamp($campaingName);
					if (!in_array($val, $arrVal)){
						array_push($arrVal, $val);
					}
				}
			}
		}
		$datas['campaigns']=$arrVal;
		return 	view('campaign/lista-campanas', $datas);
	}
	public function applyCampaign(){

		$this->validateAuth();
		$model=new InfluencerCampaignModel();
		$id = $this->request->getGet('id');

		if($id){
			$data = [
				"id_user_influencer" => session('Id'),
				"id_campaign" => $id,
				"active" => "1",
			];
			$datas['campaign'] = $model->applyId($data, 3);

		}else{
			$datas['campaign'] = 0;
		}
		return 	view('campaign/aplica-campana', $datas);
	}
	public function getInfluencers(){
		$modelInfluCamp = new InfluencerCampaignModel();
		$influCampapplied = $modelInfluCamp->influCampApplied();
		echo '<pre>';
		print_r($influCampapplied);
		exit();
	}
}
