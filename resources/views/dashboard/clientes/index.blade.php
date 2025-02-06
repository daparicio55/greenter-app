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
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-700">
                                    Acciones
                                </th>
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
                                </x-admin.table-tr>

                            @endforeach
                            <x-admin.table-tr>
                                <td class="">Juan Pérez</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-200">juan@example.com</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-200">Usuario</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Activo
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button
                                        class="px-3 py-1 text-sm font-medium text-white bg-gray-700 rounded-md hover:bg-gray-800 focus:ring-2 focus:ring-gray-500">
                                        Editar
                                    </button>
                                    <button
                                        class="px-3 py-1 text-sm font-medium text-white bg-gray-800 rounded-md hover:bg-gray-900 focus:ring-2 focus:ring-gray-600">
                                        Eliminar
                                    </button>
                                </td>
                            </x-admin.table-tr>
                            
                        </x-slot>

                    </x-admin.table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>