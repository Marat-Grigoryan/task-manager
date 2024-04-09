<?php

namespace App\Entities;

interface HasEntity
{
    /**
     * @return Entity
     */
    public function toEntity(): Entity;
}