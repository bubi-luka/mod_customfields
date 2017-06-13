<?php
/**
 * @package			Joomla.Site
 * @subpackage		Modules - mod_custom_fields
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
				$html[] = '<p>You can find the id of teh custom field in the <em>Administration menu</em> => <em>Content</em> => <em>Fields</em> => <em>Last column in the table</em>.</p>';
				$html[] = '</div>';
				echo implode('', $html);
				return;
    			break;
    		case 'fieldlist':
    			$html = array();
       			$html[] = '<div class="alert alert-success">';
       			$html[] = '<table>';
       			
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
					$html[] = '<tr><td>{field ' . $row->id . '}</td><td>' . $row->label . '</td><td>' . $row->type . '</td></tr>';
				}
				
       			$html[] = '</table>';
				$html[] = '</div>';
				echo implode('', $html);
				return;
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
	
	protected function getLabel() {}
	
}
