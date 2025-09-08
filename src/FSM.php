<?php
declare(strict_types=1);

namespace Fsm;

final class FSM implements FSMInterface
{
    public function __construct(
        private array  $states,
        private array  $alphabet,
        private string $initialState,
        private array  $finalStates,
        private array  $transitionFunction
    )
    {

    }

    private function validate()
    {

    }

    public function run(string $input): string
    {
        $result = $this->initialState;

        return $result;
    }
}