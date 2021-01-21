<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted' => 'El campo :attribute debe ser aceptado.',
    'active_url' => 'El campo :attribute no es una URL válida.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El campo :attribute sólo debe contener letras.',
    'alpha_dash' => 'El campo :attribute sólo debe contener letras, números y guiones.',
    'alpha_num' => 'El campo :attribute sólo debe contener letras y números.',
    'array' => 'El campo :attribute debe ser un conjunto.',
    'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'El campo :attribute tiene que estar entre :min - :max.',
        'file' => 'El campo :attribute debe pesar entre :min - :max kilobytes.',
        'string' => 'El campo :attribute tiene que tener entre :min - :max caracteres.',
        'array' => 'El campo :attribute tiene que tener entre :min - :max ítems.',
    ],
    'boolean' => 'El campo :attribute debe tener un valor verdadero o falso.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'date' => 'El campo :attribute no es una fecha válida.',
    'date_format' => 'El campo :attribute no corresponde al formato :format.',
    'different' => 'El campo :attribute y :other deben ser diferentes.',
    'digits' => 'El campo :attribute debe tener :digits dígitos.',
    'digits_between' => 'El campo :attribute debe tener entre :min y :max dígitos.',
    'dimensions' => 'Las dimensiones de la imagen :attribute no son válidas.',
    'distinct' => 'El campo :attribute contiene un valor duplicado.',
    'email' => 'El campo :attribute no es un correo válido',
    'exists' => 'El campo :attribute es inválido.',
    'file' => 'El campo :attribute debe ser un archivo.',
    'filled' => 'El campo :attribute es obligatorio.',
    'gt' => [
        'numeric' => 'El campo :attribute debe ser mayor que :value.',
        'file' => 'El campo :attribute debe tener más de :value kilobytes.',
        'string' => 'El campo :attribute debe tener más de :value caracteres.',
        'array' => 'El campo :attribute debe tener más de :value elementos.',
    ],
    'gte' => [
        'numeric' => 'El campo :attribute debe ser como mínimo :value.',
        'file' => 'El campo :attribute debe tener como mínimo :value kilobytes.',
        'string' => 'El campo :attribute debe tener como mínimo :value caracteres.',
        'array' => 'El campo :attribute debe tener como mínimo :value elementos.',
    ],
    'image' => 'El campo :attribute debe ser una imagen.',
    'in' => 'El campo :attribute es inválido.',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'ip' => 'El campo :attribute debe ser una dirección IP válida.',
    'ipv4' => 'El campo :attribute debe ser un dirección IPv4 válida',
    'ipv6' => 'El campo :attribute debe ser un dirección IPv6 válida.',
    'json' => 'El campo :attribute debe tener una cadena JSON válida.',
    'lt' => [
        'numeric' => 'El campo :attribute debe ser menor que :value.',
        'file' => 'El campo :attribute debe tener menos de :value kilobytes.',
        'string' => 'El campo :attribute debe tener menos de :value caracteres.',
        'array' => 'El campo :attribute debe tener menos de :value elementos.',
    ],
    'lte' => [
        'numeric' => 'El campo :attribute debe ser como máximo :value.',
        'file' => 'El campo :attribute debe tener como máximo :value kilobytes.',
        'string' => 'El campo :attribute debe tener como máximo :value caracteres.',
        'array' => 'El campo :attribute debe tener como máximo :value elementos.',
    ],
    'max' => [
        'numeric' => 'El campo :attribute no debe ser mayor a :max.',
        'file' => 'El campo :attribute no debe ser mayor que :max kilobytes.',
        'string' => 'El campo :attribute no debe ser mayor que :max caracteres.',
        'array' => 'El campo :attribute no debe tener más de :max elementos.',
    ],
    'mimes' => 'El campo :attribute debe ser un archivo con formato: :values.',
    'mimetypes' => 'El campo :attribute debe ser un archivo con formato: :values.',
    'min' => [
        'numeric' => 'El tamaño de :attribute debe ser de al menos :min.',
        'file' => 'El tamaño de :attribute debe ser de al menos :min kilobytes.',
        'string' => 'El campo :attribute debe contener al menos :min caracteres.',
        'array' => 'El campo :attribute debe tener al menos :min elementos.',
    ],
    'not_in' => 'El campo :attribute es inválido.',
    'not_regex' => 'El formato del campo :attribute no es válido.',
    'numeric' => 'El campo :attribute debe ser numérico.',
    'order_by' => 'El campo :attribute sólo puede contener los valores "asc" o "desc"',
    'present' => 'El campo :attribute debe estar presente.',
    'regex' => 'El formato de :attribute es inválido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless' => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values estén presentes.',
    'same' => 'El campo :attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El tamaño de :attribute debe ser :size.',
        'file' => 'El tamaño de :attribute debe ser :size kilobytes.',
        'string' => 'El campo :attribute debe contener :size caracteres.',
        'array' => 'El campo :attribute debe contener :size elementos.',
    ],
    'string' => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone' => 'El :attribute debe ser una zona válida.',
    'unique' => 'El campo :attribute ya ha sido registrado.',
    'uploaded' => 'Subir :attribute ha fallado.',
    'url' => 'El formato :attribute es inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'password' => [
            'min' => 'La :attribute debe contener más de :min caracteres',
        ],
        'email' => [
            'unique' => 'El :attribute ya ha sido registrado.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Message Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the Api Responder.
    | When it generates error responses, it will search the messages array
    | below for any key matching the given error code for the response.
    |
    */
    'handler' => [
        'resource_not_found' => 'No existe ninguna instacia para el valor especificado.',
        'resource_not_found_url' => 'La URL solicitada no existe.',
        'unauthenticated' => 'No estás autenticado para esta solicitud.',
        'unauthorized' => 'No estás autorizado para esta solicitud.',
        'relation_not_found' => 'La relación solicitada no existe.',
        'column_not_found' => 'La columna solicitada no existe.',
        'relation_not_delete' => 'El recurso no puede ser eliminado, contiene información asociada.',
        'validation_failed' => 'La información dada no pasó la validación.',
        'syntax_error' => 'la sintaxis de la entidad de solicitud no es correcta.',
        'method_allow' => 'El método especificado no existe.',
        'unexpected_failure' => 'Error inesperado, inténtalo de nuevo en un momento.',
        'conflict' => 'La solicitud no se pudo procesar debido a un conflicto.',
        'service_unavailable' => 'El servicio no está disponible, vuelve a intentarlo en un momento.',
        'token_mismatch' => 'El token no coincide con el solicitud, por favor intenta recargar la página.',
        'max_attempts' => '{1} Demasiados intentos, por favor ralentice la solicitud e intente de nuevo en :min minuto.|[2,*] Demasiados intentos, por favor ralentice la solicitud e intente de nuevo en :min minutos.',
        'connection_refused' => ':db ha rechazado la conexión.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'nombre',
        'username' => 'usuario',
        'email' => 'correo electrónico',
        'first_name' => 'nombre',
        'last_name' => 'apellido',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de la contraseña',
        'city' => 'ciudad',
        'country' => 'país',
        'address' => 'dirección',
        'phone' => 'teléfono',
        'mobile' => 'móvil',
        'age' => 'edad',
        'sex' => 'sexo',
        'gender' => 'género',
        'year' => 'año',
        'month' => 'mes',
        'day' => 'día',
        'hour' => 'hora',
        'minute' => 'minuto',
        'second' => 'segundo',
        'title' => 'título',
        'content' => 'contenido',
        'body' => 'contenido',
        'description' => 'descripción',
        'excerpt' => 'extracto',
        'date' => 'fecha',
        'time' => 'hora',
        'subject' => 'asunto',
        'message' => 'mensaje',
        'per_page' => 'por página',
        'order_by' => 'ordenado por',
        'direction' => 'dirección',
        'canceled' => 'cancelado',
        'active' => 'vigente',
        'modified' => 'modificado',
        'remember_me' => 'recordame',
        'nit' => 'nit',
        'code' => 'código',
        'stock' => 'existencia',
        'price' => 'precio',
        'expired_at' => 'fecha de expiración',
        'created_at' => 'fecha de creación',
        'updated_at' => 'fecha de actualización',
        'deleted_at' => 'fecha de eliminación',
        'delivery_at' => 'fecha de entrega',
        'requested_at' => 'fecha de solicitud',
        'module_id' => 'módulo',
        'company_id' => 'compañía',
        'user_id' => 'usuario',
        'user' => 'usuario',
        'status_id' => 'estado',
        'status' => 'estado',
        'delivery_address' => 'dirección de entrega',
        'products_order_count' => 'cantidad de productos',
        'business_unity_id' => 'unidad de negocio',
        'provider_id' => 'proveedor',
        'display_name' => 'nombre para mostar',
        'done' => 'empacado y enviado',
        'picked' => 'empacado',
        'packed' => 'enviado',
        'transit' => 'en tránsito',
        'security' => 'seguridad',
        'customers' => 'clientes',
        'purchases' => 'compras',
        'modules' => 'módulos',
        'submodules' => 'submódulos',
        'submodule_id' => 'submódulos',
        'users' => 'usuarios',
        'roles' => 'roles',
        'permissions' => 'permisos',
        'companies' => 'compañías',
        'business_unities' => 'unidades de negocio',
        'products' => 'productos',
        'product' => 'producto',
        'purchase_order' => 'órdenes de compra',
        'quantity' => 'cantidad',
        'requested_quantity' => 'solicitado',
        'issue' => 'novedad',
        'number' => 'número',
        'received' => 'recibido',
        'received with novelty' => 'recibido con novedad',
        'delivered' => 'entregado',
        'done with novelty' => 'empacado y enviado con novedad',
        'in transit' => 'en tránsito',
        'details' => 'detalles',
        'in transit with novelty' => 'en tránsito con novedad',
    ],
];
