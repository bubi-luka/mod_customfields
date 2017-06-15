<?php
/**
 * @package			Joomla.Site
 * @subpackage		Modules - mod_custom_fields
 */

defined('_JEXEC') or die;

class JFormFieldCfbutton extends JFormField {

	protected $type = 'cfbutton';

	protected function getInput() {

    	$html = array();
		$html[] = '<div>';

		$html[] = '<script>function insertShortcode(num) {';
		$html[] = 'tinyMCE.activeEditor.execCommand( "mceInsertContent", false, "{field " + num + "}" );';
		$html[] = '}</script>';

		$html[] = '<table class="table table-striped">';
		$html[] = '<thead>';
		$html[] = '<tr>';
		$html[] = '<th width="10%" class="nowrap center">Field ID</th>';
		$html[] = '<th class="title">Ime polja</th>';
		$html[] = '<th width="20%" class="nowrap hidden-phone">Skupina</th>';
		$html[] = '<th width="10%" class="nowrap hidden-phone">Tip</th>';
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
			$html[] = '<td class="center">' . $row->id . '</td>';
			$html[] = '<td class="has-context"><a class="btn btn-small btn-block btn-success" href="javascript:void(0);" onclick="insertShortcode(' . $row->id . ');">' . $row->label . '</a></td>';
			$html[] = '<td class="small hidden-phone"><span class="btn btn-small btn-block btn-warning" href="javascript:void(0);">Test</span></td>';
			$html[] = '<td class="small hidden-phone">'  . $row->type . '</td>';
			$html[] = '</tr>';				
					
			// {field ' . $row->id . '}</td><td>' . $row->label . '</td><td>' . $row->type . '</td></tr>';
		}		
		
		$html[] = '</table>';
		$html[] = '</div>';
		echo implode('', $html);
		return;

	}
	
	protected function getLabel() {}
	
}
