<?php

namespace Inmanturbo\Signal;

use Illuminate\Contracts\Support\Responsable;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Spatie\LaravelData\Concerns\AppendableData;
use Spatie\LaravelData\Concerns\BaseData;
use Spatie\LaravelData\Concerns\ContextableData;
use Spatie\LaravelData\Concerns\EmptyData;
use Spatie\LaravelData\Concerns\IncludeableData;
use Spatie\LaravelData\Concerns\ResponsableData;
use Spatie\LaravelData\Concerns\TransformableData;
use Spatie\LaravelData\Concerns\ValidateableData;
use Spatie\LaravelData\Concerns\WrappableData;
use Spatie\LaravelData\Contracts\AppendableData as AppendableDataContract;
use Spatie\LaravelData\Contracts\BaseData as BaseDataContract;
use Spatie\LaravelData\Contracts\EmptyData as EmptyDataContract;
use Spatie\LaravelData\Contracts\IncludeableData as IncludeableDataContract;
use Spatie\LaravelData\Contracts\ResponsableData as ResponsableDataContract;
use Spatie\LaravelData\Contracts\TransformableData as TransformableDataContract;
use Spatie\LaravelData\Contracts\ValidateableData as ValidateableDataContract;
use Spatie\LaravelData\Contracts\WrappableData as WrappableDataContract;

abstract class EventWithData extends ShouldBeStored implements AppendableDataContract, BaseDataContract, EmptyDataContract, IncludeableDataContract, Responsable, ResponsableDataContract, TransformableDataContract, ValidateableDataContract, WrappableDataContract
{
    use AppendableData;
    use BaseData;
    use ContextableData;
    use EmptyData;
    use IncludeableData;
    use ResponsableData;
    use TransformableData;
    use ValidateableData;
    use WrappableData;
}
