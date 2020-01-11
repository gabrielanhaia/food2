<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * @package App\Models
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class Question extends Model implements Auditable
{
    use AuditableTrait, SoftDeletes;

    /** @var array $fillable Fillable fields. */
    protected $fillable = [
        'id',
        'form_id',
        'description',
        'mandatory',
        'type',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /** @var array $dates Date fields. */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Return the form related to the question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo('\App\Models\Form');
    }

    /**
     * Return the list of answers for each question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('\App\Models\Answer');
    }

    /**
     * Return the list of users and answers related to the question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany]
     */
    public function usersAnswers()
    {
        return $this->hasMany('\App\Models\UserAnswer');
    }
}
