<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Traits\Classic;

use Carbon\Carbon;

trait HasInvitedAtHelpers
{
    /**
     * Set invited flag.
     *
     * @return static
     */
    public function setInvitedFlag()
    {
        $this->setAttribute('invited_at', Carbon::now());

        return $this;
    }

    /**
     * Unset invited flag.
     *
     * @return static
     */
    public function unsetInvitedFlag()
    {
        $this->setAttribute('invited_at', null);

        return $this;
    }

    /**
     * If entity is invited.
     *
     * @return bool
     */
    public function isInvited()
    {
        return !is_null($this->getAttributeValue('invited_at'));
    }

    /**
     * If entity is uninvited.
     *
     * @return bool
     */
    public function isUninvited()
    {
        return !$this->isInvited();
    }

    /**
     * Mark entity as invited.
     *
     * @return void
     */
    public function invite()
    {
        $this->setInvitedFlag()->save();

        $this->fireModelEvent('invited', false);
    }

    /**
     * Mark entity as uninvited.
     *
     * @return void
     */
    public function uninvite()
    {
        $this->unsetInvitedFlag()->save();

        $this->fireModelEvent('uninvited', false);
    }
}
