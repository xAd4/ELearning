<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        try {
            $cart = Cart::with(['cartItems.course.category'])
                ->firstOrCreate(['user_id' => $request->user()->id]);

            return response()->json([
                "ok" => true,
                "cart" => $cart
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function addCourse(Request $request, Course $course): JsonResponse
    {
        try {
            $cart = Cart::firstOrCreate(
                ['user_id' => $request->user()->id]
            );

            // Adjuntar el curso al carrito usando la relación
            $cartItem = $cart->cartItems()->updateOrCreate(
                ['course_id' => $course->id],
                ['total_price' => $course->price]
            );

            return response()->json([
                "ok" => true,
                "message" => "Curso agregado al carrito",
                "item" => $cartItem->load('course')
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function removeCourse(CartItem $cartItem): JsonResponse
    {
        try {
            if ($cartItem->cart->user_id !== Auth::user()->id) {
                abort(403, 'Unauthorized');
            }

            $cartItem->delete();

            return response()->json([
                "ok" => true,
                "message" => "Curso eliminado del carrito"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function clearCart(Request $request): JsonResponse
    {
        try {
            $cart = Cart::where('user_id', $request->user()->id)->first();

            if ($cart) {
                $cart->cartItems()->delete();
            }

            return response()->json([
                "ok" => true,
                "message" => "Carrito vaciado"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => $th->getMessage()
            ], 500);
        }
    }
}
