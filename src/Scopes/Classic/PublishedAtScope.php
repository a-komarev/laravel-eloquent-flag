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

namespace Cog\Flag\Scopes\Classic;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Date;

final class PublishedAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Publish',
        'UndoPublish',
        'WithNotPublished',
        'WithoutNotPublished',
        'OnlyNotPublished',
    ];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (!method_exists($model, 'shouldApplyPublishedAtScope') || !$model->shouldApplyPublishedAtScope()) {
            return;
        }

        $builder->whereNotNull('published_at');
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the `publish` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addPublish(Builder $builder): void
    {
        $builder->macro('publish', function (Builder $builder) {
            $builder->withNotPublished();

            return $builder->update(['published_at' => Date::now()]);
        });
    }

    /**
     * Add the `undoPublish` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoPublish(Builder $builder): void
    {
        $builder->macro('undoPublish', function (Builder $builder) {
            return $builder->update(['published_at' => null]);
        });
    }

    /**
     * Add the `withNotPublished` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithNotPublished(Builder $builder): void
    {
        $builder->macro('withNotPublished', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutNotPublished` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutNotPublished(Builder $builder): void
    {
        $builder->macro('withoutNotPublished', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('published_at');
        });
    }

    /**
     * Add the `onlyNotPublished` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyNotPublished(Builder $builder): void
    {
        $builder->macro('onlyNotPublished', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('published_at');
        });
    }
}
