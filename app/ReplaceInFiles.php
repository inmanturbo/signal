<?php

namespace Inmanturbo\Signal;

use Inmanturbo\Tandem\Actions\FindAndReplaceInFiles;
use Inmanturbo\Tandem\Actions\InvokeFindReplaceInFiles;

class ReplaceInFiles implements HandlesConfigure
{
    protected function replacers(): array
    {
        return [
            FindAndReplaceInFiles::make(
                'Spatie\EventSourcing\EventSerializers\JsonEventSerializer::class',
                'Inmanturbo\Signal\DataEventSerializer::class',
                config_path(),
            ),
        ];
    }

    public function __invoke(): void
    {
        app(InvokeFindReplaceInFiles::class)(...$this->replacers());
    }
}
