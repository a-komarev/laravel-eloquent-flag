<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Stubs\Models\Classic;

use Cog\Flag\Traits\Classic\HasApprovedAt;
use Illuminate\Database\Eloquent\Model;

class EntityWithApprovedAt extends Model
{
    use HasApprovedAt;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity_with_approved_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'approved_at' => 'datetime',
    ];
}
