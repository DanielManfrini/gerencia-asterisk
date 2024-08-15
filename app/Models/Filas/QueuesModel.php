<?php

namespace App\Models\Filas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QueuesModel extends Model
{

  protected $connection = 'mysql_asterisk';

  protected $table = 'queues';

  protected $primaryKey = 'id';

  protected $fillable = [
    'name',
    'musiconhold',
    'retry',
    'strategy'
  ];

  public $timestamps = false;

}
