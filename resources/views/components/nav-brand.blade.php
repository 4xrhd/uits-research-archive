<a {{ $attributes->merge(['class' => 'navbar-brand d-flex align-items-center gap-2 px-2 py-1 rounded-3 transition-all']) }} href="{{ url('/') }}" style="transition: all 0.3s ease;">
    <div class="bg-white rounded p-1 d-flex align-items-center justify-content-center border shadow-sm" style="width: 42px; height: 42px;">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9O_oaL-_otKvO21z50OKE4YS3fBtnp5FYQQ&s" alt="UITS Logo" style="max-height: 100%; max-width: 100%;">
    </div>
    <span class="fw-bold fs-4 tracking-tight" style="color: var(--primary, #0f172a); font-family: 'Outfit', sans-serif;">UITS <span class="text-primary-emphasis">Research</span> Archive</span>
</a>

<style>
    .navbar-brand:hover {
        background-color: rgba(0,0,0,0.03);
        transform: translateY(-1px);
    }
    .navbar-brand:hover .border {
        border-color: var(--accent-color, #2563eb) !important;
    }
</style>

