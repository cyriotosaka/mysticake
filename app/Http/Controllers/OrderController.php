<?php
//Modified by Muhammad Fikri Khalilullah/5026231198
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Address;
use App\Models\Delivery;
use App\Models\PaymentMethod;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Show Payment Page (Main Checkout Page)
     * Figma node: 74-940
     */
    public function showPayment()
{
    $user = Auth::user();
    
    // 1. Fetch IDs from Session
    $selectedItemIds = session('selected_cart_items', []);
    $addressId = session('selected_address');
    $deliveryId = session('selected_delivery');
    $paymentMethodId = session('selected_payment_method');

    // 2. Gatekeeper: If no items, go back to cart
    if (empty($selectedItemIds)) {
        return redirect()->route('cart.index')->with('error', 'Please select items to checkout');
    }

    // 3. Fetch actual database objects using those IDs
    $cart = Cart::where('id_user', $user->id_user)->first();
    $items = $cart->getSelectedItems($selectedItemIds);
    
    $address = $addressId ? Address::find($addressId) : null;
    $delivery = $deliveryId ? Delivery::find($deliveryId) : null;
    $paymentMethod = $paymentMethodId ? PaymentMethod::find($paymentMethodId) : null;

    // 4. Calculate real values (no more 0.000 placeholders)
    $subtotal = $items->sum(fn($item) => $item->product->price * $item->quantity);
    $deliveryCharge = $delivery ? $delivery->delivery_charges : 0;
    $total = $subtotal + $deliveryCharge;

    // Save total to session for verification during processOrder
    session(['calculated_total' => $total]);

    return view('order.payment', compact(
        'items', 'subtotal', 'deliveryCharge', 'total', 
        'address', 'delivery', 'paymentMethod'
    ));
}

    /**
     * Show Address Selection Page
     * Figma node: 74-961
     */
    public function selectAddress()
    {
        $user = Auth::user();
        
        // Get all addresses for current user
        $addresses = Address::getUserAddresses($user->id_user);
        
        // Check if user can add more addresses  
        $canAddMore = Address::canAddAddress($user->id_user);
        $addressCount = Address::getAddressCount($user->id_user);
        
        return view('order.address-select', compact('addresses', 'canAddMore', 'addressCount'));
    }

    /**
     * Show Address Details Form
     * Figma node: 43-258
     */
    public function showAddressDetails($addressId = null)
    {
        $user = Auth::user();
        $address = null;
        
        if ($addressId) {
            $address = Address::find($addressId);
        } elseif ($user->id_address) {
            $address = Address::find($user->id_address);
        }

        return view('order.address-details', compact('address'));
    }

    /**
     * Save Address
     * Figma node: 64-320
     */
    public function saveAddress(Request $request)
    {
        $request->validate([
            'full_address' => 'required|string',
            'map_point' => 'nullable|string',
            'address_contact_number' => 'required|string'
        ]);

        $user = Auth::user();

        // Check if user can add more addresses (max 3)
        if (!Address::canAddAddress($user->id_user) && !$request->has('id_address')) {
            return redirect()->back()->with('error', 'You can only have maximum 3 addresses');
        }

        // Check if editing existing address
        if ($request->has('id_address')) {
            $address = Address::find($request->id_address);
            
            // Verify ownership
            if ($address->id_user != $user->id_user) {
                abort(403);
            }
            
            $address->update($request->only(['full_address', 'map_point', 'address_contact_number']));
        } else {
            // Create new address
            $address = Address::create([
                'id_user' => $user->id_user,
                'full_address' => $request->full_address,
                'map_point' => $request->map_point,
                'address_contact_number' => $request->address_contact_number
            ]);
            
            // If this is the first address, set as default
            if (Address::getAddressCount($user->id_user) == 1) {
                $user->id_address = $address->id_address;
                $user->save();
            }
        }

        // Store in session for checkout
        session(['selected_address' => $address->id_address]);

        return redirect()->route('order.payment')->with('success', 'Address saved successfully');
    }

    /**
     * Show Delivery Options Page
     * Figma nodes: 68-383, 68-434
     */
    public function showDeliveryOptions()
    {
        $deliveries = Delivery::getAllOptions();
        return view('order.delivery-options', compact('deliveries'));
    }

    /**
     * Select Delivery Method
     */
    public function selectDelivery($deliveryId)
    {
        session(['selected_delivery' => $deliveryId]);
        return redirect()->route('order.payment')->with('success', 'Delivery method selected');
    }

    /**
     * Delete Address
     */
    public function deleteAddress($addressId)
    {
        $user = Auth::user();
        $address = Address::findOrFail($addressId);
        
        // Verify ownership
        if ($address->id_user != $user->id_user) {
            abort(403);
        }

        // Don't allow deleting if it's the last address
        if (Address::getAddressCount($user->id_user) <= 1) {
            return redirect()->back()->with('error', 'Cannot delete your only address');
        }

        // If deleting default address, set another as default
        if ($user->id_address == $addressId) {
            $newDefaultAddress = Address::forUser($user->id_user)
                ->where('id_address', '!=', $addressId)
                ->first();
            
            if ($newDefaultAddress) {
                $user->id_address = $newDefaultAddress->id_address;
                $user->save();
            }
        }

        $address->delete();

        return redirect()->route('order.address.select')->with('success', 'Address deleted successfully');
    }

    /**
     * Show Payment Methods Page
     * Figma node: 75-474
     * 
     * Modified by: Abdul Ghoni (5026231109)
     * - Added filter to exclude Alfamart and Indomaret from display
     */
    public function showPaymentMethods()
    {
        // Get all payment methods except Alfamart and Indomaret
        $paymentMethods = PaymentMethod::whereNotIn('name_method', ['Alfamart', 'Indomaret'])
            ->get();
        return view('order.payment-methods', compact('paymentMethods'));
    }

    /**
     * Select Payment Method
     */
    public function selectPaymentMethod($methodId)
    {
        session(['selected_payment_method' => $methodId]);
        return redirect()->route('order.payment')->with('success', 'Payment method selected');
    }

    /**
     * Process Order (Final Purchase)
     * Figma node: 74-980
     */
    public function processOrder(Request $request)
    {
    $user = Auth::user();
    
    // 1. Validate Selections
    $selectedItemIds = session('selected_cart_items', []);
    $addressId = session('selected_address');
    $deliveryId = session('selected_delivery');
    $paymentMethodId = session('selected_payment_method');

    if (empty($selectedItemIds) || !$addressId || !$deliveryId || !$paymentMethodId) {
        return redirect()->route('order.payment')->with('error', 'Please complete all selections');
    }

    try {
        // 2. Start Transaction
        return DB::transaction(function () use ($user, $selectedItemIds, $addressId, $deliveryId, $paymentMethodId) {
            
            $cart = Cart::where('id_user', $user->id_user)->first();
            $cartItems = $cart->getSelectedItems($selectedItemIds);

            // 3. Create order (using your model method)
            $order = Orders::createFromCart(
                $cartItems,
                $user->id_user,
                $addressId,
                $deliveryId,
                $paymentMethodId
            );

            // 4. Initialize Order History (Required for your Details page)
            // Replace 'OrderHistory' with your actual model name
            $order->histories()->create([
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'status_description' => 'Order has been placed and is awaiting processing.'
            ]);

            // 5. Cleanup
            $cart->clearSelectedItems($selectedItemIds);
            session()->forget(['selected_cart_items', 'selected_address', 'selected_delivery', 'selected_payment_method']);

            return redirect()->route('order.confirmation', ['id' => $order->id_order])
                             ->with('success', 'Order placed successfully!');
        });

    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Order Processing Error: ' . $e->getMessage());
        return redirect()->route('order.payment')->with('error', 'Something went wrong. Please try again.');
    }
    }

    /**
     * Show Order Confirmation Page
     * Figma node: 43-329
     */
    public function showOrderConfirmation($orderId)
    {
        $order = Orders::with(['items.product', 'address', 'delivery', 'paymentMethod'])->findOrFail($orderId);
        
        // Ensure user owns this order
        if ($order->id_user != Auth::id()) {
            abort(403);
        }

        return view('order.confirmation', compact('order'));
    }

    /**
     * Show Order History
     * Figma node: 364-1643
     */
    public function orderHistory()
    {
        $user = Auth::user();
        $orders = Orders::findByUser($user->id_user);
        
        return view('order.history', compact('orders'));
    }

    /**
     * Show Order Details
     * Figma node: 364-1959
     */
    public function orderDetails($orderId)
    {
        $order = Orders::with(['items.product', 'address', 'delivery', 'paymentMethod', 'histories'])
            ->findOrFail($orderId);
        
        // Ensure user owns this order
        if ($order->id_user != Auth::id()) {
            abort(403);
        }

        return view('order.details', compact('order'));
    }
    
    public function checkoutSummary()
    {
    // 1. Get cart items
    $items = Cart::where('user_id', auth()->id())->with('product')->get();
    
    // 2. Calculate subtotal
    $subtotal = $items->sum(fn($item) => $item->product->price * $item->quantity);
    
    // 3. Retrieve selections from Session (set in previous steps)
    $address = UserAddress::find(session('selected_address_id'));
    $delivery = DeliveryMethod::find(session('selected_delivery_id'));
    $paymentMethod = PaymentMethod::find(session('selected_payment_id'));
    
    $deliveryCharge = $delivery ? $delivery->delivery_charges : 0;
    $total = $subtotal + $deliveryCharge;

    return view('order.payment', compact(
        'items', 'subtotal', 'address', 'delivery', 
        'paymentMethod', 'deliveryCharge', 'total'
    ));
    }

    public function showPaymentSummary()
{
    $user = auth()->user();
    
    // Fetch the IDs stored in session from previous steps
    $addressId = session('selected_address');
    $deliveryId = session('selected_delivery');
    $paymentMethodId = session('selected_payment_method');
    $selectedItemIds = session('selected_cart_items', []);

    // Load the actual models
    $address = Address::find($addressId);
    $delivery = DeliveryMethod::find($deliveryId);
    $paymentMethod = PaymentMethod::find($paymentMethodId);
    
    // Get the specific items from the cart
    $items = CartItem::whereIn('id', $selectedItemIds)->with('product')->get();
    
    // Calculate totals
    $subtotal = $items->sum(fn($item) => $item->product->price * $item->quantity);
    $deliveryCharge = $delivery ? $delivery->delivery_charges : 0;
    $total = $subtotal + $deliveryCharge;

    // Save total to session for the final processOrder step
    session(['calculated_total' => $total]);

    return view('order.payment', compact(
        'address', 'delivery', 'paymentMethod', 'items', 
        'subtotal', 'deliveryCharge', 'total'
    ));
}
}
