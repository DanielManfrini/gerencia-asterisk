<?php

namespace App\Models\Uras;

use Illuminate\Database\Eloquent\Model;

class ExtensionsModel extends Model{

    protected $connection = 'mysql_asterisk';
    protected $table = 'extensions';
    protected $primaryKey = 'id';
    public $timestamps = false;

}

