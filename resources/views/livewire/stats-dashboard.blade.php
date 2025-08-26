<div class="text-gray-900 dark:text-gray-100">
    <!-- Seção de Contagens Totais -->
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Estatísticas Gerais</h3>
    <div class="flex flex-wrap gap-4">
        <!-- Badge Desenvolvedores -->
        <span
            class="inline-flex items-center rounded-md bg-indigo-100 dark:bg-indigo-900/50 px-3 py-2 text-sm font-medium text-indigo-700 dark:text-indigo-300 ring-1 ring-inset ring-indigo-200 dark:ring-indigo-700">
            Total de Desenvolvedores:
            <strong class="ml-2">{{ $developerCount }}</strong>
        </span>

        <!-- Badge Artigos -->
        <span
            class="inline-flex items-center rounded-md bg-indigo-100 dark:bg-indigo-900/50 px-3 py-2 text-sm font-medium text-indigo-700 dark:text-indigo-300 ring-1 ring-inset ring-indigo-200 dark:ring-indigo-700">
            Total de Artigos:
            <strong class="ml-2">{{ $articleCount }}</strong>
        </span>

        <!-- Badge Utilizadores -->
        <span
            class="inline-flex items-center rounded-md bg-purple-100 dark:bg-purple-900/50 px-3 py-2 text-sm font-medium text-purple-700 dark:text-purple-300 ring-1 ring-inset ring-purple-200 dark:ring-purple-700">
            Total de Utilizadores:
            <strong class="ml-2">{{ $userCount }}</strong>
        </span>
    </div>
    <hr class="my-6 border-gray-200 dark:border-gray-700 mt-6">

    <!-- Seção de Artigos por Desenvolvedor -->
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 mt-6">Artigos por Desenvolvedor</h3>
    <div class="flex flex-wrap gap-4">
        @foreach ($developersWithArticleCount as $developer)
            <span
                class="inline-flex items-center rounded-md bg-green-100 dark:bg-green-900/50 px-3 py-2 text-sm font-medium text-green-700 dark:text-green-300 ring-1 ring-inset ring-green-200 dark:ring-green-700">
                {{ $developer->user->name }}:
                <strong class="ml-2">{{ $developer->articles_count }} artigos</strong>
            </span>
        @endforeach
    </div>
</div>
