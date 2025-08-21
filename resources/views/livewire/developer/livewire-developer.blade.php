<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Desenvolvedores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-sm sm:rounded-lg mx-4">
                <div class="flex justify-between items-center ">
                    <h2 class="text-2xl font-semibold text-gray-800">Gerenciar Desenvolvedores</h2>
                    <button wire:click="create()"
                        class="bg-indigo-400 hover:bg-indigo-500 text-white font-bold py-2 px-4 ml-4 rounded-lg shadow-md transition ease-in-out duration-150">
                        Novo Desenvolvedor
                    </button>
                </div>

                <!-- CAMPO DE BUSCA -->
                <div class="mx-4 mt-4">
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Buscar por nome, email ou senioridade..."
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- O formulário só é incluído e renderizado se a variável $isOpen for verdadeira -->
                <div class="mt-6">
                    @if ($isOpen)
                        @include('livewire.developer.livewire-developer-form')
                    @endif
                </div>

                        <table class="min-w-full divide-y divide-gray-200 mt-6">
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
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tag's</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($developers as $developer)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $developer->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $developer->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $developer->senority }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ implode(', ', $developer->tags) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button wire:click="edit({{ $developer->id }})"
                                                class="text-indigo-600 hover:text-indigo-900">Editar</button>
                                            <button wire:click="delete({{ $developer->id }})"
                                                class="text-red-600 hover:text-red-900 ml-4">Deletar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $developers->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
