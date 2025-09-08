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
        $this->validate();
    }

    private function validate() : void
    {
        if (!in_array($this->initialState, $this->states, true)) {
            throw new \InvalidArgumentException('Initial state not in list of states');
        }
        foreach ($this->finalStates as $f) {
            if (!in_array($f, $this->states, true)) {
                throw new \InvalidArgumentException("Final state $f not in list of states");
            }
        }
        foreach ($this->states as $state) {
            if (!isset($this->transitionFunction[$state])) {
                throw new \InvalidArgumentException("Missing transition function for $state");
            }
            foreach ($this->alphabet as $symbol) {
                if (!isset($this->transitionFunction[$state][$symbol])) {
                    throw new \InvalidArgumentException("Missing symbol $symbol in transition function for state $state");
                }
                if (!in_array($this->transitionFunction[$state][$symbol], $this->states, true)) {
                    throw new \InvalidArgumentException("Unknown state");
                }
            }
        }
    }

    public function run(string $input): string
    {
        if (empty($input)) {
            throw new \InvalidArgumentException('Input is empty');
        }

        $state = $this->initialState;

        foreach (str_split($input) as $symbol) {
            $state = $this->transitionFunction[$state][$symbol];
        }

        return $state;
    }
}