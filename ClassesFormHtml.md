# FormHtml #



## Introduction ##

The FormHtml Class simplifies the tedious task of display form fields and error messages in XHTML. It works directly with the Form.class to display fields with their propper values (whether submitted input, defaults or examples) and possible errors.

Unlike Form.class, FormHtml.class is concerned with the way the elements, labels and errors look in an XHTML page.

For greater flexibility of design, labels, fields (elements) and errors have been split up in to three separate methods, so that they may be placed on a page in any desired manner.

## Example ##
```
<?php
 
// ... PHP template

$label_params = array(
        "class" => "mwlabel",
);
$el_params = array(
        "class" => "mwlongfield",
        "errorclass" => "mwlongfield errors",
);
 
?>

<form name="contactform" action="<?php echo HelperOutput::url($page['path']); ?>" method="post">
 
    <?php echo FormHTML::getLabel('contactform', 'name', $label_params); ?><br />
    <?php echo FormHTML::getElement('contactform', 'name', $el_params); ?>
    <?php echo FormHTML::getError('contactform', 'name'); ?><br /><br />

    <input type="submit" name="submit" value="send" />
</form>
 
<?php

// ... PHP-template

?>
```

## Methods ##

### _getLabel()_ ###
```
string static getLabel( string $formname , string $el_name [, array $params ])
```

Get the label for an element. The method accesses the Form.class and retrieves the label placing it in label tags with the correct "for" attribute. The required marker (set in _i18n as `$form['required_wrapper']`) will be wrapped around the label text._

**Params:**

  * errorclass - the class to be set if there was an user error for the field.
  * errorstyle - the style to be set if there was an user error for the field.
  * value - overwrite the label text with this value
  * hide\_required - don't show the required marker
  * self-defined (1)

(1) All other params will be added as tag attributes. If errorclass or errorstyle are set and there is an error, class and style definitions will be overwritten respectively. If you want the errorclass to add a class, you will need to pass params in the following manner:

```
$param['class'] = "field";
$param['errorclass'] = "field error";
```

### _getElement()_ ###
```
string static getElement( string $formname , string $el_name [, array $params ])
```

Get the XHTML tag(s) for an element. The method accesses the Form.class and and creates the proper tag(s), sets the values (possibly the "example") and relevant attributes. With `param['displaytype']` the input type can be influenced (depending on whether the element is "set" or "single").

**Params:**

  * errorclass - the class to be set if there was a user error for the field.
  * errorstyle - the style to be set if there was a user error for the field.
  * displaytype / dtype - all valid HTML input types plus special types like "checkgroup" and "date" (see below "Display Types")
  * opt\_classes - for use with selectors. An array of classes corresponding to each option.
  * separator - a string that separates or wraps (|) elements for radio and check groups
  * value - set the input value. This is only effective if the form has not been submitted and there is no value already set in the Form.class.
  * self-defined (1)

(1) see comment under getLabel() above.

### _getError()_ ###
```
string static getError( string $formname , string $el_name [, array $params ])
```

Get an eventuall error message for an error that occurred during form validation. If there was no error, an empty string will be returned.
If not otherwise defined, an error message will be wrapped in a `<span>` tag that contains the attribute class="error"

**Params:**

  * tag - the name of the tag wrapping the message (default is "span")
  * class - the class attribute of the tag (default is "error")
  * value - overwrite the error text with this value
  * self-defined - all other params are made into HTML attributes for the wrapping tag.

### example ###
```
// contact form
		$elements['contactform'] = array( "name" => array("required" => true,),);

<form action="~~:url($page.path)~" method="post">
	~~FormHTML::getError( 'contactform' , 'name');
        ~~FormHTML::getLabel('contactform', 'name', array('errorclass' => 'error', 'value' => 'Name'));~:
        ~~FormHTML::getElement('contactform', 'name', array('errorclass' => 'error'));~<br /><br />
</form>
```

### notices ###
"required" controls on/off mode of validation
'~' shortcut for '<?php' and '?>'
'~''~' shortcut for '<?php echo'>

### _getInputImage()_ ###

string static getInputImage( string $el\_name )
returns the path of the file uploaded for field $el\_name. Uploaded files are stored in the session and must not be uploaded again if a form has invalid input.

## Display Types ##

The Form class is not concerned with the appearance of form fields and therefore does not include settings for "radio", "select", "textarea", et cetera. Since the FormHtml class is for generating output, the attribute "displaytype" has an important role.

There are several pre-defined display types:
  * checkbox (a single checkbox)
  * date - a special format that outputs selectors for a date and time which are then stored interally in a string in the format YYYY-mm-dd HH:MM:SS. The following params will influence date:
    * format - strftime-formated string that defines which fields will be available in which order. The default is '%d%m%Y' (strftime() formats for day,month,year,hours, minutes and seconds are allowed)
    * start\_year - What year to start the year-selector with. Value may be a year (YYYY) or an operation (e.g. -18, or +10). Default is the current year minus one.
    * end\_year - What year to end the year-selector with. Value may be a year (YYYY) or an operation (e.g. -18, or +10). Default is the current year plus five.
  * file - a special format that saves uploaded files in the session so that users don't need to choose them again, in case of errors to other fields in the form.
  * group - a special format for outputting groups of choices either as checkboxes (multiple=true) or as radio buttons (multiple=false). Group has the special param _separator_ to define the HTML separating the checkboxes or radio buttons. The following display types are synonymous with "group" if **and only if** your field defintion is type="set" (s. !Form):
    * check
    * checkbox
    * checkgroup
    * checkboxgroup
    * radio
    * radiogroup
  * hidden - a normal hidden field
  * password - a normal password field
  * select - a normal selector (multiple=true|false)
  * text - a normal text field
  * textarea - a normal textarea field

If no display type is defined, "text" is taken by default.

Each display type has its own methods for outputing labels, errors and form fields but also for outputing readonly versions of the fields. For more information about these methods or to learn how to override these function or create your own display types see the section below.


# FormHtmlElement #

## Select ##
```
//view home.htm

~~FormHTML::getError( 'contactform' , 'title');~
~~FormHTML::getLabel('contactform', 'title', array('errorclass' => 'error', 'value' => 'Title'));~:
~~FormHTML::getElement('contactform', 'title', array('errorclass' => 'error', 'displaytype' => 'select'));~<br /><br />

```

## Textarea ##

```

~~FormHTML::getError( 'contactform' , 'message');~
~~FormHTML::getLabel('contactform', 'message', array('errorclass' => 'error', 'value' => 'Message'));~:
~~FormHTML::getElement('contactform', 'message', array('errorclass' => 'error', "displaytype" => "textarea"));~<br /><br />

```

## Password ##

```

~~FormHTML::getError( 'contactform' , 'password');~
~~FormHTML::getLabel('contactform', 'password', array('errorclass' => 'error', 'value' => 'Password'));~:
~~FormHTML::getElement('contactform', 'password', array('errorclass' => 'error', 'displaytype' => 'password'));~<br /><br />

```

## Hidden ##

```

~~FormHTML::getElement('contactform', 'secret', array('errorclass' => 'error', 'displaytype' => 'hidden'));~<br /><br />

```

## File ##

```

~~FormHTML::getError( 'contactform' , 'file');~
~~FormHTML::getLabel('contactform', 'file', array('errorclass' => 'error', 'value' => 'File'));~:
~~FormHTML::getElement('contactform', 'file', array('errorclass' => 'error', 'displaytype' => 'file'));~<br /><br />
        
```

## Date ##

```

~~FormHTML::getError( 'contactform' , 'birthday');~
~~FormHTML::getLabel('contactform', 'birthday', array('errorclass' => 'error', 'value' => 'Birthday'));~:
~~FormHTML::getElement('contactform', 'birthday', array('errorclass' => 'error', 'displaytype' => 'date'));~<br /><br />
        
```

## Checkbox ##

```

~~FormHTML::getError( 'contactform' , 'newsletter');~
~~FormHTML::getLabel('contactform', 'newsletter', array('errorclass' => 'error', 'value' => 'Newsletter'));~:
~~FormHTML::getElement('contactform', 'newsletter', array('errorclass' => 'error', 'displaytype' => 'checkbox'));~<br /><br />

```