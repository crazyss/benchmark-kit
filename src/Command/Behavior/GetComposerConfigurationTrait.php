<?php

declare(strict_types=1);

namespace App\Command\Behavior;

use App\Utils\Path;

trait GetComposerConfigurationTrait
{
    /** @return array<mixed> */
    protected function getComposerConfiguration(): array
    {
        $composerJsonFile = Path::getSourceCodePath() . '/composer.json';
        if (is_readable($composerJsonFile) === false) {
            throw new \Exception('File composer.json does not exist.');
        }

        try {
            return json_decode(file_get_contents($composerJsonFile), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            throw new \Exception('Error while parsing composer.json: ' . $e->getMessage());
        }
    }
}
