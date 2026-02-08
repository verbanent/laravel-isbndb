<?php

return [
    'api_key' => env('ISBNDB_API_KEY', ''),
    'timeout' => (float) env('ISBNDB_TIMEOUT', 10.0),
];
