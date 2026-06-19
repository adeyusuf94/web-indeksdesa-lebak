<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\StatusAllVillageChart;
use App\Filament\Widgets\StatusAllVillageTableWidget;
use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use JeffersonGoncalves\Filament\Umami\UmamiPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->profile(isSimple: false)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->brandName('Indeks Desa Kabupaten Lebak')
            ->brandLogo(asset('images/logo-lebak.png'))
            ->favicon(asset('images/logo-lebak.png'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                StatusAllVillageChart::class,
                StatusAllVillageTableWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->assets([
                Js::make('chartjs-plugin-datalabels', Vite::asset('resources/js/app.js'))->module(),

            ])
            ->plugins([
                UmamiPlugin::make()
                    ->settingsPage(true),
                EasyFooterPlugin::make()
                    ->withSentence('Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Lebak')
                    ->withLoadTime('This page loaded in')
                    ->withLogo(
                        'https://lebakkab.go.id/wp-content/uploads/2018/09/cropped-www.lebakkab.go_.id-theme-image-logo-square-400x400.png',
                        'https://dpmd.lebakkab.go.id/'
                    )
                    ->withBorder()
                // ->hiddenFromPagesEnabled()
                // ->hiddenFromPages(['admin/login']),
            ])
        ;
    }
}
