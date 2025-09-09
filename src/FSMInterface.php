<?php
declare(strict_types=1);

namespace Fsm;
interface FSMInterface
{
    public function run(string $input): string;
}