<?php

namespace App\Controller;

use App\Entity\Producto;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class productoController extends AbstractController
{
    /**
     * @Route("/api/producto/lista", name="api_producto_lista", methods={"GET"})
     */
    public function lista(Request $request, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $productos = $em->getRepository(Producto::class)->obtenerProductos();
        return new JsonResponse([
            'productos' => $productos,
        ]);
    }

    /**
     * @Route("/api/producto/nuevo", name="api_producto_nuevo", methods={"POST"})
     */
    public function nuevo(Request $request, ManagerRegistry $doctrine)
    {

        $em = $doctrine->getManager();
        $producto = new Producto();
        $producto->setNombre($request->get("nombre"));
        $producto->setPrecio($request->get("precio"));
        $em->persist($producto);
        $em->flush();
        return new JsonResponse($producto);
    }

    /**
     * @Route("/api/producto/detalle/{id}", name="api_producto_detalle", methods={"GET"})
     */
    public function detalle(Request $request, ManagerRegistry $doctrine, $id)
    {
        $em = $doctrine->getManager();
        $producto = $em->getRepository(Producto::class)->obtenerProducto($id);
        return new JsonResponse($producto);
    }


    /**
     * @Route("/api/producto/actualizar/{id}", name="api_producto_actualizar",  methods={"POST"})
     */
    public function actualizar(Request $request, $id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $producto = $em->getRepository(Producto::class)->find($id);
        $producto->setNombre($request->get("nombre"));
        $producto->setPrecio($request->get("precio"));
        $em->persist($producto);
        $em->flush();
        return new JsonResponse([
            'producto' => "actualizado",
        ]);
    }

    /**
     * @Route("/api/producto/eliminar/{id}", name="api_producto_eliminar", methods={"POST"})
     */
    public function eliminar(Request $request, $id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $producto = $em->getRepository(Producto::class)->find($id);
        $em->remove($producto);
        $em->flush();
        return new JsonResponse([
            'producto' => "ELIMINADO",
        ]);
    }
}