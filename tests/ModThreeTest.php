<?php

namespace Fsm\tests;

use Fsm\FSM;
use PHPUnit\Framework\TestCase;

class ModThreeTest extends TestCase
{
    protected function setUp(): void
    {
        $this->fsm = new FSM(
            ['S0', 'S1', 'S2'],
            ['0', '1'],
            'S0',
            ['S0', 'S1', 'S2'],
            [
                'S0' => ['0' => 'S0', '1' => 'S1'],
                'S1' => ['0' => 'S2', '1' => 'S0'],
                'S2' => ['0' => 'S1', '1' => 'S2'],
            ],
        );
    }

    public function testGenerate(): void
    {
        $modThree = new \Fsm\ModThree("110");
        $this->assertSame("0", $modThree->modThree());
        $modThree = new \Fsm\ModThree("1010");
        $this->assertSame("1", $modThree->modThree());
    }
}