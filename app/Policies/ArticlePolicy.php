<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * COMENTÁRIO: Este método é executado ANTES de qualquer outro na Policy.
     * Ele serve para dar acesso total a um tipo de usuário.
     *
     * A lógica agora é: "Se o usuário NÃO for um desenvolvedor, ele é um admin".
     * Se a condição for verdadeira, retornamos 'true' e a verificação para por aqui,
     * concedendo acesso imediato.
     *
     * Se o usuário FOR um desenvolvedor, este método retorna 'null' e o Laravel
     * continua a verificação nos métodos específicos abaixo (update, delete, etc.).
     */
    public function before(User $user, string $ability): bool|null
    {
        if (!$user->isDeveloper()) {
            return true;
        }

        return null;
    }

    /**
     * Determina se o usuário (que é um developer) pode ATUALIZAR o artigo.
     * Esta regra só será executada para desenvolvedores.
     */
    public function update(User $user, Article $article): bool
    {
        // Permite a ação apenas se o ID do usuário logado for igual ao ID do autor do artigo.
        return $user->id === $article->user_id;
    }

    /**
     * Determina se o usuário (que é um developer) pode DELETAR o artigo.
     * Esta regra só será executada para desenvolvedores.
     */
    public function delete(User $user, Article $article): bool
    {
        // A mesma lógica da atualização.
        return $user->id === $article->user_id;
    }

    // Você pode adicionar outros métodos como view, create, etc., se necessário.
}
