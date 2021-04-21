<?php 
    function formatear_fecha($fecha){
    return date('d:M:Y', strtotime($fecha));
    }

    function texto_corto($texto){
        $texto = $texto . "";
        $texto = substr($texto, 0, 30);
        $texto = substr($texto, 0, strrpos($texto, ' '));
        $texto = $texto . "...";
        return $texto;
        }
?>