@props([
'heading' => null,
'logo' => true,
'subheading' => null,
])

@php
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

$brandName = filament()->getBrandName();
$brandLogo = filament()->getBrandLogo();
$brandLogoHeight = filament()->getBrandLogoHeight() ?? '1.5rem';
$darkModeBrandLogo = filament()->getDarkModeBrandLogo();
$hasDarkModeBrandLogo = filled($darkModeBrandLogo);
$isLoginPage = Route::currentRouteName() === 'filament.admin.auth.login';

$getLogoClasses = fn (bool $isDarkMode): string => Arr::toCssClasses([
'fi-logo',
'fi-logo-light' => $hasDarkModeBrandLogo && (! $isDarkMode),
'fi-logo-dark' => $isDarkMode,
]);

$logoStyles = "height: 7rem; width: auto; display: block; flex-shrink: 0; justify-self: center;";
@endphp

<header class="fi-simple-header">
    @if ($logo)
    @if ($isLoginPage)
    @capture($content, $logoImage, $isDarkMode = false)
    @if ($logoImage instanceof \Illuminate\Contracts\Support\Htmlable)
    <div
        {{
                            $attributes
                                ->class([$getLogoClasses($isDarkMode)])
                                ->style([$logoStyles])
                        }}>
        {{ $logoImage }}
    </div>
    @elseif (filled($logoImage))
    <img
        alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
        src="{{ $logoImage }}"
        {{
                            $attributes
                                ->class([$getLogoClasses($isDarkMode)])
                                ->style([$logoStyles])
                        }} />
    @endif
    @endcapture

    @if (filled($brandLogo) || filled($brandName))
    <div @class="flex flex-col items-center gap-4 text-center">
        @if (filled($brandLogo))
        {{ $content($brandLogo) }}

        @if ($hasDarkModeBrandLogo)
        {{ $content($darkModeBrandLogo, isDarkMode: true) }}
        @endif
        @endif

        @if (filled($brandName))
        <span style="font-size: 1.25rem; font-weight: 800; line-height: 1.2; color: inherit;">
            {{ $brandName }}
        </span>
        @endif
    </div>
    @endif
    @else
    <x-filament-panels::logo />
    @endif
    @endif

    @if (filled($heading))
    <h1 class="fi-simple-header-heading" style="margin-top: 1rem;">
        {{ $heading }}
    </h1>
    @endif

    @if (filled($subheading))
    <p class="fi-simple-header-subheading">
        {{ $subheading }}
    </p>
    @endif
</header>