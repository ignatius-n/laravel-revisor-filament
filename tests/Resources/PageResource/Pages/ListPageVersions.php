<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Tests\Resources\PageResource\Pages;

use Indra\RevisorFilament\Filament\ListVersions;
use Indra\RevisorFilament\Tests\Resources\PageResource;

class ListPageVersions extends ListVersions
{
    protected static string $resource = PageResource::class;
}
