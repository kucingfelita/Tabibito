@foreach($reviews as $review)
    <div class="py-6 border-b border-slate-100 last:border-b-0">
        <div class="flex gap-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-slate-100 to-slate-200 flex items-center justify-center font-bold text-slate-600 uppercase shrink-0 text-sm">
                {{ substr($review->user->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-bold text-slate-800">{{ $review->user->name }}</p>
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 font-extrabold text-[8px] uppercase tracking-wider flex items-center gap-1"><i class="fa-solid fa-circle-check"></i> Terverifikasi</span>
                        </div>
                        <p class="text-[10px] text-slate-400 font-semibold mt-0.5">{{ $review->updated_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                        @endfor
                    </div>
                </div>
                
                @if($review->review_comment)
                    <p class="text-slate-600 text-sm leading-relaxed mt-2.5">{{ $review->review_comment }}</p>
                @endif

                @if($review->review_image)
                    <div class="mt-3 flex gap-2">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden border border-slate-100 shadow-sm bg-slate-50">
                            <a href="{{ asset('storage/' . $review->review_image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $review->review_image) }}" 
                                     alt="Foto ulasan oleh {{ $review->user->name }}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
