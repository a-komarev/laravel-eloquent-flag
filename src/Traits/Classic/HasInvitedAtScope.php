<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Flag\Traits\Classic;

use Cog\Flag\Scopes\Classic\InvitedAtScope;

trait HasInvitedAtScope
{
    /**
     * Boot the HasInvitedAtScope for a model.
     *
     * @return void
     */
    public static function bootHasInvitedAtScope(): void
    {
        static::addGlobalScope(new InvitedAtScope);
    }
}
