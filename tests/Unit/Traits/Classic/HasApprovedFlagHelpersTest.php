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

namespace Cog\Tests\Flag\Unit\Traits\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithApprovedFlag;
use Cog\Tests\Flag\TestCase;

final class HasApprovedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_casts_is_approved_to_boolean(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => 1,
        ]);

        $this->assertTrue($entity->is_approved);
    }

    /** @test */
    public function it_not_casts_is_approved_to_boolean(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->make([
            'is_approved' => null,
        ]);

        $this->assertNull($entity->is_approved);
    }

    /** @test */
    public function it_can_set_approved_flag(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        $entity->setApprovedFlag();

        $this->assertTrue($entity->is_approved);
    }

    /** @test */
    public function it_can_unset_approved_flag(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        $entity->unsetApprovedFlag();

        $this->assertFalse($entity->is_approved);
    }

    /** @test */
    public function it_can_check_if_entity_is_approved(): void
    {
        $approvedEntity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        $disapprovedEntity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        $this->assertTrue($approvedEntity->isApproved());
        $this->assertFalse($disapprovedEntity->isApproved());
    }

    /** @test */
    public function it_can_check_if_entity_is_disapproved(): void
    {
        $approvedEntity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        $disapprovedEntity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        $this->assertFalse($approvedEntity->isDisapproved());
        $this->assertTrue($disapprovedEntity->isDisapproved());
    }

    /** @test */
    public function it_can_approve_entity(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => false,
        ]);

        $entity->approve();

        $this->assertTrue($entity->is_approved);
    }

    /** @test */
    public function it_can_disapprove_entity(): void
    {
        $entity = factory(EntityWithApprovedFlag::class)->create([
            'is_approved' => true,
        ]);

        $entity->disapprove();

        $this->assertFalse($entity->is_approved);
    }
}
