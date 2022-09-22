<?php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    public function obtenerProductos()
    {
        return $this->createQueryBuilder('p')
            ->addSelect('p.id')
            ->addSelect('p.nombre')
            ->addSelect('p.precio')
            ->getQuery()
            ->getResult();
    }

    public function obtenerProducto($id)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('p.id')
            ->addSelect('p.nombre')
            ->addSelect('p.precio')
            ->where("p.id = {$id}")
            ->getQuery()
            ->getResult();
    }
}
