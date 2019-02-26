<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits\Inverse;

use Carbon\Carbon;

trait HasDraftedAtHelpers
{
    /**
     * Set drafted flag.
     *
     * @return static
     */
    public function setDraftedFlag()
    {
        $this->setAttribute('drafted_at', Carbon::now());

        return $this;
    }

    /**
     * Unset drafted flag.
     *
     * @return static
     */
    public function unsetDraftedFlag()
    {
        $this->setAttribute('drafted_at', null);

        return $this;
    }

    /**
     * If entity is drafted.
     *
     * @return bool
     */
    public function isDrafted()
    {
        return !is_null($this->getAttributeValue('drafted_at'));
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isUndrafted()
    {
        return !$this->isDrafted();
    }

    /**
     * Mark entity as drafted.
     *
     * @return void
     */
    public function draft()
    {
        $this->setDraftedFlag()->save();

        $this->fireModelEvent('drafted', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function undraft()
    {
        $this->unsetDraftedFlag()->save();

        $this->fireModelEvent('undrafted', false);
    }
}
