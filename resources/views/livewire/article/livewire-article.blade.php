<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Artigos') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="p-6 bg-white shadow-sm sm:rounded-lg mx-4">
                    <div class="flex justify-between items-center ">
                        <h2 class="text-2xl font-semibold text-gray-800">Gerenciar Artigos</h2>
                        <button wire:click="create()"
                            class="bg-indigo-400 hover:bg-indigo-500 text-white font-bold py-2 px-4 ml-4 rounded-lg shadow-md transition ease-in-out duration-150">
                            Novo Artigo
                        </button>
                    </div>

                    <!-- CAMPO DE BUSCA -->
                    <div class="mx-4 mt-4">
                        <input wire:model.live.debounce.300ms="search" type="text"
                            placeholder="Buscar por título, data (AAAA-MM-DD) ou desenvolvedor..."
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- O formulário só é incluído e renderizado se a variável $isOpen for verdadeira -->
                    <div class="mt-6">
                        @if ($isOpen)
                            @include('livewire.article.livewire-article-form')
                        @endif
                    </div>

                    <!-- Mensagem de sucesso -->
                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 mt-6">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Artigo</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Arquivo (HTML)</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Desenvolvedores</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Data de Adição</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($articles as $article)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if ($article->image)
                                                        <img class="h-10 w-10 rounded-full object-cover"
                                                            src="{{ asset('storage/' . $article->image) }}"
                                                            alt="{{ $article->title }}">
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $article->title }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($article->html_file)
                                                <a href="{{ asset('storage/' . $article->html_file) }}" target="_blank"
                                                    class="text-indigo-600 hover:text-indigo-900">Ver Ficheiro</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @foreach ($article->developers as $developer)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $developer->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $article->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button wire:click="edit({{ $article->id }})"
                                                class="text-indigo-600 hover:text-indigo-900 px-3 py-1 border border-indigo-200 rounded-md hover:border-indigo-400 transition">Editar</button>
                                            <button wire:click="delete({{ $article->id }})"
                                                class="text-red-600 hover:text-red-900 ml-4">Deletar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
