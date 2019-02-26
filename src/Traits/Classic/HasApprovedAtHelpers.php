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

trait HasApprovedAtHelpers
{
    /**
     * Set approved flag.
     *
     * @return static
     */
    public function setApprovedFlag()
    {
        $this->setAttribute('approved_at', Carbon::now());

        return $this;
    }

    /**
     * Unset approved flag.
     *
     * @return static
     */
    public function unsetApprovedFlag()
    {
        $this->setAttribute('approved_at', null);

        return $this;
    }

    /**
     * If entity is approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return !is_null($this->getAttributeValue('approved_at'));
    }

    /**
     * If entity is disapproved.
     *
     * @return bool
     */
    public function isDisapproved()
    {
        return !$this->isApproved();
    }

    /**
     * Mark entity as approved.
     *
     * @return void
     */
    public function approve()
    {
        $this->setApprovedFlag()->save();

        $this->fireModelEvent('approved', false);
    }

    /**
     * Mark entity as disapproved.
     *
     * @return void
     */
    public function disapprove()
    {
        $this->unsetApprovedFlag()->save();

        $this->fireModelEvent('disapproved', false);
    }
}
