<?php
function getip(){
   // Verificar si $_SERVER está disponible
   if(isset($_SERVER)){
       // Verificar headers de proxy en orden de prioridad
       if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
           // Puede contener múltiples IPs separadas por coma, tomar la primera
           $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
           return trim($ips[0]);
       }
       elseif(isset($_SERVER['HTTP_X_REAL_IP']) && !empty($_SERVER['HTTP_X_REAL_IP'])){
           return $_SERVER['HTTP_X_REAL_IP'];
       }
       elseif(isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])){
           return $_SERVER['HTTP_CLIENT_IP'];
       }
       elseif(isset($_SERVER['REMOTE_ADDR'])){
           return $_SERVER['REMOTE_ADDR'];
       }
   }
   
   // Métodos alternativos si $_SERVER no está disponible
   if(function_exists('getenv')){
       if(getenv('HTTP_X_FORWARDED_FOR')){
           $ips = explode(',', getenv('HTTP_X_FORWARDED_FOR'));
           return trim($ips[0]);
       }
       elseif(getenv('HTTP_X_REAL_IP')){
           return getenv('HTTP_X_REAL_IP');
       }
       elseif(getenv('HTTP_CLIENT_IP')){
           return getenv('HTTP_CLIENT_IP');
       }
       elseif(getenv('REMOTE_ADDR')){
           return getenv('REMOTE_ADDR');
       }
   }
   
   // Si no se puede determinar la IP
   return 'Unknown';
}

function getUserIp(){
    foreach(['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_X_CLUSTER_CLIENT_IP','HTTP_FORWARDED_FOR','HTTP_FORWARDED','HTTP_X_REAL_IP','REMOTE_ADDR'] as $key){
        if(isset($_SERVER[$key]) && !empty($_SERVER[$key])){
            // Procesar múltiples IPs separadas por coma
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                // Validar que sea una IP válida
                if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)){
                    return $ip;
                }
            }
        }
    }
    
    // Fallback: intentar obtener cualquier IP válida (incluyendo privadas)
    foreach(['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_X_CLUSTER_CLIENT_IP','HTTP_FORWARDED_FOR','HTTP_FORWARDED','HTTP_X_REAL_IP','REMOTE_ADDR'] as $key){
        if(isset($_SERVER[$key]) && !empty($_SERVER[$key])){
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if(filter_var($ip, FILTER_VALIDATE_IP)){
                    return $ip;
                }
            }
        }
    }
    
    // Si no encuentra nada válido
    return 'Unknown';
}