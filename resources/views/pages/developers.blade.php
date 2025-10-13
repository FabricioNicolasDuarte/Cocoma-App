<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Equipo de Desarrollo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

                <!-- Tarjeta: yo-->
                <div class="bg-slate-800/60 backdrop-blur-sm border border-slate-700 rounded-lg p-8 text-center transition-transform transform hover:scale-105 hover:shadow-cyan-500/20 shadow-lg flex flex-col items-center">
                    <img class="w-36 h-36 rounded-full mx-auto mb-4 border-4 border-slate-600 object-cover" src="{{ asset('images/team/duarte.jpg') }}" alt="Foto de Duarte Fabricio">
                    <h3 class="text-2xl font-bold text-white">Duarte Fabricio</h3>
                    <p class="text-cyan-400 font-semibold mb-6">Líder del Proyecto</p>

                    <!-- Iconos de Redes Sociales -->
                    <div class="flex justify-center space-x-6 mt-auto">
                        <a href="https://wa.me/3704022201" target="_blank" rel="noopener noreferrer" title="WhatsApp" class="text-gray-400 hover:text-green-500 transition-colors duration-300">
                            <i class="fa-brands fa-whatsapp fa-2x"></i>
                        </a>
                        <a href="mailto:fabricioduarteoficial@gmail.com" title="Correo" class="text-gray-400 hover:text-red-500 transition-colors duration-300">
                            <i class="fa-solid fa-envelope fa-2x"></i>
                        </a>
                        <a href="https://www.instagram.com/fabricionicolasduarte" target="_blank" rel="noopener noreferrer" title="Instagram" class="text-gray-400 hover:text-pink-500 transition-colors duration-300">
                            <i class="fa-brands fa-instagram fa-2x"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/fabricio-nicolas-duarte-313139113/" target="_blank" rel="noopener noreferrer" title="LinkedIn" class="text-gray-400 hover:text-blue-500 transition-colors duration-300">
                            <i class="fa-brands fa-linkedin fa-2x"></i>
                        </a>
                        <a href="https://github.com/FabricioNicolasDuarte" target="_blank" rel="noopener noreferrer" title="GitHub" class="text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fa-brands fa-github fa-2x"></i>
                        </a>
                    </div>
                </div>

                <!-- Tarjeta: Enzo -->
                <div class="bg-slate-800/60 backdrop-blur-sm border border-slate-700 rounded-lg p-8 text-center transition-transform transform hover:scale-105 hover:shadow-cyan-500/20 shadow-lg flex flex-col items-center">
                    <img class="w-36 h-36 rounded-full mx-auto mb-4 border-4 border-slate-600 object-cover" src="{{ asset('images/team/ascona.jpg') }}" alt="Foto de Ascona Enzo">
                    <h3 class="text-2xl font-bold text-white">Ascona Enzo</h3>
                    <p class="text-cyan-400 font-semibold mb-6">Backend y Testing</p>

                    <!-- Iconos de Redes Sociales -->
                     <div class="flex justify-center space-x-6 mt-auto">
                        <a href="https://wa.me/3705005983" target="_blank" rel="noopener noreferrer" title="WhatsApp" class="text-gray-400 hover:text-green-500 transition-colors duration-300">
                            <i class="fa-brands fa-whatsapp fa-2x"></i>
                        </a>
                        <a href="mailto:Asconaenzo@gmail.com" title="Correo" class="text-gray-400 hover:text-red-500 transition-colors duration-300">
                            <i class="fa-solid fa-envelope fa-2x"></i>
                        </a>
                        <a href="https://www.instagram.com/_d.enzo_" target="_blank" rel="noopener noreferrer" title="Instagram" class="text-gray-400 hover:text-pink-500 transition-colors duration-300">
                            <i class="fa-brands fa-instagram fa-2x"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/enzo-ascona-0543321a4" target="_blank" rel="noopener noreferrer" title="LinkedIn" class="text-gray-400 hover:text-blue-500 transition-colors duration-300">
                            <i class="fa-brands fa-linkedin fa-2x"></i>
                        </a>
                        <a href="https://github.com/EnzoAscona6942" target="_blank" rel="noopener noreferrer" title="GitHub" class="text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fa-brands fa-github fa-2x"></i>
                        </a>
                    </div>
                </div>

                <!-- Tarjeta: Seba -->
                <div class="bg-slate-800/60 backdrop-blur-sm border border-slate-700 rounded-lg p-8 text-center transition-transform transform hover:scale-105 hover:shadow-cyan-500/20 shadow-lg flex flex-col items-center">
                    <img class="w-36 h-36 rounded-full mx-auto mb-4 border-4 border-slate-600 object-cover" src="{{ asset('images/team/amarilla.jpg') }}" alt="Foto de Amarilla Sebastián">
                    <h3 class="text-2xl font-bold text-white">Amarilla Sebastián</h3>
                    <p class="text-cyan-400 font-semibold mb-6">Backend</p>

                    <!-- Iconos de Redes Sociales -->
                     <div class="flex justify-center space-x-6 mt-auto">
                        <a href="https://wa.me/3718446935" target="_blank" rel="noopener noreferrer" title="WhatsApp" class="text-gray-400 hover:text-green-500 transition-colors duration-300">
                            <i class="fa-brands fa-whatsapp fa-2x"></i>
                        </a>
                        <a href="mailto:sebaema04@gmail.com" title="Correo" class="text-gray-400 hover:text-red-500 transition-colors duration-300">
                            <i class="fa-solid fa-envelope fa-2x"></i>
                        </a>
                        <a href="https://www.instagram.com/sebaamarilla1" target="_blank" rel="noopener noreferrer" title="Instagram" class="text-gray-400 hover:text-pink-500 transition-colors duration-300">
                            <i class="fa-brands fa-instagram fa-2x"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/sebastian-emanuel-amarilla-755149234" target="_blank" rel="noopener noreferrer" title="LinkedIn" class="text-gray-400 hover:text-blue-500 transition-colors duration-300">
                            <i class="fa-brands fa-linkedin fa-2x"></i>
                        </a>
                        <a href="https://github.com/seba0496" target="_blank" rel="noopener noreferrer" title="GitHub" class="text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fa-brands fa-github fa-2x"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

