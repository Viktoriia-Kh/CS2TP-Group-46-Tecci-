<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\BasketItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    /**
     * HELPER - Get the identifier for the current basket
     * Returns ['type' => 'user'|'session', 'id' => userId|sessionId]
     */
    private function getBasketIdentifier()
    {
        if (Auth::check()) {
            return ['type' => 'user', 'id' => Auth::id()];
        }
        
        return ['type' => 'session', 'id' => session()->getId()];
    }

    /**
     * HELPER - Get basket items from database (replaces session()->get('basket'))
     */
    private function getBasketItems()
    {
        $identifier = $this->getBasketIdentifier();
        
        if ($identifier['type'] === 'user') {
            $items = BasketItem::forUser($identifier['id'])->with('product')->get();
        } else {
            $items = BasketItem::forSession($identifier['id'])->with('product')->get();
        }
        
        // Transform to match blade template's expected format
        $basket = [];
        foreach ($items as $item) {
            $basket[$item->product_id] = [
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'image' => $item->product->image_url,
            ];
        }
        
        return $basket;
    }

    /**
     * Show Basket Page
     */
    public function index() 
    {
        // Get basket from DB instead of session
        $basket = $this->getBasketItems();

        // Retrieve discount data from session (stays the same)
        $discountCode = session()->get('discount_code', null);
        $discountMultiplier = session()->get('discount_multiplier', 1);
        
        return view('basket', compact('basket', 'discountCode', 'discountMultiplier'));
    }

    /**
     * Add Item To Basket
     */
    public function add($id)
    {
        // Find product in the DB
        $product = Product::findOrFail($id);
        
        $identifier = $this->getBasketIdentifier();
        
        // Build data array
        $data = [
            'product_id' => $product->id,
            'quantity' => 1,
        ];
        
        if ($identifier['type'] === 'user') {
            $data['user_id'] = $identifier['id'];
            $data['session_id'] = null;
        } else {
            $data['session_id'] = $identifier['id'];
            $data['user_id'] = null;
        }
        
        // Check if item already exists
        if ($identifier['type'] === 'user') {
            $existingItem = BasketItem::where('user_id', $identifier['id'])
                                      ->where('product_id', $product->id)
                                      ->first();
        } else {
            $existingItem = BasketItem::where('session_id', $identifier['id'])
                                      ->where('product_id', $product->id)
                                      ->first();
        }
        
        if ($existingItem) {
            // Increment quantity
            $existingItem->increment('quantity');
        } else {
            // Create new basket item
            BasketItem::create($data);
        }
        
        return redirect()->back()->with('success', $product->name . ' added to your basket!');
    }

    /**
     * Remove Item from Basket
     */
    public function remove($id)
    {
        $identifier = $this->getBasketIdentifier();
        
        if ($identifier['type'] === 'user') {
            BasketItem::where('user_id', $identifier['id'])
                      ->where('product_id', $id)
                      ->delete();
        } else {
            BasketItem::where('session_id', $identifier['id'])
                      ->where('product_id', $id)
                      ->delete();
        }
        
        // Check if basket is empty and clear discount
        $remainingItems = $this->getBasketItems();
        if (empty($remainingItems)) {
            session()->forget(['discount_code', 'discount_multiplier']);
        }
        
        return redirect()->back();
    }

    /**
     * Decrease Quantity
     */
    public function decrease($id)
    {
        $identifier = $this->getBasketIdentifier();
        
        if ($identifier['type'] === 'user') {
            $item = BasketItem::where('user_id', $identifier['id'])
                              ->where('product_id', $id)
                              ->first();
        } else {
            $item = BasketItem::where('session_id', $identifier['id'])
                              ->where('product_id', $id)
                              ->first();
        }
        
        if ($item) {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            } else {
                // Remove if quantity would go to 0
                $item->delete();
            }
        }
        
        // Check if basket is empty and clear discount
        $remainingItems = $this->getBasketItems();
        if (empty($remainingItems)) {
            session()->forget(['discount_code', 'discount_multiplier']);
        }
        
        return redirect()->back();
    }

    /**
     * Apply Discount
     */
    public function applyDiscount(Request $request)
    {
        $code = strtolower(trim($request->input('code')));

        // Hardcoded valid discount codes
        $validCodes = [
            'xmas10' => 0.90,    // 10% off
            'welcome20' => 0.80  // 20% off
        ];

        if (array_key_exists($code, $validCodes)) {
            // Save to Session
            session()->put('discount_code', $code);
            session()->put('discount_multiplier', $validCodes[$code]);
            
            return response()->json([
                'success' => true,
                'message' => 'Discount applied!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid discount code.'
        ], 400);
    }

    /**
     * AJAX Update Method
     */
    public function updateAjax(Request $request)
    {
        $id = $request->input('id');
        $action = $request->input('action');
        
        $identifier = $this->getBasketIdentifier();
        
        // Find the basket item
        if ($identifier['type'] === 'user') {
            $item = BasketItem::where('user_id', $identifier['id'])
                              ->where('product_id', $id)
                              ->first();
        } else {
            $item = BasketItem::where('session_id', $identifier['id'])
                              ->where('product_id', $id)
                              ->first();
        }
        
        $newQuantity = 0;
        $wasDeleted = false;
        
        // Process the action
        if ($item) {
            if ($action === 'increase') {
                $item->increment('quantity');
                // Refresh to get the new quantity
                $item->refresh();
                $newQuantity = $item->quantity;
            } elseif ($action === 'decrease') {
                if ($item->quantity > 1) {
                    $item->decrement('quantity');
                    // Refresh to get the new quantity
                    $item->refresh();
                    $newQuantity = $item->quantity;
                } else {
                    $item->delete();
                    $action = 'remove';
                    $wasDeleted = true;
                }
            } elseif ($action === 'remove') {
                $item->delete();
                $wasDeleted = true;
            }
        }
        
        // Recalculate totals from database
        $basket = $this->getBasketItems();
        $total = 0;
        $totalQty = 0;
        
        foreach ($basket as $basketItem) {
            $total += $basketItem['price'] * $basketItem['quantity'];
            $totalQty += $basketItem['quantity'];
        }
        
        // Clear discount if empty
        if (empty($basket)) {
            session()->forget(['discount_code', 'discount_multiplier']);
        }
        
        return response()->json([
            'success' => true,
            'action' => $action,
            'newQuantity' => $newQuantity,
            'subtotal' => number_format($total, 2),
            'subtotalRaw' => $total,
            'totalQty' => $totalQty,
            'itemCount' => count($basket)
        ]);
    }

    /**
     * Merge guest basket into user basket on login
     * Call this method after a user successfully logs in
     * 
     * Usage in LoginController:
     * Auth::login($user);
     * app(BasketController::class)->mergeGuestBasketOnLogin();
     */
    public function mergeGuestBasketOnLogin()
    {
        if (!Auth::check()) {
            return; // Must be logged in
        }
        
        $userId = Auth::id();
        $sessionId = session()->getId();
        
        // Find all guest basket items for this session
        $guestItems = BasketItem::where('session_id', $sessionId)
                                ->whereNull('user_id')
                                ->get();
        
        if ($guestItems->isEmpty()) {
            return; // No guest items to merge
        }
        
        DB::transaction(function () use ($userId, $guestItems) {
            foreach ($guestItems as $guestItem) {
                // Check if user already has this product in their basket
                $userItem = BasketItem::where('user_id', $userId)
                                      ->where('product_id', $guestItem->product_id)
                                      ->first();
                
                if ($userItem) {
                    // User already has this item - add quantities together
                    $userItem->quantity += $guestItem->quantity;
                    $userItem->save();
                    
                    // Delete the guest item
                    $guestItem->delete();
                } else {
                    // User doesn't have this item - transfer ownership
                    $guestItem->user_id = $userId;
                    $guestItem->session_id = null;
                    $guestItem->save();
                }
            }
        });
    }
}
