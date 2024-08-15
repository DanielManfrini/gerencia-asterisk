<?php

namespace App\Models\Ramais;

use Illuminate\Database\Eloquent\Model;

class ContextModel extends Model
{
  protected $connection = 'mysql_asterisk';
  protected $table = 'context';
  protected $primaryKey = 'ContextId';
  public $timestamps = false;
}
