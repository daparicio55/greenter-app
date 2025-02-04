<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lista de Clientes del sistema
        </h2>
        <x-admin.link-primary route="dashboard.clientes.create" class="mt-2">
            Crear Cliente
        </x-admin.link-primary>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($clientes as $cliente)
                        <p class="text-gray-900 dark:text-gray-100">
                            {{ $cliente->name }}
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    

</x-app-layout>