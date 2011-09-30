<?php defined('SYSPATH') or die('No direct script access.');
/**
 * KML on by Default - Administrative Controller
 *
 * @author	   John Etherton
 * @package	   KML on by Default
 */

class Kmlonbydefault_settings_Controller extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'settings';

		// If this is not a super-user account, redirect to dashboard
		if(!$this->auth->logged_in('admin') && !$this->auth->logged_in('superadmin'))
		{
			url::redirect('admin/dashboard');
		}
	}
	
	public function index()
	{
		
		$this->template->content = new View('kmlonbydefault/kmlonbydefault_admin');
		$form_saved = false;
		
		
		// check, has the form been submitted if so check the input values and save them
		if ($_POST)
		{
			//blow away all curently selected layers in the database		
			ORM::factory("kmlonbydefault")->delete_all();
			
			//get the list of layers
			$layers = ORM::factory("layer")			
				->select("layer.*, kmlonbydefault.id as kmlonbydefault_id")
				->join("kmlonbydefault", "layer.id", "kmlonbydefault.layer_id", "LEFT")
				->where("layer.layer_visible", "1")
				->find_all();
				
			//check and see if any of these were selected
			foreach($layers as $layer)
			{
				if(isset($_POST["layer_".$layer->id]))
				{
					//it's set so add it
					$kmlobd = ORM::factory("kmlonbydefault");
					$kmlobd->layer_id = $layer->id;
					$kmlobd->save();
				}
			}
		}
		
		//get the list of layers for display to the user
		$layers = ORM::factory("layer")			
				->select("layer.*, kmlonbydefault.id as kmlonbydefault_id")
				->join("kmlonbydefault", "layer.id", "kmlonbydefault.layer_id", "LEFT")
				->where("layer.layer_visible", "1")
				->find_all();
				
		$this->template->content->layers = $layers;
		$this->template->content->form_saved = $form_saved;		
		
	}//end index method
	
	

	
}