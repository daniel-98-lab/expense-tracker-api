<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Category as DomainCategory;
use App\Domain\Interfaces\CategoryRepositoryInterface;
use App\Infrastructure\Models\Category as EloquentCategory;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Deletes a category by its ID.
     *
     * @param int $id The ID of the category to delete.
     * @return bool Returns true if the category was successfully deleted.
     * @throws \Exception If the category with the given ID is not found.
     */
    public function delete(int $id): bool {
        $deleted = EloquentCategory::destroy($id);
        if ($deleted === 0)
            throw new \Exception("Category with ID {$id} not found.");

        return true;
    }

    /**
     * Retrieves all categories from the database.
     *
     * @return DomainCategory[] An array of DomainCategory entities.
     */
    public function getAll(): array {
        return EloquentCategory::orderBy('name')
            ->get()
            ->map(fn($category) => new DomainCategory($category->id, $category->name))
            ->toArray();
    }    

    /**
     * Retrieves a category by its ID.
     *
     * @param int $id The ID of the category to retrieve.
     * @return DomainCategory|null Returns the category if found, or null if not found.
     */
    public function getById(int $id) : ?DomainCategory {
        $category = EloquentCategory::find($id);
        return $category ? new DomainCategory($category->id, $category->name) : null;
    }
 
    /**
     * Creates a new category in the database.
     *
     * @param DomainCategory $category The category entity to create.
     * @return DomainCategory The created category entity.
     */
    public function create(DomainCategory $category): DomainCategory
    {
        $eloquentCategory = new EloquentCategory();
        $eloquentCategory->name = $category->name;
        $eloquentCategory->save();

        return new DomainCategory($eloquentCategory->id, $eloquentCategory->name);
    }

    /**
     * Updates an existing category in the database.
     *
     * @param int $id The ID of the category to update.
     * @param DomainCategory $category The category entity with updated data.
     * @return DomainCategory|null The updated category entity or null if not found.
     */
    public function update(int $id, DomainCategory $category): ?DomainCategory
    {
        $eloquentCategory = EloquentCategory::find($id);

        if (!$eloquentCategory) {
            return null; // Could throw an exception instead
        }

        $eloquentCategory->name = $category->name;
        $eloquentCategory->save();

        return new DomainCategory($eloquentCategory->id, $eloquentCategory->name);
    }
}