<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Datos de Cliente
        </h2>
        <x-admin.link-secondary route="dashboard.clientes.index" class="mt-2">
            Regresar
        </x-admin.link-secondary>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('dashboard.clientes.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Datos del usuario
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">

                            <div>
                                <x-admin.input-text name="name" title="Nombre completo" />                                
                            </div>

                            <div>
                                <x-admin.input-text name="email" title="Correo electrónico" type="email" />
                            </div>                          

                            <div>
                                <x-admin.input-text name="password" title="Contraseña" type="password" />
                            </div>

                            <div>
                                <x-admin.input-text name="password_confirmation" title="Confirmar contraseña" type="password" />
                            </div>                           

                        </div>

                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-3">
                            Datos de la empresa
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-3">

                            <div class="col-span-3 sm:col-span-2">
                                <x-admin.input-text name="razon_social" title="Razón social" />
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <x-admin.input-text name="ruc" title="RUC" />
                            </div>

                            <div class="col-span-3">
                                <x-admin.input-text name="direccion" title="Dirección" />
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <x-admin.input-text name="sol_user" title="Usuario SOL" />
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <x-admin.input-text name="sol_pass" title="Contraseña SOL" type="password" />
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <x-admin.input-text name="sol_pass_confirmation" title="Confirmar contraseña SOL" type="password" />
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <x-admin.input-text name="client_id" title="ID Cliente" />
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <x-admin.input-text name="client_secret" title="Secret Cliente" />
                            </div>

                            <div class="col-span-3 sm:col-span-1 flex items-end">
                                <x-admin.input-check name="production" label="En producción" />
                            </div>

                            
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">

                            <div>
                                <x-admin.input-file name="logo" title="Logo" />
                            </div>

                            <div>
                                <x-admin.input-file name="cert" title="Certificado" />
                            </div>

                        </div>

                        <div class="mt-2 flex justify-end p-4">
                            <div>
                                <x-admin.button-save />
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    

</x-app-layout>