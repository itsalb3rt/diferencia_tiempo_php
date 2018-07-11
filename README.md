# Diferencia de tiempo transcurrido entre 2 fechas

Clase PHP que te permite obtener la diferencia en segundos que existe entre 2 fechas 
Tomando en cuenta los días hábiles tales como días de semana, días feriados), sábados y domingos.


![capa](https://i.imgur.com/NiF4lXd.png)

___

El archivo principal encargado del cálculo es la clase ```class.Control_horario_laboral.php```

## Requisitos
- Un servidor capaz de correr PHP 5^

___
## Como usarla

Instanciamos un nuevo objeto de la clase ``` Control_horario_laboral() ```
```php
$diferencia_fechas = new Control_horario_laboral();
//Pasando los parametros
$resultados = $diferencia_fechas->tiempo_transcurrido_fechas( $fecha_inicio, $fecha_final,$dias_fiesta );
```
Retorna un arreglo asositativo:

```
array (size=5)
  'dias_totales' => 
    array (size=8)
      0 => string '11' (length=2)
      1 => string '12' (length=2)
      2 => string '13' (length=2)
      3 => string '16' (length=2)
      4 => string '17' (length=2)
      5 => string '18' (length=2)
      6 => string '19' (length=2)
      7 => string '20' (length=2)
  'tiempo_primer_dia' => int 32400
  'tiempo_ultimo_dia' => int 0
  'tiempo_total_segundos' => int 205200
  'tiempo_total' => int 172800
```

El mismo puede ser utilizado de la siguiente manera

```php
$tiempo_segundos =  $resultados['tiempo_total_segundos']; //205200
```
