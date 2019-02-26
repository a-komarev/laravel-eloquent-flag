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

trait HasPublishedAtHelpers
{
    /**
     * Set published flag.
     *
     * @return static
     */
    public function setPublishedFlag()
    {
        $this->setAttribute('published_at', Carbon::now());

        return $this;
    }

    /**
     * Unset published flag.
     *
     * @return static
     */
    public function unsetPublishedFlag()
    {
        $this->setAttribute('published_at', null);

        return $this;
    }

    /**
     * If entity is published.
     *
     * @return bool
     */
    public function isPublished()
    {
        return !is_null($this->getAttributeValue('published_at'));
    }

    /**
     * If entity is unpublished.
     *
     * @return bool
     */
    public function isUnpublished()
    {
        return !$this->isPublished();
    }

    /**
     * Mark entity as published.
     *
     * @return void
     */
    public function publish()
    {
        $this->setPublishedFlag()->save();

        $this->fireModelEvent('published', false);
    }

    /**
     * Mark entity as unpublished.
     *
     * @return void
     */
    public function unpublish()
    {
        $this->unsetPublishedFlag()->save();

        $this->fireModelEvent('unpublished', false);
    }
}
