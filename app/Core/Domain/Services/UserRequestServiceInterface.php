<?php

namespace App\Core\Domain\Services;

interface UserRequestServiceInterface
{
    /**
     * Registra uma consulta do usuário.
     *
     * @param string $userId
     * @param string $endpoint
     * @return void
     */
    public function logRequest(string $userId, string $endpoint): void;

    /**
     * Obtém o resumo das consultas realizadas.
     *
     * @return array
     */
    public function getRequestSummary(): array;
}

