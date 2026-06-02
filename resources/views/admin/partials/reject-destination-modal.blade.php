{{-- Modal tolak destinasi: konfirmasi + alasan wajib (fixed ke viewport, tengah layar) --}}
<div id="reject-destination-modal"
     class="modal-root hidden items-center justify-center p-4 sm:p-6"
     role="dialog"
     aria-modal="true"
     aria-labelledby="reject-destination-title"
     aria-hidden="true">
    <div class="modal-root-backdrop bg-slate-900/60 backdrop-blur-sm" data-reject-modal-close></div>

    <div class="modal-root-panel bg-white rounded-[2rem] border border-slate-100 shadow-2xl w-full max-w-md p-6 md:p-8 mx-auto">
        <button type="button" class="absolute top-4 right-4 w-9 h-9 rounded-xl bg-slate-50 text-slate-500 hover:bg-slate-100 flex items-center justify-center" data-reject-modal-close aria-label="Tutup">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 mb-4">
            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
        </div>
        <h3 id="reject-destination-title" class="text-lg font-black text-slate-900">Tolak Destinasi?</h3>
        <p class="text-sm text-slate-500 font-semibold mt-1">
            <span id="reject-destination-name" class="text-slate-800"></span> — owner akan menerima email berisi alasan penolakan.
        </p>

        <form id="reject-destination-form" method="POST" class="mt-6 space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label for="rejection_reason" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alasan penolakan <span class="text-rose-500">*</span></label>
                <textarea id="rejection_reason" name="rejection_reason" required minlength="10" maxlength="500" rows="4"
                          placeholder="Contoh: Foto cover kurang jelas, alamat tidak lengkap, atau deskripsi tidak sesuai ketentuan."
                          class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-400 outline-none resize-none"></textarea>
                <p class="text-[10px] text-slate-400 mt-1">Minimal 10 karakter, maksimal 500.</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" data-reject-modal-close
                        class="flex-1 py-3 rounded-xl border border-slate-100 text-slate-600 font-extrabold text-xs uppercase tracking-wider hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-rose-200">
                    Ya, Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('reject-destination-modal');
    const form = document.getElementById('reject-destination-form');
    const nameEl = document.getElementById('reject-destination-name');
    const reasonEl = document.getElementById('rejection_reason');
    if (!modal || !form) return;

    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    window.openRejectDestinationModal = function (actionUrl, destinationName) {
        form.action = actionUrl;
        nameEl.textContent = destinationName || 'Destinasi ini';
        reasonEl.value = '';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        reasonEl.focus();
    };

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    modal.querySelectorAll('[data-reject-modal-close]').forEach(function (el) {
        el.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('flex')) closeModal();
    });
})();
</script>
