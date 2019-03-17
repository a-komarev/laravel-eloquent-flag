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

namespace Cog\Flag\Scopes\Inverse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Date;

final class ExpiredAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'UndoExpire',
        'Expire',
        'WithExpired',
        'WithoutExpired',
        'OnlyExpired',
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
        if (method_exists($model, 'shouldApplyExpiredAtScope') && !$model->shouldApplyExpiredAtScope()) {
            return;
        }

        $builder->whereNull('expired_at');
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
     * Add the `undoExpire` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUndoExpire(Builder $builder): void
    {
        $builder->macro('undoExpire', function (Builder $builder) {
            $builder->withExpired();

            return $builder->update(['expired_at' => null]);
        });
    }

    /**
     * Add the `expire` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addExpire(Builder $builder): void
    {
        $builder->macro('expire', function (Builder $builder) {
            return $builder->update(['expired_at' => Date::now()]);
        });
    }

    /**
     * Add the `withExpired` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithExpired(Builder $builder): void
    {
        $builder->macro('withExpired', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutExpired` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutExpired(Builder $builder): void
    {
        $builder->macro('withoutExpired', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('expired_at');
        });
    }

    /**
     * Add the `onlyExpired` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyExpired(Builder $builder): void
    {
        $builder->macro('onlyExpired', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('expired_at');
        });
    }
}
