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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class InvitedAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Invite',
        'Uninvite',
        'WithUninvited',
        'WithoutUninvited',
        'OnlyUninvited',
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
        if (method_exists($model, 'shouldApplyInvitedAtScope') && !$model->shouldApplyInvitedAtScope()) {
            return;
        }

        $builder->whereNotNull('invited_at');
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
     * Add the `invite` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addInvite(Builder $builder): void
    {
        $builder->macro('invite', function (Builder $builder) {
            $builder->withUninvited();

            return $builder->update(['invited_at' => Carbon::now()]);
        });
    }

    /**
     * Add the `uninvite` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addUninvite(Builder $builder): void
    {
        $builder->macro('uninvite', function (Builder $builder) {
            return $builder->update(['invited_at' => null]);
        });
    }

    /**
     * Add the `withUninvited` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithUninvited(Builder $builder): void
    {
        $builder->macro('withUninvited', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutUninvited` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutUninvited(Builder $builder): void
    {
        $builder->macro('withoutUninvited', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('invited_at');
        });
    }

    /**
     * Add the `onlyUninvited` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyUninvited(Builder $builder): void
    {
        $builder->macro('onlyUninvited', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('invited_at');
        });
    }
}
