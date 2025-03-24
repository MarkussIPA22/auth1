<?php

namespace App\Actions\Jetstream;

use App\Models\Log;
use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();

        Log::create([
            'user_id' => $user->id,
            'model' => 'User',
            'action' => 'delete',
            'old_data' => json_encode($user->toArray()),
            'new_data' => json_encode([]),
            'ip' => request()->ip(),
        ]);

        $user->delete();
    }
}
