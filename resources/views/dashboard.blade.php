<x-app-layout>
<x-slot name="header">
    <div class="flex justify-between items-center">

     
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('¡Te damos la bienvenida! ') }}
        </h2>


        <a href="{{ route('projects.create') }}"
            class="
                 px-4 py-2
                bg-gray-900
                text-cyan-400
                font-bold
                rounded-md
                shadow-sm
                border border-cyan-700
                hover:bg-black
                hover:text-cyan-300
                focus:outline-none
                focus:ring-2
                focus:ring-offset-2
                focus:ring-cyan-500
                dark:focus:ring-offset-gray-800
                transition-colors
                duration-200
            "
        >
            Crear Nuevo Proyecto
        </a>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-lg border border-slate-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Empezá a utilizar Cocoma App, con ella podrás gestionar tus proyectos de software de manera eficiente.") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
