<?php

namespace App\Core\Domain\Repositories;

interface UserRequestRepositoryInterface
{
    /**
     * Retorna as estatísticas de endpoints acessados
     *
     * @return array
     */
    public function getRequestStats(): array;

    /**
     * Retorna os detalhes das requisições realizadas
     *
     * @return array
     */
    public function getRequestDetails(): array;
    public function logRequest(array $data): void;
    /**
     * Retorna os resumos de requisições do usuário no formato esperado.
     *
     * @return array
     */
    public function getUserRequestSummary(): array;
}
