<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Desenvolvedores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-semibold text-gray-800">Gerenciar Desenvolvedores</h2>
                        <button wire:click="create()"
                            class="bg-indigo-400 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded-lg shadow-md transition ease-in-out duration-150">
                            Novo Desenvolvedor
                        </button>
                    </div>

                    <!-- CAMPO DE BUSCA -->
                    <div class="mb-4">
                        <input wire:model.live.debounce.300ms="search" type="text"
                            placeholder="Buscar por nome, email ou senioridade..."
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    @if ($isOpen)
                        @include('livewire.developer.livewire-developer-form')
                    @endif

                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif

                    <!-- Wrapper para a tabela responsiva -->
                    <div class="overflow-x-auto mt-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Senioridade</th>
                                    @can('update', new App\Models\User)
                                        <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($developers as $developer)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $developer->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $developer->user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $developer->seniority }}</td>

                                    @can('update', new App\Models\User)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button wire:click="edit({{ $developer->id }})"
                                                    class="text-indigo-600 hover:text-indigo-900 px-3 py-1 border border-indigo-200 rounded-md hover:border-indigo-400 transition">Editar</button>
                                                <button wire:click="delete({{ $developer->id }})"
                                                    class="text-red-600 hover:text-red-900 px-3 py-1 border border-indigo-200 rounded-md hover:border-indigo-400 transition">Deletar</button>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $developers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
