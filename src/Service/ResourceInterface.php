<?php


namespace App\Service;

use App\Entity\News;

interface ResourceInterface
{
    /**
     * @return News[]
     */
    public function getLastNews(): array;
}
