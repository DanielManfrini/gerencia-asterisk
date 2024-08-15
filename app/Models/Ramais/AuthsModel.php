<?php

namespace App\Models\Ramais;

use Illuminate\Database\Eloquent\Model;

class AuthsModel extends Model
{

  protected $connection = 'mysql_asterisk';
  protected $table = 'ps_auths';
  protected $primaryKey = 'id';
  public $timestamps = false;
}
