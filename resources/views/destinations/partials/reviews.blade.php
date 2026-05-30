@foreach($reviews as $review)
    <div class="py-6 border-b border-slate-100 last:border-b-0">
        <div class="flex gap-4">
            <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center font-bold text-slate-500 uppercase shrink-0 text-sm">
                {{ substr($review->user->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold text-slate-800">{{ $review->user->name }}</p>
                        <p class="text-[10px] text-slate-400 font-semibold">{{ $review->updated_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
                
                @if($review->review_comment)
                    <p class="text-slate-600 text-sm leading-relaxed mt-2">{{ $review->review_comment }}</p>
                @endif

                @if($review->review_image)
                    <div class="mt-3 flex gap-2">
                        <div class="w-32 h-32 rounded-2xl overflow-hidden border border-slate-100 shadow-sm bg-slate-50">
                            <a href="{{ asset('storage/' . $review->review_image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $review->review_image) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
