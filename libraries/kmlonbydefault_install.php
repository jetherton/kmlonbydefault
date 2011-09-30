<?php
/**
 * KML on by default - Install
 *
 * @author	   John Etherton
 * @package	   KML on By Default
 */

class kmlonbydefault_Install {

	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db = Database::instance();
	}

	/**
	 * Creates the required database tables for the actionable plugin
	 */
	public function run_install()
	{
		// Create the database tables.
		// Also include table_prefix in name
		$this->db->query('CREATE TABLE IF NOT EXISTS `'.Kohana::config('database.default.table_prefix').'kmlonbydefault` (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `layer_id` int(10) unsigned NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
		
		
	}

	/**
	 * Deletes the database tables for the actionable module
	 */
	public function uninstall()
	{
		
		$this->db->query('DROP TABLE `'.Kohana::config('database.default.table_prefix').'kmlonbydefault`');
	}
}