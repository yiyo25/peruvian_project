<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Upload
{ 
  function do_upload()
    {
       //especificamos a donde se va almacenar nuestra imagen
        $config['upload_path'] = 'public/imagenes/';
        //indicamos que tipo de archivos están permitidos
        $config['allowed_types'] = 'gif|jpg|png|csv';
        //indicamos el tamaño maximo permitido en este caso 1M
        $config['max_size'] = '1024';
        //le indicamos el ancho maximo permitido
        $config['max_width']  = '1024';
        //le indicamos el alto maximo permitodo
        $config['max_height']  = '768';
        //cargamos nuestra libreria con nuestra configuracion
        $this->load->library('upload', $config);
         
        //verificamos si existe errores
        if (!$this->upload->do_upload())
        {
            //almacenamos el error que existe
            return $mensaje = array('mensaje' => $this->upload->display_errors());
        }  
        else
        {
            //si no hace la subida
            return $mensaje = array('mensaje' => 'La subida se dió correctamente');
            
        }
    } 

}