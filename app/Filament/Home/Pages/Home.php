<?php

namespace App\Filament\Home\Pages;

use App\Filament\Home\Widgets\HomeStatusAllVillageChart;
use App\Filament\Home\Widgets\HomeStatusAllVillageStatOverview;
use App\Filament\Home\Widgets\HomeStatusAllVillageTableWidget;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Home extends Page
{
    protected string $view = 'filament.home.pages.home';

    protected static ?string $title = 'Indeks Desa Kabupaten Lebak';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('login')
                ->label(Auth::check() ? 'Dashboard' : 'Login')
                ->url(Route::has('admin') ? route('admin') : '/admin')
                ->icon(Heroicon::ArrowRightStartOnRectangle)
                ->color(Auth::check() ? 'info' : 'danger'),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            HomeStatusAllVillageStatOverview::class,
            HomeStatusAllVillageChart::class,
            HomeStatusAllVillageTableWidget::class,
        ];
    }

    // protected function getNavigationItem(): ?NavigationItem
    // {
    //     return null; // Menyembunyikan halaman ini dari navigasi
    // }
}
