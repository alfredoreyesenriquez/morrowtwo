# Form #



## Introduction ##

The Form.class allows you to control the flow of your forms more efficiently. Once your form is properly defined, you can choose between several methods to check and handle input or add fields dynamically based on, for example, database queries. Later you can change your definitions without having to touch the controller. To get started using the form class read the introduction to Form Handling.

## Define your form ##

You should know that you have to define all elements of your form separately in the folder _forms_ of your project e.g. _main/forms_. The file you have created in that folder should have the same name like the class and the view which are processing your form.

```
# /main/_forms/home.php

<?php
		
   // contact form
   $elements['contactform'] = array("name" => array("required" => true,),
						     "email" => array("required" => true,
								      "checktype" => "Email",
								     ),
						     "message" => array( "required" => true,),
						     );
```

From that point on you shouldn't forget to extend your definition for every element you wanna use in that form. Otherwise it wouldn't be processed either by the controller nor by the view.

## Example ##

The following demonstrates a simple form handling task.

Let's start with the form in Serpent in a separate view e.g. home.php:

```

<form action="~~:url($page.path)~" method="post">
		~~FormHTML::getError( 'myform' , 'name');
                ~~FormHTML::getLabel('myform', 'name', array('errorclass' => 'error', 'value' => 'Name'));~:
                ~~FormHTML::getElement('myform', 'name', array('errorclass' => 'error'));~<br /><br />
    <input type="submit" name="submit" value="SEND" />
</form>

```

A form is submitted validated and something is done with the data if the input was valid.

```
<?php
// ... Controller-Code
 
$this->form->setInput($this->input->get());
 
if($this -> form -> isSubmitted('myform')) {
        $valid = $this -> form -> validate('myform');
 
        if ($valid) {
                $formdata = $this -> form -> getValues('myform');
                # send mail, save data in database, etc.
                # then show some other contents redirect to another page
                $this->url->redirect('success/');
        }
        else {
                #There was an error, don't do anything else.
        }
}
 
// ... Controller-Code
?>
```

In contrast to define a form separately in a template view, you can also put it in the controller and load it by the function load:

```
<?
// ... Conroller-Code

$elements['contactform'] = array("name" => array("required" => true,),
						   "email" => array("required" => true,),
						   "message" => array("required" => true,),
						  );

$this->form->loadDef($elements);

// ... Controller-Code
?>
```

## Methods (Input and Values) ##

### _setInput()_ ###
```
void setInput( array $input )
```
feed the Form.class the data. Normally this is user input (see Input.class). The Form.class expects each form to have it's own input array. If you use the PHP array input convention "formname[key](key.md)=value" for your input, you will have no other handling to do.

### _getValues()_ ###
```
array getValues( [ string $formname ])
```
returns the values for a form as an array. The element names are the array keys. If **$formname** is not provided, the values of the submitted form (if there is one) will be returned.

### _setValues()_ ###
```
void setValues( string $formname , array $values , [ bool $overwrite = false])
```
Set multiple values. Values are submitted as an associative array, the keys being the field names. If $overwrite is true, all fields that have not been included in the array will be forced to "empty".

### _resetValues()_ ###
```
bool resetValues( [ string $formname ])
```
returns all field values to their default values.
If **$formname** is not set, the "submittedForm" will be used.
The method returns false if $formname is not known or was not set and no form was submitted.

### _clearValues()_ ###
```
bool clearValues( [ string $formname ])
```
Set all values to an empty string.
If **$formname** is not set, the "submittedForm" will be used.
The method returns false if **$formname** is not known or was not set and no form was submitted.

## Methods (Submitted) ##

### _isSubmitted()_ ###
```
bool isSubmitted( )
```
returns true if a form was submitted. Otherwise false.
The Form.class determines whether a form was submitted through the existence of an array with the form name as key containing the input values (see the Method setInput).

### _submittedForm()_ ###
```
string submittedForm( )
```
returns the name of the form that has been submitted.


## Methods (Validating & Error Handling) ##

### _setValidator()_ ###
```
bool setValidator( string $classname )
```
sets the class used for complex validating.
Returns false if **$classname** does not exist and triggers an error.

### _validate()_ ###
```
bool validate( [ string $formname ], [ array $limit ])
```
validates the inputed data according to the criteria define in the the form definition. Returns true if all input is valid, otherwise false.
If **$formname** is not set, the "submittedForm" will be used.

By submitting an array of field names with **$limit**, the validation can be limited to certain fields.

### _hasErrors()_ ###
```
bool hasErrors( [ string $formname ])
```
If validation was not successful and there were errors, this method returns true.
If $formname is not set, the "submittedForm" will be used.


### _getErrors()_ ###
```
array getErrors( [ string $formname ])
```
returns an array containing all of the error messages. The keys of the array are the field names.
If **$formname** is not set, the "submittedForm" will be used.

### _setError()_ ###
```
bool setError( string $formname , string $fieldname , string $errkey )
```
set an error manually (this should be done before validating, so that returns validate() the correct value.

  * $formname
  * $fieldname
  * $errkey: the error "key" (from _i18n $form['errors'])_

returns false if $fieldname does not exist.

## Methods (Manipulating Form fields) ##

### _getElement()_ ###
```
object getElement( string $formname , $fieldname )
```
returns the element object.

### _removeElement()_ ###
```
bool removeElement( string $formname , $fieldname )
```
removes a field (element). returns false if $fieldname does not exist.

### _loadDef()_ ###
```
void loadDef( array $element_def )
```
load a form definition manually. For more about defining forms see
Further Topics: Form Handling.

### _fillSet()_ ###
```
void fillSet( string $formname , string $fieldname , array $sets , [ bool $replaceall =false], [ mixed $default ])
```
dynamically fill a "set" element (e.g. with values from a database).

  * $formname
  * $fieldname
  * $sets: an array of the "options"
  * $replaceall: if true all pre-defined options are removed.
  * $default: the default value(s) as String or Array (for multiple sets).

### _multiplyField()_ ###
```
void multiplyField( string $formname , string $fieldname , array $key_label )
```
multiply a "simple" field (useful for e.g. field in multiple languages).

  * $formname
  * $fieldname
  * $key\_label: an Array in which the key is an appendage to the field name and the value is the text for the label.