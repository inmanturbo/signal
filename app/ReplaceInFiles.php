<?php

namespace Inmanturbo\Signal;

use Inmanturbo\Tandem\Actions\SearchAndReplaceInFiles;
use Inmanturbo\Tandem\Actions\InvokeSearchReplaceInFiles;

class ReplaceInFiles implements HandlesConfigure
{
    protected function replacers(): array
    {
        return [
            SearchAndReplaceInFiles::make(
                'Spatie\EventSourcing\EventSerializers\JsonEventSerializer::class',
                'Inmanturbo\Signal\DataEventSerializer::class',
                config_path(),
            ),
        ];
    }

    public function __invoke(): void
    {
        app(InvokeSearchReplaceInFiles::class)(...$this->replacers());
    }
}
