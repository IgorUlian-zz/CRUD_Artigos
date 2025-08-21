<div>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg mx-4">
        <!-- Seção de Contagens Totais -->
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Estatísticas Gerais</h3>
        <!-- Badge Desenvolvedores -->
        <div class="flex flex-wrap gap-4">
            <span
                class="inline-flex items-center rounded-md bg-indigo-400/10 px-3 py-2 text-sm font-medium text-indigo-500 ring-1 ring-inset ring-indigo-400/30">
                Total de Desenvolvedores:
                <strong class="ml-2">{{ $developerCount }}</strong>
            </span>

            <!-- Badge Artigos -->
            <span
                class="inline-flex items-center rounded-md bg-indigo-400/10 px-3 py-2 text-sm font-medium text-indigo-500 ring-1 ring-inset ring-indigo-400/30">
                Total de Artigos:
                <strong class="ml-2">{{ $articleCount }}</strong>
            </span>

            <!-- Badge Utilizadores -->
            <span
                class="inline-flex items-center rounded-md bg-purple-400/10 px-3 py-2 text-sm font-medium text-purple-500 ring-1 ring-inset ring-purple-400/30">
                Total de Utilizadores:
                <strong class="ml-2">{{ $userCount }}</strong>
            </span>
        </div>
        <hr class="my-6 border-gray-200 mt-6">

        <!-- Seção de Artigos por Desenvolvedor -->
        <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Artigos por Desenvolvedor</h3>
        <div class="flex flex-wrap gap-4">
            @foreach ($developersWithArticleCount as $developer)
                <span
                    class="inline-flex items-center rounded-md bg-green-400/10 px-3 py-2 text-sm font-medium text-green-500 ring-1 ring-inset ring-green-500/20">
                    {{ $developer->name }}:
                    <strong class="ml-2">{{ $developer->articles_count }} artigos</strong>
                </span>
            @endforeach
        </div>

    </div>
</div>
</div>
