<?php
//Base URL of the website
$config['base_url']	= "http://musiter.localhost/";

//Database DSN
$config['dsn'] = 'mysql://root:@localhost/dbo';

//Website language
$config['language']	= "english";

//Mu Server name
$config['server_name']	= "MuKiTo";

//Keywords (separated with comma)
$config['keywords']	= "mukito, mu online, private server";

//Template to be used
$config['template']	= "default.css";

//Server IP
$config['server_ip']	= "127.0.0.1";

//Server Port
$config['server_port']	= "44405";

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


// Database tables
// Don't change these unless you have a good reason to

//Character table
$config['t_character'] = 'Character';
//Mem_stat table
$config['t_memb_stat'] = 'MEMB_STAT';
//Guild table
$config['t_guild'] = 'guild';
//Guildmember table
$config['t_guildmember'] = 'guildmember';
//Memb_info table
$config['t_memb_info'] = 'MEMB_INFO';
?>
