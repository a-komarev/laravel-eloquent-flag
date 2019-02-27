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

trait HasPublishedFlagHelpers
{
    public function initializeHasPublishedFlagHelpers(): void
    {
        $this->casts['is_published'] = 'boolean';
    }

    /**
     * Set published flag.
     *
     * @return static
     */
    public function setPublishedFlag()
    {
        $this->setAttribute('is_published', true);

        return $this;
    }

    /**
     * Unset published flag.
     *
     * @return static
     */
    public function unsetPublishedFlag()
    {
        $this->setAttribute('is_published', false);

        return $this;
    }

    /**
     * If entity is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->getAttributeValue('is_published');
    }

    /**
     * If entity is unpublished.
     *
     * @return bool
     */
    public function isUnpublished(): bool
    {
        return !$this->isPublished();
    }

    /**
     * Mark entity as published.
     *
     * @return void
     */
    public function publish(): void
    {
        $this->setPublishedFlag()->save();

        $this->fireModelEvent('published', false);
    }

    /**
     * Mark entity as unpublished.
     *
     * @return void
     */
    public function unpublish(): void
    {
        $this->unsetPublishedFlag()->save();

        $this->fireModelEvent('unpublished', false);
    }
}
