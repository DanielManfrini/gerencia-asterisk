<?php

namespace App\Models\Filas;

use Illuminate\Database\Eloquent\Model;

class QueueRulesModel extends Model
{

    protected $connection = 'mysql_asterisk';

    protected $table = 'queue_rules';

    protected $primaryKey = 'rule_name';

    protected $fillable = [
        'rule_name',
        'time',
        'min_penalty',
        'max_penalty'
    ];

    public $timestamps = false;
}
