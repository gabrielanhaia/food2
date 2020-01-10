<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model implements Auditable
{
    use AuditableTrait, SoftDeletes;

    public function question()
    {
        return $this->belongsTo('\App\Models\Question');
    }

    public function answer()
    {
        return $this->belongsTo('\App\Models\Answer');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
