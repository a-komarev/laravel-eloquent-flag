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

trait HasActiveFlagHelpers
{
    public function initializeHasActiveFlagHelpers(): void
    {
        $this->casts['is_active'] = 'boolean';
    }

    public function isActivated(): bool
    {
        return $this->getAttributeValue('is_active');
    }

    public function isNotActivated(): bool
    {
        return !$this->isActivated();
    }

    public function activate(): void
    {
        $this->setAttribute('is_active', true);
        $this->save();

        $this->fireModelEvent('activated', false);
    }

    public function deactivate(): void
    {
        $this->save();
        $this->setAttribute('is_active', false);

        $this->fireModelEvent('deactivated', false);
    }
}
