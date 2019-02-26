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

class KeptFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Keep',
        'Unkeep',
        'WithUnkept',
        'WithoutUnkept',
        'OnlyUnkept',
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
        $builder->where('is_kept', 1);
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
     * Add the `keep` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addKeep(Builder $builder): void
    {
        $builder->macro('keep', function (Builder $builder) {
            $builder->withUnkept();

            return $builder->update(['is_kept' => 1]);
        });
    }

    /**
     * Add the `unkeep` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUnkeep(Builder $builder): void
    {
        $builder->macro('unkeep', function (Builder $builder) {
            return $builder->update(['is_kept' => 0]);
        });
    }

    /**
     * Add the `withUnkept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithUnkept(Builder $builder): void
    {
        $builder->macro('withUnkept', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutUnkept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutUnkept(Builder $builder): void
    {
        $builder->macro('withoutUnkept', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_kept', 1);
        });
    }

    /**
     * Add the `onlyUnkept` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyUnkept(Builder $builder): void
    {
        $builder->macro('onlyUnkept', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_kept', 0);
        });
    }
}
