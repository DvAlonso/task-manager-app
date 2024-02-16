<?php

namespace App\Concerns;

interface Formattable 
{
    /**
     * Format the entity for API response displaying.
     */
    public function format(): array;
}