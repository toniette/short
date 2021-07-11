<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Link
 *
 * @property int $id
 * @property int $user_id
 * @property int $hits
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Query\Builder|Link onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereHits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Link withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Link withoutTrashed()
 * @mixin \Eloquent
 */
class Link extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'url',
        'hits',
        'user_id'
    ];

    protected $attributes = [
        'hits' => 0
    ];

    protected $appends = [
        'shortUrl'
    ];

    protected $visible = [
        'id',
        'url',
        'hits',
        'shortUrl'
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return parent::belongsTo(User::class);
    }

    public function getShortUrlAttribute(): string
    {
        return route('links.redirect', ['id' => $this->id]);
    }
}
