<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow overflow-hidden']) }}>
    <div class="w-full overflow-x-auto overscroll-x-contain">
        {{ $slot }}
    </div>
</div>
