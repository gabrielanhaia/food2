<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Webhook
 * @package App\Models
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class Webhook extends Model
{
    /** @var array $fillable Fillable fields. */
    protected $fillable = [
        'id',
        'scope',
        'action',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
