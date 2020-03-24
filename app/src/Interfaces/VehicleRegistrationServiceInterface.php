<?php

namespace App\Interfaces;

interface VehicleRegistrationServiceInterface
{
    public function getAbiCode(string $regNo): string;
}
