<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WebhookUrls
 * @package App\Models
 */
class WebhookUrl extends Model
{
    /** @var string $table Table name. */
    protected $table = 'webhook_urls';

    /** @var array $fillable Fillable fields. */
    protected $fillable = [
        'id',
        'weebhook_id',
        'url',
        'type',
        'enabled',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function webHookParams()
    {
        return $this->hasMany(WebhookParam::class, 'webhook_url_id', 'id');
    }
}
