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

namespace Cog\Tests\Flag\Stubs\Models\Inverse;

class EntityWithEndedAtUnapplied extends EntityWithEndedAt
{
    /**
     * Determine if EndedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyEndedAtScope(): bool
    {
        return false;
    }
}
