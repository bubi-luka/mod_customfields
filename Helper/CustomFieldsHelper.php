<?php
/**
 * Custom Fields Everywhere Entry Point
 * 
 * @package    Module Custom Fields
 * @subpackage Module
 * @license    GNU General Public License version 3; see LICENSE.txt
 * @link       https://github.com/bubi-luka/mod-custom-fields
 * Custom Fields Everywhere (mod_customfields) is free software. This 
 * version may have been modified pursuant to the GNU General 
 * Public License, and as distributed it includes or is derivative 
 * of works licensed under the GNU General Public License or other 
 * free or open source software licenses.
 */


namespace Joomla\Module\CustomFields\Site\Helper;

// No direct access to this file
defined('_JEXEC') or die;

// Load library Factory for database access
use Joomla\CMS\Factory;

class CustomFieldsHelper {

	// Get values from custom fields for articles
	public static function getArticleId($articleId) {
		// Obtain a database connection
		$db = Factory::getDbo();
		
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
	
	// Get values from custom fields for author
	public static function getAuthorId($authorId) {
		// Obtain a database connection
		$db = Factory::getDbo();
		
		// Get the values for all the custom fields for this article
		$query = $db->getQuery(true)
				    ->select($db->quoteName(array('field_id','value')))
				    ->from($db->quoteName('#__fields_values'))
				    ->where('item_id = '. $db->Quote($authorId));
		
		// Prepare the query
		$db->setQuery($query);
		
		// Load results
		$result = $db->loadObjectList();
  	
		// Paste results to the tmpl
		return $result;
	}

	// Get values from custom fields for articles and users
	public static function getFields() {
		// Obtain a database connection
		$db = Factory::getDbo();
		
		// Get the data for all active custom fields
		$query = $db->getQuery(true)
				    ->select($db->quoteName(array('id', 'context', 'label', 'type', 'fieldparams')))
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

