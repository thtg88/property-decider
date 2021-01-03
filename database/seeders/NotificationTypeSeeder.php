<?php

namespace Database\Seeders;

use App\Models\NotificationPreference;
use App\Models\NotificationType;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => 'New Property'],
            ['title' => 'Property Liked'],
            ['title' => 'Property Disliked'],
            ['title' => 'New Comment'],
        ];
        foreach ($data as $model_data) {
            $type = NotificationType::firstOrCreate([
                'title' => $model_data['title'],
            ]);

            // Seed notification preferences for users that don't have the given type
            User::whereDoesntHave(
                'notification_preferences',
                static function ($query) {
                    $query->where('type_id', $type->id);
                }
            )->get()->each(fn (User $user) => NotificationPreference::create([
                'is_active' => false,
                'type_id' => $type->id,
                'user_id' => $user->id,
            ]));
        }
    }
}
