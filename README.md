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
$dias_fiesta = array (0); //se explica mas abajo
$diferencia_fechas = new Control_horario_laboral();
//Pasando los parametros
$resultados = $diferencia_fechas->tiempo_transcurrido_fechas( $fecha_inicio, $fecha_final,$dias_fiesta );
```
Retorna un arreglo asosiativo:

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
___
## Dias festivos

Los días festivos deben ser especificados en un array, de ser omitidos no se toma ningún día de festivo

```php
$dias_fiesta = array (
  '2018-01-01',
  '2018-05-01'
);
```

## Configuracion

Si se desea cambiar las horas laborales se debe modificar el constructor de la clase

```php
$this->HORA_INICIO_LABORAL = '08:00:00';
$this->HORA_FINAL_LABORAL = '17:00:00';
$this->HORAS_LABORALES = 8;
```
Tambien es posible modificar cuales son los dias laborales

```php
/**
* 1 (para lunes) hasta 7 (para domingo)
* se utiliza para saber cuales son los dias de la semana
* o dias laborables
**/
$dia_inicial = 1;
$dia_final = 5;

```

