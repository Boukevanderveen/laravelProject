<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use Mail;
use App\Mail\MailableName;
use App;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdersController extends Controller
{
    function adminIndex(Order $order)
    {
        $this->authorize('view', $order);

        $orders = Order::latest()->paginate(6);

        return view('admin.orders.index', ['orders' => $orders]);
    }

    function edit(Order $order)
    {
        $this->authorize('update', $order);
        return view('admin.orders.edit', ['order' => $order]);
    }

    function update(Request $request, Order $order)
    {
        $order->name = $request->name;
        $order->zipcode = $request->zipcode;
        $order->city = $request->city;
        $order->house_number = $request->house_number;
        $order->addition = $request->addition;
        $order->street = $request->street;
        $order->email = $request->email;
        $order->update();

        return back()->with('message', 'Bestelling gegevens succesvol bewerkt.');
    }

    function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $orderdetails = OrderDetail::where('order_id', $order->id);
        $orderdetails->delete();
        $order->delete();

        return back()->with('message', 'Bestelling succesvol verwijderd.');
    }

    public function create(Request $request)
    {
        $cart = session()->get('cart');

        session()->put('cart', $cart);
        return view('orders.create', ['total' => $request->total,'vattotal' => $request->vat, 'subtotal' => $request->subtotal]);
    }

    public function store(StoreOrderRequest $request)
    {
        $Order = new Order;

        $Order->user()->associate(Auth::user()->id);
        $Order->email = $request->email;
        $Order->name = $request->name;
        $Order->street = $request->street;
        $Order->house_number = $request->house_number;
        $Order->addition = $request->addition;
        $Order->zipcode = $request->zipcode;
        $Order->city = $request->city;
        $Order->vat = $request->total_vat - $request->total;
        $Order->total_excl = $request->total;
        $Order->total_incl = $request->total_vat;
        $Order->save();

        $cart = session()->get('cart', []);

        $product_total = 0;
        $product_vat = 0;
        $order_vat = 0;
        $order_total = 0;
        $order_total_vat = 0;

        foreach($cart as $product){
            if(isset($product['discount_price']))
            {
                $product_total = $product['discount_price'] * $product['quantity'];
                $order_total += $product['discount_price'] * $product['quantity'];
            
                $OrderDetail = new OrderDetail;
                $OrderDetail->product_price = $product['discount_price'];
                $Product = Product::find($product['id']);
                if($Product->stock < $product['quantity'] || $product['quantity'] > 99)
                {
                    return back()->with('error', 'Er is iets mis gegaan bij het bestellen.');
                }
                else
                {
                    $Product->stock -= $product['quantity'];
                    $Product->update();
                }
            }
            else
            {
                $product_total = $product['price'] * $product['quantity'];
                $order_total += $product['price'] * $product['quantity'];
                
                $OrderDetail = new OrderDetail;
                $OrderDetail->product_price = $product['price'];
                $Product = Product::find($product['id']);
                if($Product->stock < $product['quantity'])
                {
                    return back()->with('error', 'Er is iets mis gegaan bij het bestellen.');
                }
                else
                {
                    $Product->stock -= $product['quantity'];
                    $Product->update();
                }
            }

            $product_vat = $product['vat']/100 * $product_total;
            $order_vat += $product['vat']/100 * $order_total;
            $order_total_vat += $order_total + $order_vat;

            $OrderDetail->product()->associate($product['id']);
            $OrderDetail->quantity = $product['quantity'];
            $OrderDetail->product_name = $product['name'];
            $OrderDetail->vat = $product['vat'];
            
            $OrderDetail->order_id = $Order->id;
            $OrderDetail->save();
        }

        Mail::to(request('email'))->send(new MailableName($Order));

        Session::forget('cart');
        return redirect('products')->with('message', 'Bestelling succesvol afgerond'); 
    }

    function productsIndex(Order $order)
    {
        $products = Product::All();
        return view('admin.orders.products.index', ['order' => $order, 'products' => $products]);
    }

    function productsDestroy(Order $order, OrderDetail $orderdetail)
    {
        $this->authorize('delete', $order);
        $order->total_excl -= $orderdetail->product_price * $orderdetail->quantity;
        $order->vat -= $orderdetail->product_price * $orderdetail->quantity * $orderdetail->vat/100;
        $order->total_incl -= $orderdetail->product_price * $orderdetail->quantity * $orderdetail->vat/100 + $orderdetail->product_price * $orderdetail->quantity;
    
        $product = Product::find($orderdetail->product_id);
        $product->stock += $orderdetail->quantity;

        $order->update();
        $product->update();
        $orderdetail->delete();

        return back()->with('message', 'Artikel succesvol verwijderd.');
    }

    function productsStore(Request $request, Order $order)
    {
        $product = product::find($request->productid);
        if($product->stock < $request->quantity)
        {
            return back()->with('error', 'Niet genoeg voorraad om deze hoeveelheid artikelen toe te voegen');
        }
        $Orderdetail = new OrderDetail;
        $Orderdetail->quantity = $request->quantity;
        $Orderdetail->product_name = $product->name;
        $Orderdetail->product_price = $product->price;
        $Orderdetail->vat = $product->vat;
        $Orderdetail->order_id = $order->id;
        $Orderdetail->product_id = $product->id;
        $product->stock -= $request->quantity;

        $product->update();
        $Orderdetail->save();

        $order->total_excl += $Orderdetail->product_price * $Orderdetail->quantity;
        $order->vat += $Orderdetail->product_price * $Orderdetail->quantity * $Orderdetail->vat/100;
        $order->total_incl += $Orderdetail->product_price * $Orderdetail->quantity * $Orderdetail->vat/100 + $Orderdetail->product_price * $Orderdetail->quantity;
        $order->update();
        return back()->with('message', 'Artikel succesvol toegevoegd');
    }

    function invoice(Order $order)
    {
        $pdf = Pdf::loadView('pdf.orders.invoice', ['order' => $order]);
        return $pdf->download('invoice.pdf');
    }
}
