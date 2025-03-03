<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\CategoryDTO;
use App\Application\UseCases\Category\CreateCategory;
use App\Application\UseCases\Category\DeleteCategory;
use App\Application\UseCases\Category\GetAllCategory;
use App\Application\UseCases\Category\GetCategory;
use App\Application\UseCases\Category\UpdateCategory;
use App\Infrastructure\Http\Requests\CategoryRequest;
use App\Infrastructure\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class CategoryController
{

    public function __construct(
        private CreateCategory $createCategory,
        private DeleteCategory $deleteCategory,
        private GetCategory $getCategory,
        private GetAllCategory $getAllCategory,
        private UpdateCategory $updateCategory,
    ) {}


    /**
     * Remove the specified resource from storage
     * 
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            if ($this->deleteCategory->execute((int) $id))
                return ApiResponse::success(['message' => 'Category deleted successfully']);

            return ApiResponse::error('Category Not Found', "The category with ID {$id} was not found.", 404);

        } catch (\Throwable $th) {
            return ApiResponse::error('Bad Request', $th->getMessage(), 400);
        }
    }

    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $categories = $this->getAllCategory->execute();

        return ApiResponse::successCollection(
            'categories',
            array_map(fn($c) => 
            [
                'id' => $c['id'], 
                'attributes' => [
                    'name'  => $c['name'],
                ],
            ], 
            $categories)
        );
    }

    /**
     * Display the specified resource.
     * 
     * @param string id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $category = $this->getCategory->execute($id);

        if(!$category)
            return ApiResponse::error('Category Not Found', "The category with ID {$id} was not found.", 404);

        return ApiResponse::successResource(
            'Categories',
            $category->id,
            ['name' => $category->name]
        );
    }

    /**
     * Store a newly created category.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            $categoryDTO = new CategoryDTO(null, $request['data.attributes.name']);
            $category = $this->createCategory->execute($categoryDTO);

            return ApiResponse::successResource(
                'categories',
                (string) $category->id,
                ['name' => $category->name],
                [],
                201
            );
        } catch (\Exception $e) {
            return ApiResponse::error('Category Update Error', $e->getMessage(), 400);
        }
    }

    /**
     * Update an existing category.
     */
    public function update(CategoryRequest $request, string $id): JsonResponse
    {
        try {
            $categoryDTO = new CategoryDTO((int) $request['data.id'], $request['data.attributes.name']);
            $category = $this->updateCategory->execute($id, $categoryDTO);

            if (!$category) {
                return ApiResponse::error('Category Not Found', "Category with ID {$id} not found.", 404);
            }

            return ApiResponse::successResource(
                'Categories',
                $category->id,
                ['name' => $category->name]
            );
        } catch (\Exception $e) {
            return ApiResponse::error('Category Update Error', $e->getMessage(), 400);
        }
    }
}
