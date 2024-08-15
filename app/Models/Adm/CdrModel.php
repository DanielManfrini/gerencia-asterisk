<?php

namespace App\Models\Adm;

use Illuminate\Database\Eloquent\Model;

class CdrModel extends Model
{

  protected $connection = 'mysql_asterisk';
  protected $table = 'cdr';
  protected $primaryKey = 'sequence';
  public $timestamps = false;
  public $filable = [
    'accountcode',
    'src',
    'dst',
    'dcontext',
    'clid',
    'channel',
    'dstchannel',
    'lastapp',
    'lastdata',
    '`start`',
    'answer',
    '`end`',
    'duration',
    'billsec',
    'disposition',
    'amaflags',
    'userfield',
    'uniqueid',
    'linkedid',
    'peeraccount',
    '`sequence`'
  ];

}
