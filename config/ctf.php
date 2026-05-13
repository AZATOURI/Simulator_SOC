
<?php

return [
    'fake_flags' => [
        'SOC{THIS_IS_NOT_THE_FLAG}',
        'SOC{AI_FOUND_FAKE_FLAG}',
        'SOC{VISIBLE_FAKE_HEADER}',
        'SOC{FAKE_FLAG}',
        'SOC{AI_TRAP}',
        'SOC{NOT_REAL}',
        'SOC{FAKE_VAULT_FLAG}',
    ],

    'challenges' => [
        'source-recon' => [
            'title' => 'Source Recon',
            'category' => 'Web',
            'level' => 'Easy',
            'points' => 50,
            'short' => 'A SOC analyst always checks the browser source.',
            'hash' => 'a42195d3e87ecbae42ca7e9b782eb5bf5291d79087ca14163ba2d88ddc380064',
        ],

        'console-signal' => [
            'title' => 'Console Signal',
            'category' => 'Web',
            'level' => 'Easy',
            'points' => 50,
            'short' => 'A suspicious signal appears in the browser console.',
            'hash' => 'c59ed3088af786f8fa58a4478f46123592d49b5296b1e89e3654f455338775e7',
        ],

        'forgotten-soc-file' => [
            'title' => 'Forgotten SOC File',
            'category' => 'Web / Recon',
            'level' => 'Easy',
            'points' => 75,
            'short' => 'Some SOC files are forgotten by developers.',
            'hash' => 'fa39e3e61275a0cdac302ade1d45ae65905db5f1664e530525d827b0c853e413',
            'fragment_key' => 'A',
            'fragment_value' => 'AGADIR',
        ],

        'blue-team-header' => [
            'title' => 'Blue Team Header',
            'category' => 'Web',
            'level' => 'Medium',
            'points' => 100,
            'short' => 'The response headers contain the real signal.',
            'hash' => '7aee3e92984148267485348dd8e42c49ff4d5f3d56f1f466d36a00b5dc87a1c6',
        ],

        'internal-threat-vault' => [
            'title' => 'Internal Threat Vault',
            'category' => 'Crypto',
            'level' => 'Medium',
            'points' => 100,
            'short' => 'A vault contains SHA-256 hashes.',
            'hash' => '5b97d6721cb10fb0d9fb46d603c17cbe3a1105dddc8e4d097c2e520ccb6646f9',
            'fragment_key' => 'B',
            'fragment_value' => 'SHIELD',
        ],

        'suspicious-login-log' => [
            'title' => 'Suspicious Login Log',
            'category' => 'OSINT / Logs',
            'level' => 'Medium',
            'points' => 150,
            'short' => 'Analyze SOC authentication logs.',
            'hash' => 'ac45178aa51a863a502fbffe7d95cc635b21ece23a89794e013f2d509ef2009c',
            'fragment_key' => 'C',
            'fragment_value' => 'ACTIVE',
        ],

        'analyst-trap' => [
            'title' => 'Analyst Trap',
            'category' => 'Web / Anti-AI',
            'level' => 'Medium',
            'points' => 150,
            'short' => 'Visible flags are not always real.',
            'hash' => 'd75d5b660b5084ecc7ddaccceeed014bc8824ce8e7566ba7abd2389f09751f6e',
        ],

        'admin-gateway' => [
            'title' => 'Admin Gateway',
            'category' => 'Web',
            'level' => 'Hard',
            'points' => 200,
            'short' => 'Safe SQL Injection simulation.',
            'hash' => 'fb57186b88a18d6abb2dfae272c89566452d84ed3291e8e85bd63ebaddd8ec87',
        ],

        'binary-beacon' => [
            'title' => 'Binary Beacon',
            'category' => 'Binary',
            'level' => 'Hard',
            'points' => 250,
            'short' => 'Decode a binary beacon found in SOC logs.',
            'hash' => 'd5a0e4ac269da455b02d8109abf71e166dd970dff16e181fcd2058f25b257c3d',
        ],

        'operation-agadir-shield' => [
            'title' => 'Operation Agadir Shield',
            'category' => 'Mixed',
            'level' => 'Expert',
            'points' => 300,
            'short' => 'Final mission: combine fragments A, B and C.',
            'hash' => '30b8deeddd3a09ac67518389c62d26b8bb5b77ae933dd7eae3dbe1d5533c77db',
            'requires_fragments' => ['A', 'B', 'C'],
        ],
    ],
];
