<?php

namespace rob\consumocurpdev;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;


class consumocurpdev{

   
//Funcion para consumir la API
        public function Consumo_curlCURP( $curp  ){
            try {

                    $Consumir = curl_init();
                    curl_setopt_array($Consumir, array(
                        CURLOPT_URL => env('URL_SERV_CURP').$curp, 
                        CURLOPT_ENCODING => "", 
                        CURLOPT_TIMEOUT => 30, // Tiempo para expirar la sesión.
                        CURLOPT_RETURNTRANSFER => 1, 
                        // CURLOPT_POSTFIELDS=>json_encode($data),
                        CURLOPT_CUSTOMREQUEST => 'GET',  // Tipo de peticón a utilizar.
                        // CURLOPT_HTTPHEADER => $encabezado

                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Basic " . base64_encode(env('USER_SERV_CURP'). ":" .env('PASS_SERV_CURP') ), // Cabecera de la petición.
                            "Content-Type: application/json",
                        )     
                    )); 

                    //consumir la api
                    $response = curl_exec($Consumir);
                    //Obtener algun error si se encontro
                    $err = curl_error($Consumir); 
                    // Se cierra la sesion del consumo
                    curl_close($Consumir); 


                    if ($err) {
                        //Regresar el error si se encontro
                        return "cURL Error #:" . $err; 
                    
                    } else {
                        // Convertir la respuesta de jason a array
                    $array= json_decode($response, true);

                    return  $array;

                    } 
                        
        
             } catch (Exception $e) {
           
                Log::channel("daily")->debug("Ocurrio un error al ejecutar curl CURP" . $e);
  
                return response()->json(['error' =>  $e], 500);
  
          }


}

}
