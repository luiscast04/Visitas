<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador de Visitas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .contador-box {
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
            color: white;
            padding: 20px 30px;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        
        .contador-box:hover {
            transform: translateY(-5px);
        }
        
        .numero-visitas {
            font-size: 3em;
            font-weight: bold;
            margin: 10px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .texto-visitas {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .info-adicional {
            margin-top: 30px;
            color: #666;
            font-size: 0.9em;
        }
        
        .fecha-hora {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            border-left: 4px solid #667eea;
        }
        
        .ip-info {
            background: #e9ecef;
            padding: 10px;
            border-radius: 8px;
            margin-top: 15px;
            font-size: 0.85em;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌐 Contador de Visitas</h1>
        
        <div class="contador-box">
            <div class="texto-visitas">Visitas Totales Registradas</div>
            <div class="numero-visitas" id="contadorNumero">

                <?php
               include('ip.php');

function contadorVisitas() {
    $archivo = "contadorvisitas.txt";
    $archivoIP = "addressIP.txt";
    $archivoIPPublica = "ip_publica.txt";
    
    // Obtener IP del visitante una sola vez
    $ip_actual = getUserIp();
    $timestamp = date('Y-m-d H:i:s');
    
    // Leer y actualizar contador
    $contadorvisitas = file_exists($archivo) ? intval(file_get_contents($archivo)) : 0;
    $contadorvisitas++;
    file_put_contents($archivo, $contadorvisitas, LOCK_EX);
    
    // Guardar IP con timestamp (una sola vez)
    file_put_contents($archivoIP, "[$timestamp] IP: $ip_actual\n", FILE_APPEND | LOCK_EX);
    file_put_contents($archivoIPPublica, "[$timestamp] IP pública: $ip_actual\n", FILE_APPEND | LOCK_EX);
    
    return $contadorvisitas;
}

echo contadorVisitas();
                ?>

            </div>
        </div>
        
        <div class="fecha-hora">
            <strong>Última visita:</strong> 
            <?php echo date('d/m/Y - H:i:s'); ?>
        </div>
        
        <div class="ip-info">
            <strong>Tu IP:</strong> <?php echo getUserIp(); ?>
        </div>
        
        <div class="info-adicional">
            <p>¡Gracias por visitar nuestra página web!</p>
            <p>Cada visita cuenta y es importante para nosotros.</p>
        </div>
    </div>
    
    <script>
        // Efecto de animación para el número
        window.onload = function() {
            const numero = document.getElementById('contadorNumero');
            numero.style.transform = 'scale(1.1)';
            setTimeout(() => {
                numero.style.transform = 'scale(1)';
            }, 500);
        };
    </script>
</body>
</html>