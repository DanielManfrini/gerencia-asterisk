<?php

namespace App\Models\Filas;

use Illuminate\Database\Eloquent\Model;

class QueueMembersModel extends Model
{

    protected $connection = 'mysql_asterisk';
    protected $table = 'queue_members';
    protected $primaryKey = 'uniqueid';
    public $timestamps = false;
    public $filable = [
        'queue_name',
        'interface',
        'membername',
        'state_interface'
    ];

    public function get()
    {

        return self::get()->toArray();
    }
}
