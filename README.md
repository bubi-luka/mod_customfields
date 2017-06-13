# Custom Fields Module
**Display custom fields of an Joomla article in a module.**

## Description

## Installation

Save the archive (zip, tar.gz) of the latest module version to your computer or directlly on the server. Use Joomla! build in mechanism to extract and istall the module. Do not forget to **activate** it in order to use it. One version of the module will be already created in the Module section.

## Usage

Use the WYSIWYG editor to enter the content you would like to be displayed in the module. In place you would like to use the content of the custom field you use the shortcode for the field. The shortcode is '{field ID}'. The ID is the id (number) of the custom field and can be found in the 'Administration Menu -> Content -> 'Fields -> Last column of the fields table'.

*Example: {field 11}*

**Warning: _If there is no field with the given id, the shortcode will be displayed unchanged!_**

## Roadmap
### 0.4.*
- module displays the list of available custom fields in the backend

### 0.5.*
- module has a backend modal field,
- this modal field has the content of all the custom fields,
- user can with a click on a button select desired custom field and put the shortcode in the editor field.

### 0.6.*
- modal field has the option to use both the label and the data for custom fields,
- editor field has modified shortcode to contain option to display the label or not,
- module can parse the new shortcode and display label or not.

### 0.7.*
- module conforts with user levels and on the frontend displays only the levels that are visible to this user <= might already be included with the Joomla! system

### 1.0.0
- final release, nothing new
---
## Change Log
### 0.3.*
- module has a backend editor field, where users can enter the code to display in the frontend,
- module can find the shortcode for the fields,
- module can parse the shortcode for the fields,
- module can display the content of the editor field with data from custom fields.

### 0.2.0
- working module, but not really usable,
- reading the database,
- reading custom fields data,
- manipulating custom fields data,
- reading custom fields belonging to the article,
- manipulating the stored input of the article,
- displaying all the fields that are part of the article in the module.

### 0.1.0
- initial release,
- most of the file structure is in place,
- no working code,
- module is not usable.
