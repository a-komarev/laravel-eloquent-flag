<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Traits\Classic;

use Carbon\Carbon;
use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithApprovedAt;
use Cog\Flag\Tests\TestCase;

/**
 * Class HasApprovedAtHelpersTest.
 *
 * @package Cog\Flag\Tests\Unit\Traits\Classic
 */
class HasApprovedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_approved_flag()
    {
        $entity = factory(EntityWithApprovedAt::class, 1)->create([
            'approved_at' => null,
        ]);

        $entity->setApprovedFlag();

        $this->assertNotNull($entity->approved_at);
    }

    /** @test */
    public function it_can_unset_approved_flag()
    {
        $entity = factory(EntityWithApprovedAt::class, 1)->create([
            'approved_at' => Carbon::now(),
        ]);

        $entity->unsetApprovedFlag();

        $this->assertNull($entity->approved_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_approved()
    {
        $approvedEntity = factory(EntityWithApprovedAt::class, 1)->create([
            'approved_at' => Carbon::now(),
        ]);

        $disapprovedEntity = factory(EntityWithApprovedAt::class, 1)->create([
            'approved_at' => null,
        ]);

        $this->assertTrue($approvedEntity->isApproved());
        $this->assertFalse($disapprovedEntity->isApproved());
    }

    /** @test */
    public function it_can_check_if_entity_is_disapproved()
    {
        $approvedEntity = factory(EntityWithApprovedAt::class, 1)->create([
            'approved_at' => Carbon::now(),
        ]);

        $disapprovedEntity = factory(EntityWithApprovedAt::class, 1)->create([
            'approved_at' => null,
        ]);

        $this->assertFalse($approvedEntity->isDisapproved());
        $this->assertTrue($disapprovedEntity->isDisapproved());
    }

    /** @test */
    public function it_can_approve_entity()
    {
        $entity = factory(EntityWithApprovedAt::class, 1)->create([
            'approved_at' => null,
        ]);

        $entity->approve();

        $this->assertNotNull($entity->approved_at);
    }

    /** @test */
    public function it_can_disapprove_entity()
    {
        $entity = factory(EntityWithApprovedAt::class, 1)->create([
            'approved_at' => Carbon::now(),
        ]);

        $entity->disapprove();

        $this->assertNull($entity->approved_at);
    }
}
