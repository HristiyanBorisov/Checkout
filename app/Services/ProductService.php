<?php

namespace App\Services;

use App\Repository\ProductRepositoryInterface;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

final class ProductService implements ProductServiceInterface, GeneralServiceInterface
{

    use HasServiceRepositoryTrait;

    /**
     * Constructor
     *
     * @param ProductRepositoryInterface $repository
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllProducts() : Collection
    {
        return $this->repository->getAllProducts();

    }

    public function addProduct(
        string $product_name,
        float $unit_price,
    ) : void
    {
        $parameters = [
            'id' => Uuid::uuid4(),
            'name' => $product_name,
            'unit_price' => $unit_price,
        ];

        $this->repository->addProduct($parameters);
    }

    public function renameProduct(
        string $product_id,
        string $product_new_name,
    ) : void
    {
        $this->repository->renameProduct($product_id, $product_new_name);
    }

    public function deleteProduct(
        string $product_id
    ) : void
    {
        $this->repository->deleteProduct($product_id);
    }

    public function getSpecialPrice() : Collection
    {
        return $this->repository->getSpecialPrice();
    }

    public function addSpecialOffer(
        string $id,
        int $quantity,
        float $price
    ) : bool
    {

        $parameters = [
            'quantity' => $quantity,
            'price' => $price,
        ];

        return $this->repository->addSpecialOffer($id, $parameters);
    }

    public function deleteSpecialOffer(
        string $id
    ) : bool
    {
        return $this->repository->deleteSpecialOffer($id);
    }
}
