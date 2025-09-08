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
        $state = $this->initialState;

        foreach (str_split($input) as $symbol) {
            $state = $this->transitionFunction[$state][$symbol];
        }

        return $state;
    }
}