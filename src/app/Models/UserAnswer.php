<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAnswer
 * @package App\Models
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class UserAnswer extends Model implements Auditable
{
    use AuditableTrait, SoftDeletes;

    /**
     * Return the question answered.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('\App\Models\Question');
    }

    /**
     * Return the answer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function answer()
    {
        return $this->belongsTo('\App\Models\Answer');
    }

    /**
     * Return the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
