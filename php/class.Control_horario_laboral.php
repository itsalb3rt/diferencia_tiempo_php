<?php
/**
* 	Albert E. Hidalgo Taveras
*
*	GitHub = https://github.com/itsalb3rt
*	Twitter = https://twitter.com/itsHivat
*
*
* Clase para manejo de horario laboral, cuenta con metodos para el tiempo
* transcurrido entre fechas, calculos y otras funciones relacionadas al manejo del tiempo laboral
*
*
**/
class Control_horario_laboral{
    
	//Algunas variables
    private $HORA_INICIO_LABORAL;
    private $HORA_FINAL_LABORAL;
    private $HORAS_LABORALES;
	
	//Constructor
    public function __construct(){
        $this->HORA_INICIO_LABORAL = '08:00:00';
        $this->HORA_FINAL_LABORAL = '17:00:00';
        $this->HORAS_LABORALES = 8;
    }
    
    /**
    * Este metodo retorna el total de segundos transcurridos entre 2 fechas
    * Tomando en cuanta solo los dias de la semana y los dias de fiestas pasados como array
    *
    * Parametros
    * @dias_fiesta array [Son los dias que se excluiran del conteno. Deben estar en formato Y-m-d H:i:s (2018-05-30 14:25:00)]
    **/
    public function tiempo_transcurrido_fechas($fecha_inicio, $fecha_final,$dia_fiesta = array('1990-01-01'), $type = 'array') {
        //formateando fechas
        $date_1 = date_create($fecha_inicio);
        $date_2 = date_create($fecha_final);

        /**
		* 1 (para lunes) hasta 7 (para domingo)
		* se utiliza para saber cuales son los dias de la semana
		* o dias laborables
		**/
        $dia_inicial = 1;
        $dia_final = 5;
        /**
		* Fecha inicial no puede ser mayor a fecha final, 
		* de lo contrario retorna falso y finaliza el script
		**/
        if ($date_1 > $date_2){
            $tiempo_transcurrido['tiempo_total_segundos'] = 0; 
            return $tiempo_transcurrido;
        }

        /**
        * Detemrinando si la fecha inicio y final es el mismo dia para calcular
        * el tiempo transcurrido en un dia
        **/
        if($date_1->format('Y-m-d') == $date_2->format('Y-m-d')){
            $tiempo_transcurrido['tiempo_total_segundos'] =  $this->diferencia_tiempo_en_un_dia($date_1->format('Y-m-d H:i:s'),$date_2->format('Y-m-d H:i:s'));
            return  $tiempo_transcurrido;
        }

        /**
        * Obteniendo la cantidad de dias que existe entre la fecha inicial y final
        * para obtener los dias habiles solamente, esto tambien excluye del conteno
        * los dias feriados pasados en un array como parametro @dia_diesta
        **/
        $tiempo_transcurrido = array();
        $tiempo_transcurrido['dias_totales'] = '';

        while ($date_1->format('Y-m-d') <= $date_2->format('Y-m-d')) {
            $dia = $date_1->format('N');
            //$tiempo_transcurrido['dias_while'][] = $date_1->format('d');
            if ($dia >= $dia_inicial && $dia <= $dia_final && !in_array($date_1->format('Y-m-d'),$dia_fiesta)) {
                $tiempo_transcurrido['dias_totales'][] = $date_1->format('d');
            }
            date_add($date_1, date_interval_create_from_date_string('1 day'));
        }
        if (strtolower($type) === 'sum') {
            array_map(function($k) use(&$tiempo_transcurrido) {
                $tiempo_transcurrido[$k] = count($tiempo_transcurrido[$k]);
            }, array_keys($tiempo_transcurrido));
        }
        
        // Recuperando las fechas originales para realizar los calculos del tiempo transcurrido
        $date_1 = date_create($fecha_inicio);
        $date_2 = date_create($fecha_final);
        /**
        * Calculando que tiempo transcurrio en el primer dia y segundo dia
        *
        * Esto para obtener entre el horario laboral el tiempo que ha transcurrido
        * desde la fecha inicial y la fecha final
        *
        * El resultado es devuelto en segundos
        */
        $tiempo_transcurrido['tiempo_primer_dia'] = $this->diferencia_tiempo_en_un_dia($date_1->format('Y-m-d H:i:s'),$date_1->format('Y-m-d') . $this->HORA_FINAL_LABORAL);
        $tiempo_transcurrido['tiempo_ultimo_dia'] = $this->diferencia_tiempo_en_un_dia($date_2->format('Y-m-d') . $this->HORA_INICIO_LABORAL,$date_2->format('Y-m-d H:i:s'));

        /**
        * Verificando que el resultado del tiempo en segundos del primer dia y el ultimo dia
        * no sea negativo, de ser negativo se iguala a 0
        **/
        $tiempo_transcurrido['tiempo_ultimo_dia'] = $this->evitar_negativos($tiempo_transcurrido['tiempo_ultimo_dia']);
        $tiempo_transcurrido['tiempo_primer_dia'] = $this->evitar_negativos($tiempo_transcurrido['tiempo_primer_dia']);
        
        //Sumando los segundos del primer dia y el ultimo dia
        $tiempo_transcurrido['tiempo_total_segundos'] = $tiempo_transcurrido['tiempo_primer_dia'] + $tiempo_transcurrido['tiempo_ultimo_dia'];
        
        //Obteniendo en segundos la cantidad de horas si ha pasado mas de 1 dia de la fecha de inicio a la fecha final
        $tiempo_transcurrido['tiempo_total'] = $this->dias_a_horas(count($tiempo_transcurrido['dias_totales']));
        
        //Obteniendo el total de tiempo transcurrido en segundos
        $tiempo_transcurrido['tiempo_total_segundos'] += $tiempo_transcurrido['tiempo_total']; 

        return $tiempo_transcurrido;

    }
    /**
    * Devuelve la cantidad de tiempo en segundos, es utilizado para calcular
    * diferencia de tiempo en un mismo dia
    **/  
    public function diferencia_tiempo_en_un_dia($fecha_inicial,$fecha_final){

         $segundos = (((strtotime($fecha_final) - strtotime($fecha_inicial))/60)/60);    
         return $segundos * 60 * 60;
    }
    /**
    * @dias [array con los dias]
    *
    * retorna la cantidad de horas en segundos de todos los dias 
    * si ha pasado mas de 1 dia entre la fecha de inicio 
    * y la fecha final y convirtiendolo en segundos
	*
	* Return Integer
    **/
    public function dias_a_horas($dias){
        if($dias >= 3){
            //Si hay 3 o mas dias se resta 2 a la cantidad para no contar la fecha de inicio y la final como 8 horas mas
            $horas = ($dias - 2) * $this->HORAS_LABORALES;
            return ($horas) * 60 * 60;
        }else{
            return 0;
        }
    }
    /**
    * @cantidad [numero entero]
    *
    * Este metodo retorna 0 si la cantidad pasada es menor 1
    * en todos los casos este metodo no recibe numeros reales
    * solo reibe enteros los cuales son los segundos
	*
	* Return integer
    *
    **/
    public function evitar_negativos($cantidad){
        if($cantidad < 1){
            return 0;
        }else{
            return $cantidad;
        }
    }
	
} //fin de la clase