<?php

namespace Fsm;

enum State: string
{
    case S0 = 'S0';
    case S1 = 'S1';
    case S2 = 'S2';

    public function valueFromState(): string
    {
        return match ($this) {
            State::S0 => '0',
            State::S1 => '1',
            State::S2 => '2',
        };
    }
}