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
 
	// No direct access
	defined('_JEXEC') or die;

	// circle through whole output of all custom fields
	foreach( $sendFieldsToHelper as $row ) {
		// custom field is about the article content
		if ( $row->context == "com_content.article" ) {
			// for those fields that have params only for the design of the backend entry fields we left the param array empty
			if ( $row->type == "text" OR $row->type == "media" OR $row->type == "editor" OR $row->type == "integer" ) {
				$strFields[] = array(
					"id" => $row->id,
					"label" => $row->label,
					"type" => $row->type,
					"param" => "",
					"context" => "article",
					);
			}
			// for those fields that store actual values in the params field we extract those values into an array and fill it to the param array
			else if ( $row->type == "checkboxes" OR $row->type == "radio" ) {
				$strParam = json_decode($row->fieldparams);
				
				$arrOptions = [];
				foreach ( $strParam->options as $key => $value ) {
					$arrOptions[$value->value] = $value->name;
				}
				
				$strFields[] = array(
					"id" => $row->id,
					"label" => $row->label,
					"type" => $row->type,
					"param" => $arrOptions,
					"context" => "article",
				);
			}
		}
		// custom field is about the article author
		else if ( $row->context == "com_users.user" ) {
			$strFields[] = array(
				"id" => $row->id,
				"label" => $row->label,
				"type" => $row->type,
				"param" => "",
				"context" => "user",
				);
		}
	}
	
	// for easier representation we isolate only one column - label indexed by id
	$arrLabels = array_column($strFields, 'label', 'id');
	// for easier representation we isolate only one column - array of parameters indexed by id
	$arrValues = array(array_column($strFields, 'param', 'id'));
	// for easier representation we isolate only one column - type indexed by id
	$arrTypes = array_column($strFields, 'type', 'id');
	
	$arrArticleFields = [];
	
	// circle through content of in the article defined values
	foreach ( $sendIdToHelper as $row ) {
		// replace numerical value with its label
		if ( !empty($arrValues[0][$row->field_id][$row->value]) ) {
			$strFieldValue = $arrValues[0][$row->field_id][$row->value];
		}
		else {
			$strFieldValue = $row->value;
		}
	
		// if there are multiple instances of the same field (aka radio, checkbox), we add the value to the rest of them
		if ( !empty($arrLabels[$row->field_id]) ) {
			if ( array_key_exists($arrLabels[$row->field_id], $arrArticleFields) ) {
				$arrArticleFields[$arrLabels[$row->field_id]] = $arrArticleFields[$arrLabels[$row->field_id]] . ", " . $strFieldValue;
			}
			// if there is only one value of the same field
			else {
				$arrArticleFields[$arrLabels[$row->field_id]] = $strFieldValue;
			}
		}
	}
	
	// circle through content of the article author custom fields
	foreach ( $sendAuthorToHelper as $row ) {
		// replace numerical value with its label
		if ( !empty($arrValues[0][$row->field_id][$row->value]) ) {
			$strFieldValue = $arrValues[0][$row->field_id][$row->value];
		}
		else {
			$strFieldValue = $row->value;
		}
	
		// if there are multiple instances of the same field (aka radio, checkbox), we add the value to the rest of them
		if ( !empty($arrLabels[$row->field_id]) ) {
			if ( array_key_exists($arrLabels[$row->field_id], $arrArticleFields) ) {
				$arrArticleFields[$arrLabels[$row->field_id]] = $arrArticleFields[$arrLabels[$row->field_id]] . ", " . $strFieldValue;
			}
			// if there is only one value of the same field
			else {
				$arrArticleFields[$arrLabels[$row->field_id]] = $strFieldValue;
			}
		}
	}

	// display the content of the editor in the module
	$strContent = $sendParamsToHelper;
	$strNewContent = $strContent;
	$len = 0;

	for ( $i=0; $i < substr_count($strContent, "{field "); $i++ ) {
		// Get field ID from the shortcodes
		$fieldId = substr($strContent, strpos($strContent, "{field ", $len) + 7, strpos($strContent, "}", $len) - strpos($strContent, "{field ", $len) - 7);
		
		// Set custom field label and values variable
		$strFieldValue = "";
		$strFieldName = "";

		// Check if field label and values actually exists for this article
		if (!empty($arrArticleFields[$arrLabels[$fieldId]])) {
			// Get custom field label and values for this shortcode
			$strFieldValue = $arrArticleFields[$arrLabels[$fieldId]];
			$strFieldName = $arrLabels[$fieldId];

			// Check if field type is media - insert HTML image code
			if ( $arrTypes[$fieldId] == "media" ) {
				$strFieldValue = "<img src='/" . $strFieldValue . "' alt='" . $strFieldName . "' />";
			}
			
			// Check if field actually exists
			if ( array_key_exists($fieldId, $arrLabels) ) {
				// replace shortcode with field value
				$strNewContent = str_replace("{field " . $fieldId . "}", $strFieldValue . " ", $strNewContent);
			}
		
		}
		
		// Let's move to the next field
		$len = strpos($strContent, "}", $len) + 1;
		
	}
	
	// Display content without shortcodes
	echo $strNewContent;
	
?>
