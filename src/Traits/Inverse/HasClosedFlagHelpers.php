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

trait HasClosedFlagHelpers
{
    /**
     * Set closed flag.
     *
     * @return static
     */
    public function setClosedFlag()
    {
        $this->setAttribute('is_closed', true);

        return $this;
    }

    /**
     * Unset closed flag.
     *
     * @return static
     */
    public function unsetClosedFlag()
    {
        $this->setAttribute('is_closed', false);

        return $this;
    }

    /**
     * If entity is closed.
     *
     * @return bool
     */
    public function isClosed()
    {
        return (bool) $this->getAttributeValue('is_closed');
    }

    /**
     * If entity is opened.
     *
     * @return bool
     */
    public function isOpened()
    {
        return !$this->isClosed();
    }

    /**
     * Mark entity as closed.
     *
     * @return void
     */
    public function close()
    {
        $this->setClosedFlag()->save();

        $this->fireModelEvent('closed', false);
    }

    /**
     * Mark entity as opened.
     *
     * @return void
     */
    public function open()
    {
        $this->unsetClosedFlag()->save();

        $this->fireModelEvent('opened', false);
    }
}
