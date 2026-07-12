@props(['title', 'description' => null, 'breadcrumbs' => []])

<div class="mb-6 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
    <div>
        @if(!empty($breadcrumbs))
            <nav class="text-sm font-medium text-gray-500 mb-2" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex flex-wrap items-center gap-2">
                    @foreach($breadcrumbs as $breadcrumb)
                        @if(!$loop->last)
                            <li class="flex items-center">
                                @if(isset($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}" class="hover:text-[#1A2B56] transition-colors">{{ $breadcrumb['label'] }}</a>
                                @else
                                    <span>{{ $breadcrumb['label'] }}</span>
                                @endif
                                <svg class="fill-current w-3 h-3 mx-2 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                            </li>
                        @else
                            <li class="flex items-center text-[#1A2B56] font-semibold" aria-current="page">
                                {{ $breadcrumb['label'] }}
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif
        
        <h1 class="text-2xl font-bold text-[#1A2B56]">{{ $title }}</h1>
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
