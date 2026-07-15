@props(['title', 'description' => null, 'breadcrumbs' => []])

<div class="mb-6 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
    <div>
        <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs" />
        
        <h1 class="text-2xl font-bold text-[#102b70]">{{ $title }}</h1>
        @if($description)
            <p class="text-sm text-gray-500 mt-1">{{ $description }}</p>
        @endif
    </div>
    
    @if(isset($actions))
        <div class="flex flex-wrap items-center gap-2 sm:mt-0 mt-2">
            {{ $actions }}
        </div>
    @endif
</div>
