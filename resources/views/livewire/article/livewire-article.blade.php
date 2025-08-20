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
                    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Gerenciar Artigos</h2>

                    <!-- Botão que abre o modal do formulário -->
                    <button wire:click="create()" class="bg-black-500 ">
                        Novo Artigo
                    </button>

                    <!-- O formulário só é incluído e renderizado se a variável $isOpen for verdadeira -->
                    @if($isOpen)
                        @include('livewire.article.livewire-article-form')
                    @endif

                    <!-- Mensagem de sucesso -->
                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4" role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif

                    <!-- Tabela de Artigos -->
                    <table class="min-w-full divide-y divide-gray-200 mt-6">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $article->title }}</td>
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
            </div>
        </div>
    </div>
</div>
