<?php

namespace App\Policies;

use App\Models\CvApplication;
use App\Models\User;

class CvApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, CvApplication $cvApplication): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, CvApplication $cvApplication): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, CvApplication $cvApplication): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, CvApplication $cvApplication): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, CvApplication $cvApplication): bool
    {
        return $user->isAdmin();
    }
}
