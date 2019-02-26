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

class VerifiedFlagScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Verify',
        'Unverify',
        'WithUnverified',
        'WithoutUnverified',
        'OnlyUnverified',
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
        if (method_exists($model, 'shouldApplyVerifiedFlagScope') && !$model->shouldApplyVerifiedFlagScope()) {
            return;
        }

        $builder->where('is_verified', 1);
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
     * Add the `verify` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addVerify(Builder $builder): void
    {
        $builder->macro('verify', function (Builder $builder) {
            $builder->withUnverified();

            return $builder->update(['is_verified' => 1]);
        });
    }

    /**
     * Add the `unverify` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUnverify(Builder $builder): void
    {
        $builder->macro('unverify', function (Builder $builder) {
            return $builder->update(['is_verified' => 0]);
        });
    }

    /**
     * Add the `withUnverified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithUnverified(Builder $builder): void
    {
        $builder->macro('withUnverified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutUnverified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutUnverified(Builder $builder): void
    {
        $builder->macro('withoutUnverified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_verified', 1);
        });
    }

    /**
     * Add the `onlyUnverified` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyUnverified(Builder $builder): void
    {
        $builder->macro('onlyUnverified', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->where('is_verified', 0);
        });
    }
}
