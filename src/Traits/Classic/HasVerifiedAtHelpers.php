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

trait HasVerifiedAtHelpers
{
    /**
     * Set verified flag.
     *
     * @return static
     */
    public function setVerifiedFlag()
    {
        $this->setAttribute('verified_at', Carbon::now());

        return $this;
    }

    /**
     * Unset verified flag.
     *
     * @return static
     */
    public function unsetVerifiedFlag()
    {
        $this->setAttribute('verified_at', null);

        return $this;
    }

    /**
     * If entity is verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return !is_null($this->getAttributeValue('verified_at'));
    }

    /**
     * If entity is unverified.
     *
     * @return bool
     */
    public function isUnverified()
    {
        return !$this->isVerified();
    }

    /**
     * Mark entity as verified.
     *
     * @return void
     */
    public function verify()
    {
        $this->setVerifiedFlag()->save();

        $this->fireModelEvent('verified', false);
    }

    /**
     * Mark entity as unverified.
     *
     * @return void
     */
    public function unverify()
    {
        $this->unsetVerifiedFlag()->save();

        $this->fireModelEvent('unverified', false);
    }
}
