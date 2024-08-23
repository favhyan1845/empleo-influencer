<?php
function calcularEdad($fecha_nacimiento) {
    // Convertir la fecha de nacimiento a un objeto de fecha
    $fecha_nacimiento = new DateTime($fecha_nacimiento);
    // Obtener la fecha actual
    $fecha_actual = new DateTime();
    // Calcular la diferencia entre las fechas
    $diferencia = $fecha_actual->diff($fecha_nacimiento);
    // Obtener la edad en años
    
    $edad = $diferencia->y;
    return $edad;
}

?>