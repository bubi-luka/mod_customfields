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

class JFormFieldCfmessage extends JFormField {

	protected $type = 'cfmessage';

	protected function getInput() {
		$label = $this->element['label'] ? (string) $this->element['label'] : '';
		$message = $this->element['message'] ? (string) $this->element['message'] : '';
    	
    	switch ($message) {
    		case 'instructions':
    			$html = array();
       			$html[] = '<div class="alert alert-info">';
				$html[] = '<p>The shortcode is constructed as "{field ID}. The ID is the number, id of the custom field that we want to show.</p>';
				$html[] = '<p>You can find the id of the custom field in the <em>Administration menu</em> => <em>Content</em> => <em>Fields</em> => <em>Last column in the table</em>.</p>';
				$html[] = '</div>';
				return implode('', $html);;
    			break;
    		case 'fieldlist':
    			$html = array();
       			$html[] = '<div class="alert alert-success">';
       			$html[] = '<p>Underneath is a list of all the shortcodes with coresponding custom field names and types.</p>';
       			$html[] = '<table>';
				$html[] = '<thead>';
				$html[] = '<tr>';
				$html[] = '<th width="20%" class="nowrap center">Field ID</th>';
				$html[] = '<th class="title">Field Name</th>';
				$html[] = '<th width="30%" class="nowrap hidden-phone">Field Group</th>';
				$html[] = '<th width="20%" class="nowrap hidden-phone">Field Type</th>';
				$html[] = '</tr>';
				$html[] = '</thead>';
       			
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
				
				foreach( $result as $row ) {
					$html[] = '<tr>';
					$html[] = '<td>{field ' . $row->id . '}</td>';
					$html[] = '<td>' . $row->label . '</td>';
					$html[] = '<td></td>';
					$html[] = '<td>' . $row->type . '</td>';
					$html[] = '</tr>';
				}
				
       			$html[] = '</table>';
				$html[] = '</div>';
				
				return implode('', $html);
    			break;
    		default:
    			$style = 'border: 1px solid #BBBBBB; background-color: #F1F1F1; ';
    			$text_title = '';
    			$text_message = JText::_($label);
    			break;
		}
		
		$html = array();
		$html[] = '<div style="clear:left;"></div>';
		$html[] = '<div style="'.$style.'max-width: 500px; margin: 5px 0; padding: 5px 10px; border-radius: 5px; font-size:12px;">';
		$html[] = '<strong style="color:#303030;">';
		$html[] = $text_title;
		$html[] = '</strong>';
		$html[] = $text_message;
		$html[] = '</div>';
		
		return implode('', $html);
	}
	
}
