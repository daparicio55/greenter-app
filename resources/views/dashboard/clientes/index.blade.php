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
                    <x-admin.table>
                        <x-slot name="thead">
                            <tr>
                                <x-admin.table-th>
                                    Nombre
                                </x-admin.table-th>
                                <x-admin.table-th>
                                    Email
                                </x-admin.table-th>
                                <x-admin.table-th>
                                    Empresa
                                </x-admin.table-th>
                                <x-admin.table-th>
                                    Produccion
                                </x-admin.table-th>
                                <x-admin.table-th>
                                    Acciones
                                </x-admin.table-th>
                            </tr>
                        </x-slot>

                        <x-slot name="tbody">
                            @foreach ($clientes as $cliente)
                                <x-admin.table-tr>
                                    <x-admin.table-td>
                                        {{ $cliente->name }}
                                    </x-admin.table-td>
                                    <x-admin.table-td>
                                        {{ $cliente->email }}
                                    </x-admin.table-td>
                                    <x-admin.table-td>
                                        {{ $cliente->companies[0]->ruc }} - {{ $cliente->companies[0]->razon_social }}
                                    </x-admin.table-td>
                                    <x-admin.table-td>
                                        
                                        <x-admin.badge :color="$cliente->companies[0]->produccion ? 'green' : 'red'">
                                            {{ $cliente->companies[0]->produccion ? 'Producción' : 'Prueba' }}    
                                        </x-admin.badge>

                                    </x-admin.table-td>
                                    <x-admin.table-td class="gap-2">

                                        <x-admin.link-edit route="{{ route('dashboard.clientes.edit',$cliente->id) }}" >
                                            Editar
                                        </x-admin.link-edit>
                                        <x-admin.modal-delete route="{{ route('dashboard.clientes.destroy',$cliente->id) }}">
                                            <p class="text-sm text-gray-500">
                                                Esta seguro que desea eliminar el cliente {{ $cliente->name }}?
                                            </p>
                                        </x-admin.modal-delete>

                                    </x-admin.table-td>
                                </x-admin.table-tr>

                            @endforeach
                            
                        </x-slot>

                    </x-admin.table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>