<?php

namespace App\Services;

use App\Repository\GeneralRepositoryInterface;

trait HasServiceRepositoryTrait
{
    /**
     * @var GeneralRepositoryInterface
     */
    protected GeneralRepositoryInterface $repository;

    /**
     * Set repository
     *
     * @param GeneralRepositoryInterface $repository
     */
    public function setRepository(GeneralRepositoryInterface $repository): void
    {
        $this->repository = $repository;
    }

    /**
     * Ger repository
     *
     * @return GeneralRepositoryInterface
     */
    public function getRepository() : GeneralRepositoryInterface
    {
        return $this->repository;
    }
}
