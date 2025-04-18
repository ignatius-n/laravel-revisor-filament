<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\Page;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Indra\Revisor\Contracts\HasRevisor;

class PublishTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'publish';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn (HasRevisor $record) => $record->isPublished() ? 'Publish Changes' : 'Publish')
            ->icon(FilamentIcon::resolve('heroicon-o-arrow-up-tray') ?? 'heroicon-o-arrow-up-tray')
            ->color('success')
            ->deselectRecordsAfterCompletion()
            ->modalHeading(function (Model $record, Page $livewire) {
                return 'Publish ' . $livewire::getResource()::getRecordTitle($record);
            })
            ->modalIcon(FilamentIcon::resolve('heroicon-o-arrow-up-tray') ?? 'heroicon-o-arrow-up-tray')
            ->modalIconColor('success')
            ->modalDescription(fn () => 'Are you sure you want to publish this page?')
            ->modalAlignment(Alignment::Center)
            ->modalFooterActionsAlignment(Alignment::Center)
            ->modalSubmitActionLabel(__('filament-actions::modal.actions.confirm.label'))
            ->modalWidth(MaxWidth::Medium)
            ->hidden(fn (HasRevisor $record) => ! $record->isUnpublishedOrRevised())
            ->action(function (HasRevisor $record, array $data) {
                $record->publish();
                $this->success();
            })
            ->successNotificationTitle(fn () => $this->getModelLabel() . ' published successfully');
    }
}
