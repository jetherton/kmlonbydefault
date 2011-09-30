<?php defined('SYSPATH') or die('No direct script access.');
/**
 *  KML on by Default - sets up the hooks
 *
 * @author	   John Etherton
 * @package	   KML on by Default
 */

class kmlonbydefault {
	
	/**
	 * Registers the main event add method
	 */
	 
	 
	public function __construct()
	{
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
		
			
		// Set Table Prefix
		$this->table_prefix = Kohana::config('database.default.table_prefix');		

	}
	
	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
		Event::add('ushahidi_filter.map_main', array($this, 'add_js'));
		
	}
	
	/**
	 * Adds in the JavaScript to turn on the KML layers
	 */
	public function add_js()
	{
		$map = Event::$data;
		$map .= '<script type="text/javascript">$(document).ready(function() {';
		//figure out what KML layers to turn on
		$layers = ORM::factory("layer")			
				->select("layer.*, kmlonbydefault.id as kmlonbydefault_id")
				->join("kmlonbydefault", "layer.id", "kmlonbydefault.layer_id", "LEFT")
				->where("layer.layer_visible", "1")
				->find_all();
		foreach($layers as $layer)
		{
			if($layer->kmlonbydefault_id != null)
			{
				$map .= "switchLayer('".$layer->id."',";
				$map .= "'".url::base().Kohana::config('upload.relative_directory')."/".$layer->layer_file."',";
				$map .= "'".$layer->layer_color."'); ";	
			}
		}
		$map .= '});</script>';
		Event::$data = $map;
	}
	
}//end class

new kmlonbydefault;