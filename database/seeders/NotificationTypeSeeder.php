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
            [
                'title' => 'New Property',
                'description' => 'A new property has been added',
            ],
            [
                'title' => 'Property Liked',
                'description' => 'A property within your group has been liked',
            ],
            [
                'title' => 'Property Disliked',
                'description' => 'A property within your group has been disliked',
            ],
            [
                'title' => 'New Comment',
                'description' => 'A new comment has been added',
            ],
        ];
        foreach ($data as $model_data) {
            $type = NotificationType::firstOrCreate(
                ['title' => $model_data['title']],
                ['description' => $model_data['description']]
            );

            // Seed notification preferences for users that don't have the given type
            User::whereDoesntHave(
                'notification_preferences',
                static function ($query) use ($type) {
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
