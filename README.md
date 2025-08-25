# Projeto CRUD Artigo (Laravel + Livewire)

## Sobre o projeto:

🚀 Esse projeto foi criado como intuito de avaliar o domínio, boas práticas em Laravel, Livewire, UX responsivo, CSS, testes e versionamentos.

📋 ## Requitos Básicos:

    -> Windows
    -> Laravel Herd (https://herd.laravel.com/windows).
    -> Composer (https://getcomposer.org/download/).
    -> Node.js (Para comandos NPM) - (https://nodejs.org/en/download).

🔧 ### Comandos para instalação:

    ** Instalação do Laravel **
```
composer global require laravel/installer
```
    ** Instalação do Pacote Livewire **
```
composer require livewire/livewire
```
    ** Instalação das dependencias com npm **
```
npm install
```
    ** Instalação do Breeze (Usado para autenticação) **
```
composer require laravel/breeze --dev
```

```
php artisan breeze:install
```

📦 ### Documentações úteis:
    
    -> Laravel - https://laravel.com/docs/12.x/installation
    -> Livewire - https://livewire.laravel.com/docs/quickstart
    -> Render - https://render.com/docs
    -> Breeze - https://laravel.com/docs/10.x/starter-kits
    -> Componentes Livewire - https://livewire.laravel.com/docs/components

📌 ### Comandos necessários para o Laravel:

**Criar Database -> Migration** 
```
php artisan make:migration <nome_da_tabela>
```
**Criar Models -> Model**
```
php artisan make:model <nome da model>
```
**Criar Componente Livewire**
```
php artisan make:livewire <nome do componente>
```
 **Quando cria um componente usando "php artisan make:livewire <nome do componente>", automaticamente entende-se que uma view deve ser gerada com o mesmo nome**
    -> **Ex de onde encontrar: resources/views/livewire/nome-do-componente.blade.php** 
    
📄 ## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
