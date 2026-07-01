<?php

namespace App\Traits;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait CartTrait
{
    public function mergeCart(string $sessionId, int $userId): void
    {
        DB::transaction(function () use ($sessionId, $userId) {
            $sessionItems = Cart::query()
                ->where('session_id', $sessionId)
                ->whereNull('user_id')
                ->get();

            if ($sessionItems->isEmpty()) {
                return;
            }

            $userItems = Cart::query()
                ->where('user_id', $userId)
                ->whereIn('product_id', $sessionItems->pluck('product_id'))
                ->get()
                ->keyBy('product_id');

            foreach ($sessionItems as $sessionItem) {
                $userItem = $userItems->get($sessionItem->product_id);

                if ($userItem) {
                    $sessionItem->delete();
                    continue;
                }

                $sessionItem->update([
                    'user_id' => $userId,
                ]);
            }
        });
    }
}
