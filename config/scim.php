<?php

return [
    "trace" => env("SCIM_TRACE",false),
    // below, if we ever get 'sure' that we can change this default to 'true' we should
    "standards_compliance" => env('SCIM_STANDARDS_COMPLIANCE', false),
    "publish_routes" => false,
];
