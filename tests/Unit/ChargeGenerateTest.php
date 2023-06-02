<?php

namespace Tests\Unit;

use App\Jobs\ChargeGenerate;
use Tests\TestCase;

class ChargeGenerateTest extends TestCase
{

    public function test_charge_generate(): void
    {
        $dispatch = dispatch(
            new ChargeGenerate()
        );

        $this->assertTrue($dispatch ? true : false);
    }

}
