<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Model;

class Form extends Model implements Auditable
{
    use AuditableTrait, SoftDeletes;

    public function author()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function questions()
    {
        return $this->hasMany('\App\Models\Question');
    }
}
