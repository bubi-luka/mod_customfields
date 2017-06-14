<?php
/**
 * Custom Fields Module Entry Point
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
 
// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

// Get the article ID
$input = JFactory::getApplication()->input;
$articleId = $input->getInt('id');

// Die if not on and article
if ( $input->get('view') != "article" ) {
	return;
}

// Send the id to helper for processing article related custom fields
$sendIdToHelper = modCustomFieldsHelper::getId($articleId);

// Get all the custom fields on the page
$sendFieldsToHelper = modCustomFieldsHelper::getFields();

// Use input from settings to display and design the selected fields on the module
$getFieldsParams = $params->get('editorFields');
$sendParamsToHelper = modCustomFieldsHelper::getParams($getFieldsParams);

require JModuleHelper::getLayoutPath('mod_customfields');

