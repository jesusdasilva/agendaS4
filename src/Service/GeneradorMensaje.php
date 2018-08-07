<?php
// src/Service/GeneradorMensaje.php

namespace App\Service;

use Symfony\Component\Translation\TranslatorInterface;

class GeneradorMensaje
{
    private $tipo;
    private $contenido;
    private $traductor;

    public function __construct(TranslatorInterface $traductor)
    {
        $this->traductor = $traductor;
    }

    // Mensajes flash
    public function crear($tipo,$codigo = null)
    {
        switch ($tipo) {
            case 'Nuevo':
                // code...
                $this->tipo = 'success';
                $this->contenido = $this->traductor->trans('mensaje.nuevo',[],'mensaje');
            break;
            case 'Editar':
                // code...
                $this->tipo = 'success';
                $this->contenido = $this->traductor->trans('mensaje.editar',[],'mensaje');
                break;
            case 'Eliminar':
                // code...
                $this->tipo = 'success';
                $this->contenido = $this->traductor->trans('mensaje.eliminar',[],'mensaje');
                break;
            // Error al eliminar registro
            case 'error_eliminar':
                // Mensaje genérico
                $this->tipo = 'danger';
                $this->contenido = $this->traductor->trans('mensaje.error_eliminar',[],'mensaje');
                break;
            case 'error_eliminar_23000':
                // violación de clave foranea
                $this->tipo = 'danger';
                $this->contenido = $this->traductor->trans('mensaje.error_eliminar_23000',[],'mensaje');
                break;
            case 'error_eliminar_otro':
                // Otro
                $this->tipo = 'danger';
                $this->contenido = $this->traductor->trans('mensaje.error_eliminar_otro'.$codigo,[],'mensaje');
                break;
            case 'mensaje_confirmacion_eliminar':
                // Mensaje de confirmación de Eliminación en _delete_form
                $this->contenido = $this->traductor->trans('mensaje.confirmacion_eliminar',[],'mensaje');
                break;
            default:
                // code...
                $this->tipo = 'Nada';
                $this->mensaje = 'Nada';
                break;
        }

    }

    // Tipo de mensaje
    public function getTipo()
    {
        return $this->tipo;
    }
    //Contenido del mensaje
    public function getContenido()
    {
        return $this->contenido;
    }
}
