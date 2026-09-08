<?php

return [
    // Costo de envío plano aplicado a todos los pedidos (MVP; a futuro
    // puede depender de zona/peso).
    'shipping_cost' => env('SHOP_SHIPPING_COST', 99.00),

    // Umbral para marcar una variante como "stock bajo" en el admin.
    'low_stock_threshold' => env('SHOP_LOW_STOCK_THRESHOLD', 3),
];
