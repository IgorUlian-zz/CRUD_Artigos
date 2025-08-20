<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Artigos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white shadow-sm sm:rounded-lg">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Cadastro de Artigos</h2>

                    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                        aria-modal="true">
                        <div
                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <!-- Fundo do Modal -->
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
                            </div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                aria-hidden="true">&#8203;</span>

                            <!-- Conteúdo do Modal -->
                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <form>
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="mb-4">
                                            <label for="title"
                                                class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                                            <input type="text"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="title" wire:model="title">
                                            @error('title')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="content"
                                                class="block text-gray-700 text-sm font-bold mb-2">Conteúdo:</label>
                                            <textarea
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                id="content" wire:model="content"></textarea>
                                            @error('content')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Campo de Upload de Imagem -->
                                        <div class="mb-4">
                                            <label for="newImage"
                                                class="block text-gray-700 text-sm font-bold mb-2">Imagem do
                                                Artigo:</label>
                                            <input type="file"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                                                id="newImage" wire:model="newImage">
                                            <div wire:loading wire:target="newImage" class="text-sm text-gray-500 mt-1">
                                                Carregando...</div>
                                            @error('newImage')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror

                                            <!-- Preview da Imagem -->
                                            @if ($newImage)
                                                <img src="{{ $newImage->temporaryUrl() }}"
                                                    class="mt-2 h-20 w-20 object-cover rounded">
                                            @elseif ($image)
                                                <img src="{{ asset('storage/' . $image) }}"
                                                    class="mt-2 h-20 w-20 object-cover rounded">
                                            @endif
                                        </div>

                                        <!-- Campo de Upload de HTML -->
                                        <div class="mb-4">
                                            <label for="newHtmlFile"
                                                class="block text-gray-700 text-sm font-bold mb-2">Arquivo HTML:</label>
                                            <input type="file"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                                                id="newHtmlFile" wire:model="newHtmlFile">
                                            <div wire:loading wire:target="newHtmlFile"
                                                class="text-sm text-gray-500 mt-1">Carregando...</div>
                                            @error('newHtmlFile')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror

                                            @if ($html_file_path)
                                                <p class="text-sm text-gray-600 mt-2">Arquivo atual: <a
                                                        href="{{ asset('storage/' . $html_file_path) }}" target="_blank"
                                                        class="text-blue-500 hover:underline">Ver HTML</a></p>
                                            @endif
                                        </div>

                                        <div class="mb-4">
                                            <label
                                                class="block text-gray-700 text-sm font-bold mb-2">Desenvolvedores:</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                @foreach ($allDevelopers as $developer)
                                                    <div>
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox" class="form-checkbox"
                                                                value="{{ $developer->id }}"
                                                                wire:model="selectedDevelopers">
                                                            <span class="ml-2">{{ $developer->name }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button wire:click.prevent="store()" type="button"
                                            class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                            Salvar
                                        </button>
                                        <button wire:click="closeModal()" type="button"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
