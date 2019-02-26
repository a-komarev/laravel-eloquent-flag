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

namespace Cog\Flag\Traits\Inverse;

use Cog\Flag\Scopes\Inverse\ArchivedAtScope;

trait HasArchivedAtScope
{
    /**
     * Boot the HasArchivedAtScope trait for a model.
     *
     * @return void
     */
    public static function bootHasArchivedAtScope(): void
    {
        static::addGlobalScope(new ArchivedAtScope);
    }
}
