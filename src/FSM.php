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
        $this->validateFSM();
    }

    /**
     * Validate input
     *
     * @param string $input
     * @return void
     */
    private function validateInput(string $input): void
    {
        if (empty($input)) {
            throw new \InvalidArgumentException('Input is empty');
        }

        foreach (str_split($input) as $symbol) {
            if (!in_array($symbol, $this->alphabet, true)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        "Invalid symbol '%s'. Allowed: {%s}",
                        $symbol,
                        implode(',', $this->alphabet)
                    )
                );
            }
        }
    }

    /**
     * Validates FSM parameters
     *
     * @return void
     */
    private function validateFSM() : void
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

    /**
     * Run the generated FSM instance
     *
     * @param string $input
     * @return string
     */
    public function run(string $input): string
    {
        $this->validateInput($input);

        $state = $this->initialState;

        foreach (str_split($input) as $symbol) {
            $state = $this->transitionFunction[$state][$symbol];
        }

        return $state;
    }
}