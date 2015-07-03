# Mail #



## Introduction ##

To send mails we extended the external class PHPMailer (available at http://phpmailer.codeworxtech.com ).

## Example ##
**Controller-Code:**
```
<?php
// ... Controller-Code
 
$vars['subject']        = 'I am just a Subject';
$vars['copy']           = 'Now, I am a mail copy text.';
 
// create HTML version of the mail
$this->load('view:view_html');
$this->view_html->setHandler('serpent');
$this->view_html->setProperty('template', '_mailer/newsletter_html');
$this->view_html->setContent($vars);
$view_html = $this->view_html->get();
 
// create text version of the mail
$this->load('view:view_text');
$this->view_text->setHandler('serpent');
$this->view_text->setProperty('template', '_mailer/newsletter_text');
$this->view_text->setContent($vars);
$view_text = $this->view_text->get();
 
// send mail
$this->load('mail', $this->config->get('mail'));
$this->mail->Subject = 'Just a dummy subject';
$this->mail->AddAddress('test@domain.com');
$this->mail->Body = stream_get_contents($view_html['content']);
$this->mail->AltBody = stream_get_contents($view_text['content']);
$this->mail->Send(false);
 
// ... Controller-Code
?>
```

_**mailer/newsletter\_html.htm**
```
<html>
<head>
        <title>~~:escape($content.subject)</title>
</head>
 
<body>
 
~~:escape($content.copy)~
 
</body>
</html>
```_

_**mailer/newsletter\_text.htm**
```
---------------------------------------------------------------------
~~:escape($content.subject)~
---------------------------------------------------------------------
 
~~:escape($content.copy)~
```_

## Methods ##

You have access to all methods the original PHPMailer provides. Furthermore we added or rewrote the following methods.

### _`__`construct()_ ###
```
object __construct( array $config )
```
This method overwrites the standard method.
The constructor accepts an array with parameters for overwriting standard parameters of PHPMailer.

### _send()_ ###
```
bool send( [ bool $confirm = false] )
```
This method overwrites the standard method.
We extended the original method with the additional parameter $confirm.
Set $confirm to true if you really want to send the mail. If set to false the method will output a dump of all important parameters for the mail delivery. Return TRUE on success an FALSE on failure.