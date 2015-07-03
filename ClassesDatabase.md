# Database #



## Introduction ##

For access to databases we use the PHP own PDO (PHP Data Objects). But we extended it a little bit to simplify your everyday life.

## Example ##
```
<?php

// ... Controller code
 
$this->load('db', $this->config->get('db'));
 
// Query with a prepared statement using named placeholder
$sql = $this->db->result('
    SELECT *
    FROM table
    WHERE id = :id
', array('id'=>$this->input->get('id'))
);
 
// Query with a prepared statement using "?" placeholder
// If you just want to pass one parameter you can also pass it directly without using an array
$sql = $this->db->result('
    SELECT *
    FROM table
    WHERE id = ?'
, $this->input->get('id'));
 
dump($sql);
 
// ... Controller code
```

## Methods ##

You have access to all methods as described in the [documentation for PDO](http://www.php.net/manual/en/book.pdo.php). Furthermore we added or rewrote the following methods. In your daily business these methods should work in nearly all cases.

### _`__`construct()_ ###
```
void __construct( array $config )
```
This method overwrites the standard method.
The constructor accepts an array with parameters for specifying the database driver ('mysql', 'sqlite', etc.), the database host, the database name and for the username and password. Usually you define it in the config files of the framework.

The keys for the parameters are 'driver', 'host', 'db', 'user' and 'pass'.

### _connect()_ ###
```
void connect( )
```
Because we added Lazy initialization to PDO you have to call this method if you use PDOs own functions and you have not called any of these methods before.

### _result()_ ###
```
array result( string $query [, array $token = NULL ])
```
This method sends the passed $query to the database.

It returns an array with three keys:
| Key | Type | Description |
|:----|:-----|:------------|
| SUCCESS | bool | true if the query could successfully sent to the db, otherwise false.|
| RESULT | array | The complete result set of the request. |
| NUM\_ROWS | integer | The count of returned results. |

$token is an array for use with a Prepared Statement (security and performance advantages). Take a look at the example for an usage example.

If you prefix a field name in your query with an ">", then this column value will be used as key for the result set instead of a numerically indexed array. This way you will get an array which can be easily accessed via an unique key.

```
$sql = $this->db->Result('
    SELECT *, >id
    FROM table
');
```
You must only use fields with the ">" operator whose values are unique. Otherwise all rows with the same field value will become one row.

### _result\_calc\_found\_rows()_ ###
```
array result_calc_found_rows( string $query [, array $token = NULL ])
```
The same as result(), but with the difference that an additional key "FOUND\_ROWS" contains the count of rows if you had left out the LIMIT in your query.

| Only for MySQL. |
|:----------------|

### _insert()_ ###
```
mixed insert( string $table , array $data [, bool $insertid = false])
```
This method inserts a new entry into the table $table. Every key in the array $data represents a field in the table.

It is also possible to pass an array with the key FUNC as value. In that case it will not been sent as string but as expression.
```
<?php

// ... Controller-Code
 
$data = array(
    'foo' => 'bar',
    'foo2' => array('FUNC' => 'foo2+1')
);
$this->db->insert('table', $data, true);
 
// ... Controller-Code
```

It returns an array with one or two keys:
| Key | Type | Description |
|:----|:-----|:------------|
| SUCCESS | bool | true if the query could successfully sent to the db, otherwise false. |
| INSERT\_ID | string | If the parameter $insertid is set to true, this key contains the value of the primary key of the new entry. |

### _insertSafe()_ ###
```
mixed insertSafe( string $table , array $data [, bool $insertid = false])
```
The same as insert(), but with the difference that keys, that do not have a corresponding fields in the database table, will be deleted. So it is made sure that there is always sent a valid query.

This method is slower than insert(), because all field names of the target table has to be figured out with a second query.

### _replace()_ ###
```
mixed replace( string $table , array $data [, bool $insertid = false])
```
This method inserts a new entry into the table $table or updates an entry if the key already exists. Every key in the array $data represents a field in the table.

It is also possible to pass an array with the key "FUNC" as value. In that case it will not been sent as string but as expression.

```
<?php
// ... Controller-Code
 
$data = array(
        'foo' => 'bar',
        'foo2' => array('FUNC' => 'foo2+1')
);
$this->db->replace('table', $data, true);
 
// ... Controller-Code
?>
```

It returns an array with one or two keys:

| Key | Type | Description |
|:----|:-----|:------------|
| SUCCESS | bool | true if the query could successfully sent to the db, otherwise false. |
| INSERT\_ID | string | If the parameter $insertid is set to true, this key contains the value of the primary key of the new entry. |

### _replaceSafe()_ ###
```
mixed replaceSafe( string $table , array $data [, bool $insertid = false])
```
The same as replace(), but with the difference that keys, that do not have a corresponding fields in the database table, will be deleted. So it is made sure that there is always sent a valid query.

This method is slower than replace(), because all field names of the target table has to be figured out with a second query.

### _update()_ ###
```
mixed update( string $table , array $data [, string $where = '' [, bool $affected_rows = false [, array $where_tokens = array ( )]]])
```
Updates data in the table $table. Every key in the array $data represents a field in the table.

It is also possible to pass an array with the key FUNC as value. In that case it will not been sent as string but as expression.

$where\_tokens is an array (or a scalar) for use as a Prepared Statement in the where clause. Take a look at the example for an usage example.
Only question marks are allowed for the token in the where clause. You cannot use the colon syntax.

```
<?php

// ... Controller-Code
 
$data = array(
    'foo' => 'bar',
    'foo2' => array('FUNC' => 'foo2+1')
);
$this->db->update($table, $data, 'where id = ?', true, 1);
 
// ... Controller-Code
```

It returns an array with one or two keys:
| Key | Type | Description |
|:----|:-----|:------------|
| SUCCESS | bool | true if the query could successfully sent to the db, otherwise false. |
| AFFECTED\_ROWS | string | If the parameter $affected\_rows is set to true, this key contains the count of the affected rows. |

### _updateSafe()_ ###
```
mixed updateSafe( string $table , array $data [, string $where = '' [, bool $affected_rows = false [, array $where_tokens = false]]])
```
The same as update(), but with the difference that keys, that do not have a corresponding fields in the database table, will be deleted. So it is made sure that there is always sent a valid query.

This method is slower than update(), because all field names of the target table has to be figured out with a second query.


### _delete()_ ###
```
array delete( string $table, string $where = '' [, bool $affected_rows = false [, array $where_tokens = array () ]])
```
Deletes data from the table $table specified by $where.

$where\_tokens is an array (or a scalar) for use as a Prepared Statement in the where clause. Take a look at the example for an usage example.
Only question marks are allowed for the token in the where clause. You cannot use the colon syntax.

```
$this->db->delete($table, 'where id = ?', true, 1);
```