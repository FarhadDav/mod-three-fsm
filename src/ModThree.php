<?php

namespace Fsm;

class ModThree
{
    private FSM $fsm;
    private array $stateToOutput = ['S0' => '0', 'S1' => '1', 'S2' => '2'];

    public function __construct()
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

    /**
     * Takes list of output state mappings and returns appropriate one
     * based on FSM run result
     *
     * @param string $input
     * @return string
     */
    public function modThree(string $input): string
    {
        return $this->stateToOutput[$this->fsm->run($input)];
    }
}