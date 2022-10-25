<?php

namespace markhuot\craftdata\attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class BodyParams
{
    function __construct(
        public string $dataClass,
    ) {
    }
}