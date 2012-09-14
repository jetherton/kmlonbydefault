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
				//for 2.4 backward compatibility. At some point this should be deprecated and removed
				$map .= "if(typeof switchLayer == 'function'){switchLayer('".$layer->id."',"; 
				$map .= "'".url::base().Kohana::config('upload.relative_directory')."/".$layer->layer_file."',";
				$map .= "'".$layer->layer_color."'); }\r\n";	
				//for 2.5 compatibility
				$map .= "else if (typeof map.addLayer == 'function') {";
				$map .= 'map.addLayer(Ushahidi.KML, {name: "'.$layer->layer_name.'", url: "json/layer/'.$layer->id.'"});';
				//add the active class
				$map .='$("ul#kml_switch a#layer_'.$layer->id.'").addClass("active");}';
				$map .= "\r\n";
			}
		}
		$map .= '});</script>';
		Event::$data = $map;
	}
	
}//end class

new kmlonbydefault;