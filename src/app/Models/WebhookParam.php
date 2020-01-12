<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WebhookParam
 * @package App\Models
 *
 * @author Gabriel Anhaia <anhaia.gabriel@gmail.com>
 */
class WebhookParam extends Model
{
    /** @var string $table Table name. */
    protected $table = 'webhook_params';

    /** @var array $fillable Fillable fields. */
    protected $fillable = [
        'id',
        'weebhook_url_id',
        'name',
        'value',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
