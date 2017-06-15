<?php
/**
 * Helper class for Custom Fields Module
 * 
 * @package    Module Custom Fields
 * @subpackage Module
 * @license    GNU/GPL, see LICENSE.php
 * @link       https://github.com/bubi-luka/mod-custom-fields
 * Module Custom Fields (mod_custom_fields) is free software. This 
 * version may have been modified pursuant to the GNU General 
 * Public License, and as distributed it includes or is derivative 
 * of works licensed under the GNU General Public License or other 
 * free or open source software licenses.
 */
	
class ModCustomFieldsHelper {
	// Get values from custom fields for the article
	public static function getId($articleId) {
		// Obtain a database connection
		$db = JFactory::getDbo();
		
		// Get the values for all the custom fields for this article
		$query = $db->getQuery(true)
				    ->select($db->quoteName(array('field_id','value')))
				    ->from($db->quoteName('#__fields_values'))
				    ->where('item_id = '. $db->Quote($articleId));
		
		// Prepare the query
		$db->setQuery($query);
		
		// Load results
		$result = $db->loadObjectList();
    	
		// Paste results to the tmpl
		return $result;
	}
	
	// Get values from custom fields for the article
	public static function getFields() {
		// Obtain a database connection
		$db = JFactory::getDbo();
		
		// Get the data for all active custom fields
		$query = $db->getQuery(true)
				    ->select($db->quoteName(array('id', 'label', 'type', 'fieldparams')))
				    ->from($db->quoteName('#__fields'))
				    ->where('state = 1');
		
		// Prepare the query
		$db->setQuery($query);
		
		// Load results
		$result = $db->loadObjectList();
    	
		// Paste results to the tmpl
		return $result;
	}
	
	// Use input from settings to display and design the selected fields on the module
	public static function getParams($getFieldsParams) {
	
		$result = $getFieldsParams;
		return $result;
	}

}

