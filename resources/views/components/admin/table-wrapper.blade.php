<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow overflow-hidden']) }}>
    <div class="responsive-table-scroll" tabindex="0" role="region" aria-label="Scrollable table">
        {{ $slot }}
    </div>
</div>
