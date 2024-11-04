<?php

return [
    'paths' => ['api/*'], // Define las rutas donde aplicar CORS, por ejemplo, todos los endpoints en 'api'
    'allowed_methods' => ['*'], // Permite todos los métodos HTTP
    'allowed_origins' => ['http://localhost:3000'], // Reemplaza con la URL de tu app Next.js
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Permite todos los headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Actívalo si necesitas enviar cookies o tokens
];
