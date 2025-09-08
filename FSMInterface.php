<?php

namespace Fsm;

interface FSMInterface
{
    public function run(string $input): string;
}