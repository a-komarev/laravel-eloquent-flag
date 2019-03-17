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

namespace Cog\Tests\Flag\Unit\Traits\Inverse;

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithExpiredAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

final class HasExpiredAtHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_expired_at_to_datetime(): void
    {
        $entity = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => '1986-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->expired_at);
        $this->assertSame('1986-03-28 00:00:00', $entity->expired_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_check_if_entity_is_expired(): void
    {
        $expiredEntity = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => Date::now(),
        ]);

        $unexpiredEntity = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => null,
        ]);

        $this->assertTrue($expiredEntity->isExpired());
        $this->assertFalse($unexpiredEntity->isExpired());
    }

    /** @test */
    public function it_can_check_if_entity_is_not_expired(): void
    {
        $expiredEntity = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => Date::now(),
        ]);

        $unexpiredEntity = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => null,
        ]);

        $this->assertFalse($expiredEntity->isNotExpired());
        $this->assertTrue($unexpiredEntity->isNotExpired());
    }

    /** @test */
    public function it_can_expire_entity(): void
    {
        $entity = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => null,
        ]);

        $entity->expire();

        $this->assertNotNull($entity->expired_at);
    }

    /** @test */
    public function it_can_unexpire_entity(): void
    {
        $entity = factory(EntityWithExpiredAt::class)->create([
            'expired_at' => Date::now(),
        ]);

        $entity->unexpire();

        $this->assertNull($entity->expired_at);
    }
}
