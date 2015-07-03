# Session #



## Introduction ##

The class for accessing the user session with methods for getting, setting and deleting content. The Session.Class utilizes dot.syntax.
The Session.Class is always initialized by Morrow and the use of the PHP global variable **$`_`SESSION is not possible**.

Session is not interested in the way sessioning is handled by PHP and uses whatever is the default setting (usually PHP saves to the file system). The Session class can be extended to take care of different session handling methods. Morrow provides a class for saving sessions in the database: DBSession. This can also be used as an example for defining one's own session handling.

## Example ##
```
<?php
// ... Controller code
 
// fictive order form stepping process
$last_step = $this->session->get("basket.step");
 
if($last_step == null) {
        $last_step = 0;
}
 
$step = $last_step+1;
 
$this->session->set("basket.step", $step);
 
// ... Controller code
?>
```

## Methods ##

### _get()_ ###
```
void get( [ String $identifier = null])
```
returns the contents of the session for the key **$identifier** or entire contents if no argument is given.

### _set()_ ###
```
void set( String $identifier , String $value )
```
Sets the value of **$identifer**. If it does not exist it will be created.

### _delete()_ ###
```
void delete( [ String $identifier = null])
```
Removes the **$identifier** from the session. If no argument is given, the entire session will be emptied.

## DBSession ##
DBSession class extends Session and is used in exactly the same way. The difference is that the session data is stored in a database. Therefore a database table must be created and the database configuration must be communicated to the DBSession class as in the example below.
In Order to use the DBSession class, Morrow must be informed of the handler. This is done by setting **session.handler** to 'dbsession';

### Config ###
```
<?php
// ... Config code
 
$config['session.handler']   = 'dbsession';
 
$config['session.db.driver']    = 'mysql';
$config['session.db.host']      = 'localhost';
$config['session.db.db']        = 'morrow';
$config['session.db.user']      = 'morrow_user';
$config['session.db.pass']      = '';
$config['session.db.table']     = 'sessions';
 
 // ... Config code
?>
```

### Table Structure ###
The name of the table is variable and must be set in the configuration as session.db.table. The necessary columns are fixed and are:

  * **session\_id:** Primary key, characters (length: 32)
  * **session\_data:** text/characters
  * **session\_expiration:** timestamp/date-time

**Example for MySql**
```
create table `sessions` (
                  `session_id` varchar(32) not null default '',
                  `session_data` text not null,
                  `session_expiration` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
                  primary key  (`session_id`)
                ) ENGINE=MyISAM;
```