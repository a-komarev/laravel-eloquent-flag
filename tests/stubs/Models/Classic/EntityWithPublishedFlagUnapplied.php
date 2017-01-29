<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Stubs\Models\Classic;

/**
 * Class EntityWithPublishedFlagUnapplied.
 *
 * @package Cog\Flag\Tests\Stubs\Models\Classic
 */
class EntityWithPublishedFlagUnapplied extends EntityWithPublishedFlag
{
    /**
     * Determine if PublishedFlagScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyPublishedFlagScope()
    {
        return false;
    }
}
