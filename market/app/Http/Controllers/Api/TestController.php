<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/test",
     *     summary="Тестовый endpoint",
     *     tags={"Test"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="API работает!"),
     *             @OA\Property(property="timestamp", type="string", example="2025-11-20 18:00:00")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'message' => 'API работает!',
            'timestamp' => now()
        ]);
    }

    /**
     * Получить пользователя по ID
     * Scramble автоматически определит тип параметра!
     */
    public function show(int $id)
    {
        return response()->json([
            'id' => $id,
            'name' => 'Тестовый пользователь ' . $id,
            'email' => "user{$id}@example.com",
            'created_at' => now(),
        ]);
    }

    /**
     * Создать нового пользователя
     * Scramble увидит Request и покажет все поля валидации!
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'age' => 'nullable|integer|min:18|max:100',
            'is_active' => 'boolean',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Пользователь создан',
            'data' => $validated,
        ], 201);
    }

    /**
     * Обновить пользователя
     * PUT запрос с параметром
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'age' => 'nullable|integer|min:18',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Пользователь {$id} обновлен",
            'data' => $validated,
        ]);
    }

    /**
     * Удалить пользователя
     */
    public function destroy(int $id)
    {
        return response()->json([
            'success' => true,
            'message' => "Пользователь {$id} удален",
        ]);
    }

    /**
     * Поиск пользователей с фильтрами
     * Query параметры
     */
    public function search(Request $request)
    {
        $name = $request->query('name', '');
        $age = $request->query('age', null);
        $limit = $request->query('limit', 10);

        return response()->json([
            'filters' => [
                'name' => $name,
                'age' => $age,
                'limit' => $limit,
            ],
            'results' => [
                ['id' => 1, 'name' => 'Иван', 'age' => 25],
                ['id' => 2, 'name' => 'Мария', 'age' => 30],
            ],
            'total' => 2,
        ]);
    }
}
