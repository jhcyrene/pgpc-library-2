<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group cursor-default">
    <p class="text-xs font-bold text-slate-500 mb-2 uppercase tracking-wide group-hover:text-blue-600 transition-colors">
        {{ $title ?? 'Default Title' }}
    </p>
    <h4 class="text-3xl font-black text-slate-900 mb-0.5 tracking-tight">{{ $value ?? '0' }}</h4>
    <p class="text-xs font-medium text-slate-400">{{ $description ?? 'No description' }}</p>
</div>