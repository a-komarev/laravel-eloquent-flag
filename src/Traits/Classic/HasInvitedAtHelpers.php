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

use Illuminate\Support\Facades\Date;

trait HasInvitedAtHelpers
{
    public function initializeHasInvitedAtHelpers(): void
    {
        $this->dates[] = 'invited_at';
    }

    public function isInvited(): bool
    {
        return !is_null($this->getAttributeValue('invited_at'));
    }

    public function isNotInvited(): bool
    {
        return !$this->isInvited();
    }

    public function invite(): void
    {
        $this->setAttribute('invited_at', Date::now());
        $this->save();

        $this->fireModelEvent('invited', false);
    }

    public function uninvite(): void
    {
        $this->setAttribute('invited_at', null);
        $this->save();

        $this->fireModelEvent('uninvited', false);
    }
}
