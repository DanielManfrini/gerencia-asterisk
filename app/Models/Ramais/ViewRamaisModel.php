<?php

namespace App\Models\Ramais;

use Illuminate\Database\Eloquent\Model;

class ViewRamaisModel extends Model
{

  protected $connection = 'mysql_asterisk';
  protected $table = 'vw_ramais';
  protected $primaryKey = 'id';
  public $timestamps = false;
}
