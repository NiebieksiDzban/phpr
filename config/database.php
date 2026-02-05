<?php
    declare(strict_types=1);

    use App\Database\PdoFactory;

    return PdoFactory::makeFromEnv();