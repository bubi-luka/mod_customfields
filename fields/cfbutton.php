<?php
/**
 * Custom Fields Everywhere
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

defined('_JEXEC') or die;

class JFormFieldCfbutton extends JFormField {

	protected $type = 'cfbutton';

	protected function getInput() { 
	
    	$html = array();
		$html[] = '<div>';

		$html[] = '<a href="#modal-customFields" class="btn btn-warning" data-toggle="modal">Click to add a custom field</a>';
		
		$params = array();
		$params['title']  = "Add a shortcode of the desired custom field";
		$params['height'] = "400";
		$params['width'] = "70%";
    
		$windowCode = array();
		$windowCode[] = '<script>function insertShortcode(num) {';
		$windowCode[] = 'tinyMCE.activeEditor.execCommand("mceInsertContent", false, "{field " + num + "}");';
		$windowCode[] = 'jQuery("#modal-customFields").modal("hide");';
		$windowCode[] = '}</script>';

		$windowCode[] = '<table class="table">';
		$windowCode[] = '<thead>';
		$windowCode[] = '<tr>';
		$windowCode[] = '<th width="10%" class="nowrap center">Field ID</th>';
		$windowCode[] = '<th class="title">Field Name</th>';
		$windowCode[] = '<th width="20%" class="nowrap hidden-phone">Field Group</th>';
		$windowCode[] = '<th width="10%" class="nowrap hidden-phone">Field Type</th>';
		$windowCode[] = '</tr>';
		$windowCode[] = '</thead>';

		// Obtain a database connection
		$db = JFactory::getDbo();
		
		// Get data for all active custom fields
		$query = $db->getQuery(true)
					->select($db->quoteName(array('id', 'label', 'type', 'fieldparams', 'group_id')))
					->from($db->quoteName('#__fields'))
					->where('state = 1');
						
		// Prepare the query
		$db->setQuery($query);
		
		// Load results
		$resultFields = $db->loadObjectList();
		
		// Get data for custom fields groups
		$query = $db->getQuery(true)
					->select($db->quoteName(array('id', 'title')))
					->from($db->quoteName('#__fields_groups'));
						
		// Prepare the query
		$db->setQuery($query);
		
		// Load results
		$resultGroups = $db->loadObjectList();
		
		$groups = array();
		
		foreach( $resultGroups as $row ) {	
			$groups[$row->id] = $row->title;
		}
		
		foreach( $resultFields as $row ) {			
			$windowCode[] = '<tr>';
			$windowCode[] = '<td class="center">' . $row->id . '</td>';
			$windowCode[] = '<td class="has-context"><a class="btn btn-small btn-block btn-success" href="javascript:void(0);" onclick="insertShortcode(' . $row->id . ');" data-dismiss="modal">' . $row->label . '</a></td>';
			if ( $row->group_id != '0' ) {
				$windowCode[] = '<td class="small hidden-phone"><span class="btn btn-small btn-block btn-warning" href="javascript:void(0);">' . $groups[$row->group_id] . '</span></td>';
			}
			else {
				$windowCode[] = '<td class="small hidden-phone"></td>';
			}
			$windowCode[] = '<td class="small hidden-phone">'  . $row->type . '</td>';
			$windowCode[] = '</tr>';
		}		
		
		$windowCode[] = '</table>';
		
		$html[] = JHTML::_("bootstrap.renderModal", "modal-customFields", $params, implode('', $windowCode));
		$html[] = '</div>';
		return implode('', $html);

	}
	
}
