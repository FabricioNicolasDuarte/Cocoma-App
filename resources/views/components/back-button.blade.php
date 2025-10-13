

@if (!request()->is('dashboard') && !request()->is('/'))

    <button
        onclick="window.history.back();"
        aria-label="Volver a la página anterior"


        class="
            fixed
            top-1/2
            -translate-y-1/2
            left-8
            z-50
            flex
            items-center
            justify-center
            w-14
            h-14
            bg-gray-800
            text-white
            rounded-full
            shadow-lg
            hover:bg-cyan-600
            focus:outline-none
            focus:ring-2
            focus:ring-offset-2
            focus:ring-cyan-500
            transition-all
            duration-300
            ease-in-out
        "
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
    </button>

@endif
