<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Form
 * @package App\Models
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class Form extends Model implements Auditable
{
    use AuditableTrait, SoftDeletes;

    /** @var array $fillable Fillable fields. */
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'description',
        'introduction',
        'start_publish',
        'end_publish',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /** @var array $dates Date fields. */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_publish',
        'end_publish',
    ];

    /**
     * Retorn the author from the form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('\App\Models\User');
    }

    /**
     * Return the list of questions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('\App\Models\Question');
    }
}
