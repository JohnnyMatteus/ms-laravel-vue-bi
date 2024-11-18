<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\UserRequestRepositoryInterface;
use App\Models\UserRequest;

class UserRequestRepository implements UserRequestRepositoryInterface
{
    /**
     * Retorna as estatísticas de endpoints acessados
     *
     * @return array
     */
    public function getRequestStats(): array
    {
        return UserRequest::query()
            ->selectRaw('endpoint, COUNT(*) as total_count')
            ->groupBy('endpoint')
            ->orderByDesc('total_count')
            ->get()
            ->toArray();
    }

    /**
     * Retorna os detalhes das requisições realizadas
     *
     * @return array
     */
    public function getRequestDetails(): array
    {
        return UserRequest::query()
            ->join('users', 'user_requests.user_id', '=', 'users.id')
            ->select('users.name as user', 'user_requests.endpoint', \DB::raw('COUNT(*) as count'))
            ->groupBy('user_requests.user_id', 'user_requests.endpoint')
            ->orderBy('users.name')
            ->get()
            ->toArray();
    }

    public function logRequest(array $data): void
    {
        // Verifique se já existe uma entrada para este user_id e endpoint
        $request = UserRequest::where('user_id', $data['user_id'])
            ->where('endpoint', $data['endpoint'])
            ->first();

        if ($request) {
            // Atualize o contador
            $request->increment('count');
        } else {
            // Crie um novo registro
            UserRequest::create([
                'user_id' => $data['user_id'],
                'endpoint' => $data['endpoint'],
                'count' => 1,
            ]);
        }
    }

    public function getUserRequestSummary(): array
    {
        $userRequests = UserRequest::select('user_id', 'endpoint', \DB::raw('SUM(count) as total_count'))
            ->groupBy('user_id', 'endpoint')
            ->with('user') // Inclui informações do usuário
            ->get();

        $summary = [];
        foreach ($userRequests as $request) {
            $userId = $request->user_id;
            $summary[$userId]['user'] = [
                'id' => $request->user->id,
                'name' => $request->user->name,
                'email' => $request->user->email,
            ];
            $summary[$userId]['requests'][] = [
                'endpoint' => $request->endpoint,
                'total_count' => (int) $request->total_count,
            ];
        }

        return array_values($summary);
    }
}

