<?php

namespace Fsm;

class ModThree
{
    private FSM $fsm;
    private string $input;

    public function __construct(string $input)
    {
        $this->input = $input;
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

    public function modThree(): string
    {
        return $this->fsm->run($this->input);
    }
}