<?php

return [
    'allowed_domains' => env('WHITELISTED_DOMAINS') . ',' . env('PENDING_DOMAINS'),
    'whitelisted_domains' => env('WHITELISTED_DOMAINS', 'domain.com,google.com'),
    'pending_domain' => env('PENDING_DOMAINS', 'other-domain.com,bar.com'),

    'admin_email' => env('ADMIN_EMAIL', 'admin@domain.com')
];
