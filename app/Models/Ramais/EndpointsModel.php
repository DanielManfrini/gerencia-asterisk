<?php

namespace App\Models\Ramais;

use Illuminate\Database\Eloquent\Model;

class EndpointsModel extends Model
{

  protected $connection = 'mysql_asterisk';
  protected $table = 'ps_endpoints';
  protected $primaryKey = 'id';
  public $timestamps = false;
}
