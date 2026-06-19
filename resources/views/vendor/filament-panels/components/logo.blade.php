@php
use Illuminate\Support\Arr;

$brandName = filament()->getBrandName();
$brandLogo = filament()->getBrandLogo();
$brandLogoHeight = filament()->getBrandLogoHeight() ?? '1.5rem';
$darkModeBrandLogo = filament()->getDarkModeBrandLogo();
$hasDarkModeBrandLogo = filled($darkModeBrandLogo);

$getLogoClasses = fn (bool $isDarkMode): string => Arr::toCssClasses([
'fi-logo',
'fi-logo-light' => $hasDarkModeBrandLogo && (! $isDarkMode),
'fi-logo-dark' => $isDarkMode,
]);

$logoStyles = "height: {$brandLogoHeight}; width: auto; display: block; flex-shrink: 0;";
@endphp

@capture($content, $logo, $isDarkMode = false)
@if ($logo instanceof \Illuminate\Contracts\Support\Htmlable)
<div
    {{
                $attributes
                    ->class([$getLogoClasses($isDarkMode)])
                    ->style([$logoStyles])
            }}>
    {{ $logo }}
</div>
@elseif (filled($logo))
<img
    alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
    src="{{ $logo }}"
    {{
                $attributes
                    ->class([$getLogoClasses($isDarkMode)])
                    ->style([$logoStyles])
            }} />
@else
<div
    {{
                $attributes->class([
                    $getLogoClasses($isDarkMode),
                ])
            }}>
    {{ $brandName }}
</div>
@endif
@endcapture

@if (filled($brandLogo) || filled($brandName))
<div
    class="fi-logo-with-text"
    style="display: inline-flex; align-items: center; justify-content: flex-start; gap: 0.75rem; flex-direction: row; flex-wrap: nowrap; max-width: 100%;">
    @if (filled($brandLogo))
    {{ $content($brandLogo) }}

    @if ($hasDarkModeBrandLogo)
    {{ $content($darkModeBrandLogo, isDarkMode: true) }}
    @endif
    @endif

    @if (filled($brandName))
    <span
        style="display: inline-block; font-size: 0.875rem; font-weight: 600; line-height: 1.1; text-align: left; color: inherit; white-space: normal; max-width: 100%;">
        {{ $brandName }}
    </span>
    @endif
</div>
@endif