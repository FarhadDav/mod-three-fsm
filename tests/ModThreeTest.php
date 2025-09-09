<?php
declare(strict_types=1);

namespace Fsm\tests;

use Fsm\FSM;
use PHPUnit\Framework\TestCase;

class ModThreeTest extends TestCase
{
    private array  $states;
    private array  $alphabet;
    private string $initialState;
    private array  $finalStates;
    private array  $transitionFunction;
    private FSM $fsm;
    protected function setUp(): void
    {
        $this->states = ['S0', 'S1', 'S2'];
        $this->alphabet = ['0', '1'];
        $this->initialState = 'S0';
        $this->finalStates = ['S0', 'S1', 'S2'];
        $this->transitionFunction = [
            'S0' => ['0' => 'S0', '1' => 'S1'],
            'S1' => ['0' => 'S2', '1' => 'S0'],
            'S2' => ['0' => 'S1', '1' => 'S2'],
        ];
        $this->fsm = new FSM(
            $this->states,
            $this->alphabet,
            $this->initialState,
            $this->finalStates,
            $this->transitionFunction,
        );
    }

    public function testGenerate(): void
    {
        $modThree = new \Fsm\ModThree();
        $this->assertSame("0", $modThree->modThree("110"));
        $this->assertSame("1", $modThree->modThree("1010"));
        $this->assertSame("0", $modThree->modThree("000"));
        $this->assertSame("1", $modThree->modThree("111"));
    }

    public function testEmptyInput(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $modThree = new \Fsm\ModThree();
        $modThree->modThree("");
    }

    public function testInvalidInput(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $modThree = new \Fsm\ModThree();
        $modThree->modThree("heythere");
    }

    public function testInvalidFSMInitialState(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->fsm = new FSM(
            $this->states,
            $this->alphabet,
            "S4",
            $this->finalStates,
            $this->transitionFunction,
        );
    }

    public function testInvalidFSMFinalState(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->fsm = new FSM(
            $this->states,
            $this->alphabet,
            $this->initialState,
            ["S5"],
            $this->transitionFunction,
        );
    }

    public function testInvalidFSMTransitionState(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->fsm = new FSM(
            $this->states,
            $this->alphabet,
            $this->initialState,
            $this->finalStates,
            [
                'S6' => ['0' => 'S0', '1' => 'S1'],
                'S1' => ['0' => 'S2', '1' => 'S0'],
                'S2' => ['0' => 'S1', '1' => 'S2'],
            ],
        );
    }

    public function testInvalidFSMTransitionSymbol(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->fsm = new FSM(
            $this->states,
            $this->alphabet,
            $this->initialState,
            $this->finalStates,
            [
                'S0' => ['3' => 'S0', '1' => 'S1'],
                'S1' => ['0' => 'S2', '1' => 'S0'],
                'S2' => ['0' => 'S1', '1' => 'S2'],
            ],
        );
    }

    public function testInvalidFSMTransitionUnknownTransition(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->fsm = new FSM(
            $this->states,
            $this->alphabet,
            $this->initialState,
            $this->finalStates,
            [
                'S0' => ['0' => 'S0', '1' => 'S6'],
                'S1' => ['0' => 'S2', '1' => 'S0'],
                'S2' => ['0' => 'S1', '1' => 'S2'],
            ],
        );
    }

}