<?php

namespace App\Providers\Filament;

use App\Filament\Home\Pages\Home;
use App\Filament\Home\Widgets\HomeStatusAllVillageChart;
use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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

class HomePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('home')
            ->path('/')
            ->viteTheme('resources/css/filament/home/theme.css')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigation(false)
            ->brandName('Indeks Desa Kabupaten Lebak')
            ->brandLogo(asset('images/logo-lebak.png'))
            ->favicon(asset('images/logo-lebak.png'))
            ->discoverResources(in: app_path('Filament/Home/Resources'), for: 'App\Filament\Home\Resources')
            ->discoverPages(in: app_path('Filament/Home/Pages'), for: 'App\Filament\Home\Pages')
            ->pages([
                Home::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Home/Widgets'), for: 'App\Filament\Home\Widgets')
            ->widgets([
                HomeStatusAllVillageChart::class,
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
            ->assets([
                Js::make('chartjs-plugin-datalabels', Vite::asset('resources/js/app.js'))->module(),

            ])
            ->plugins([
                EasyFooterPlugin::make()
                    ->withSentence('Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Lebak')
                    ->withLoadTime('This page loaded in')
                    ->withLogo(
                        asset('images/logo-lebak.png'),
                        'https://dpmd.lebakkab.go.id/'
                    )
                    ->withBorder(),
            ])
        ;
    }
}
