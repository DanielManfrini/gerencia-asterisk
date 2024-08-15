<?php

namespace App\Models\Ramais;

use Illuminate\Database\Eloquent\Model;

class AorsModel extends Model
{

  protected $connection = 'mysql_asterisk';
  protected $table = 'ps_aors';
  protected $primaryKey = 'id';
  public $timestamps = false;
}
