<?php

namespace Siesc\PartesBundle;


class NovedadTransitions
{
    const GRAPH = "partes_novedad";

    const SIESC_CREAR = 'create';

    const SIESC_AUTORIZAR = 'autorizar';

    const SIESC_DESAUTORIZAR = 'desautorizar';

    const SIESC_RECHAZAR = 'rechazar';

    const SIESC_PEDIR_CAMBIOS = 'pedir_cambios';

    const SIESC_GENERAR_REPORTE = 'generar_reporte';

    const SIESC_ENVIAR_CAMBIOS = 'enviar_cambios';

    public static $estados = array(
        'pendiente_aprobacion' => 'Pendiente Aprobacion',
        'autorizada' => 'Autorizada',
        'desutorizada' => 'Desautorizada',
        'liquidada' => 'Liquidada',
        'pendiente_cambios' => 'Pendiente Cambios',
        'rechazada' => 'Rechazada'
    );
} 