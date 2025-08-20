<div class="p-6">
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Desenvolvedores') }}
        </h2>
    </x-slot>
    <h2 class="text-2xl font-semibold mb-4">Gerenciar Artigos</h2>
    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
        Novo Artigo
    </button>

    <!-- Inclui o formulário modal -->
    @if($isOpen)
        @include('livewire.article.livewire-article-form')
    @endif

    <!-- Mensagem de sucesso -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Tabela de Artigos -->
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desenvolvedores</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($articles as $article)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="h-10 w-10 rounded-full object-cover">
                    @else
                        <div class="h-10 w-10 rounded-full bg-gray-200"></div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $article->title }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @foreach($article->developers as $developer)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $developer->name }}
                        </span>
                    @endforeach
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button wire:click="edit({{ $article->id }})" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                    <button wire:click="delete({{ $article->id }})" class="text-red-600 hover:text-red-900 ml-4">Deletar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $articles->links() }}
    </div>
</div>


<!-- resources/views/livewire/article-form.blade.php (Modal) -->
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" wire:model="title">
                        @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Conteúdo:</label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="content" wire:model="content"></textarea>
                        @error('content') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>

                    <!-- Campo de Upload de Imagem -->
                    <div class="mb-4">
                        <label for="newImage" class="block text-gray-700 text-sm font-bold mb-2">Imagem do Artigo:</label>
                        <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="newImage" wire:model="newImage">
                        <div wire:loading wire:target="newImage" class="text-sm text-gray-500 mt-1">Carregando...</div>
                        @error('newImage') <span class="text-red-500">{{ $message }}</span>@enderror

                        <!-- Preview da Imagem -->
                        @if ($newImage)
                            <img src="{{ $newImage->temporaryUrl() }}" class="mt-2 h-20 w-20 object-cover rounded">
                        @elseif ($image)
                            <img src="{{ asset('storage/' . $image) }}" class="mt-2 h-20 w-20 object-cover rounded">
                        @endif
                    </div>

                    <!-- Campo de Upload de HTML -->
                    <div class="mb-4">
                        <label for="newHtmlFile" class="block text-gray-700 text-sm font-bold mb-2">Arquivo HTML:</label>
                        <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" id="newHtmlFile" wire:model="newHtmlFile">
                        <div wire:loading wire:target="newHtmlFile" class="text-sm text-gray-500 mt-1">Carregando...</div>
                        @error('newHtmlFile') <span class="text-red-500">{{ $message }}</span>@enderror

                        @if($html_file_path)
                           <p class="text-sm text-gray-600 mt-2">Arquivo atual: <a href="{{ asset('storage/' . $html_file_path) }}" target="_blank" class="text-blue-500 hover:underline">Ver HTML</a></p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Desenvolvedores:</label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($allDevelopers as $developer)
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="form-checkbox" value="{{ $developer->id }}" wire:model="selectedDevelopers">
                                        <span class="ml-2">{{ $developer->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Salvar
                    </button>
                    <button wire:click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
