How to install MuKiTo

# Introduction #

Yo install MuKiTo, you'll need WEB server (Apache or any other supporting php) and Mu Online database running on SQL Server or MySQL.

# Details #

Place the source code somewhere in the webroot (htdocs);
You need to manually (for now) configure two of the files:

## system/application/config/database.php ##

`$db['default']['hostname'] = "MuOnline";`

This is the DSN name for the database in case you're using SQL Server or the database server name if you're using MySQL

`$db['default']['username'] = "sa";`

Database's user

`$db['default']['password'] = "secret";`

Database's password

`$db['default']['database'] = "";`

Database's name for MySQL (leave empty for MsSQL)

`$db['default']['dbdriver'] = "odbc";`

What database will be used. The options are **odbc** and **mysql**

## system/application/config/mukito.php ##

```
//Base URL of the website
$config['base_url']	= "http://musiter.localhost/";

//Website language
$config['language']	= "english";

//Mu Server name
$config['server_name']	= "MuKiTo";

//Keywords (separated with comma)
$config['keywords']	= "mukito, mu online, private server";

//Template to be used
$config['template']	= "default.css";

//Game Master control code
$config['gm_ctlcode']	= 32;

//Reset money
$config['resetmoney'] = 10;

//Reset money
$config['resetpoints'] = 10;

//Reset level
$config['resetlevel'] = 3;

//Maximum Reset level
$config['resetlimit'] = 150;

//PK money
$config['pkmoney'] = 20000;

//Reset mode [keep;reset]
$config['resetmode'] = 'reset';

//Level Up mode [normal;extra]
$config['levelupmode'] = 'normal';

//Clean Inventory [yes;no]
$config['clean_inventory'] = 'no';

//Clean Skills [yes;no]
$config['clean_skills'] = 'no';
```