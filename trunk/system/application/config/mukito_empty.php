<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * Mukito configuration file
 * 
 */

$config['verson'] = '0.1';

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
//Database connection
$config['dsn'] = 'mysql://root:@localhost/dbo';
