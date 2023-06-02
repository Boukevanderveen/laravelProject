<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\OrderAdress;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderAdressRequest;
use App\Http\Requests\UpdateOrderAdressRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Adress;
use Mail;
use App\Mail\MailableName;
use App;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdersController extends Controller
{
    function index(Order $order)
    {
        $orders = Order::where('user_id', Auth::user()->id)->latest()->paginate(6);

        return view('orders.index', ['orders' => $orders]);
    }

    function show(Order $order)
    {
        $this->authorize('viewAny', $order);

        return view('orders.show', ['order' => $order]);
    }


    function adminIndex(Order $order)
    {
        $this->authorize('view', $order);

        $orders = Order::latest()->paginate(6);

        return view('admin.orders.index', ['orders' => $orders]);
    }

    function edit(Order $order)
    {
        $this->authorize('update', $order);
        $shipmentAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'shipmentadress' . '%')->first();
        $invoiceAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'invoiceadress' . '%')->first();
        return view('admin.orders.edit', ['order' => $order, 'shipmentAdress'=> $shipmentAdress, 'invoiceAdress'=> $invoiceAdress]);   
    }

    function update(UpdateOrderRequest $request, Order $order)
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
        $orderadresses = OrderAdress::where('order_id', $order->id)->delete();

        $order->delete();

        return back()->with('message', 'Bestelling succesvol verwijderd.');
    }

    public function adressesDeliveryCreate(Request $request)
    {
        $adresses = Adress::where('user_id', Auth::user()->id)->get();
        return view('orders.adresses.delivery.create', ['adresses' => $adresses]);
    }

    public function adressesInvoicesCreate(StoreOrderAdressRequest $request)
    {
        return view('orders.adresses.invoices.create', ['shipmentAdressRequest' => $request->all()]);
    }
    
    public function store(StoreOrderAdressRequest $request)
    {   
        $Order = new Order;
        $Order->user()->associate(Auth::user()->id);
        $Order->email = $request->email;
        $Order->vat = $request->total_vat - $request->total;
        $Order->total_excl = $request->total;
        $Order->total_incl = $request->total_vat;
        $Order->save();

        $OrderAdress = new OrderAdress;
        $OrderAdress->type = $request->type;
        $OrderAdress->name = $request->name;
        $OrderAdress->company_name = $request->company_name;
        $OrderAdress->street = $request->street;
        $OrderAdress->phone_number = $request->phone_number;
        $OrderAdress->house_number = $request->house_number;
        $OrderAdress->addition = $request->addition;
        $OrderAdress->zipcode = $request->zipcode;
        $OrderAdress->city = $request->city;
        $OrderAdress->email = $request->email;
        $OrderAdress->order_id = $Order->id;
        $OrderAdress->save();

        $OrderAdress = new OrderAdress;
        foreach (json_decode($request->shipmentAdressRequest) as $key => $value) {
            
            if($key !== "total_vat" && $key !== "total" && $key !== "updated_at" && $key !== "created_at" && $key !== "_token")
            {
                $OrderAdress->$key = $value;
            }
        }
        $OrderAdress->order_id = $Order->id;
        $OrderAdress->save();

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
            $OrderDetail->product_picture = $product['picture'];
            $OrderDetail->vat = $product['vat'];
            
            $OrderDetail->order_id = $Order->id;
            $OrderDetail->save();
        }

        Mail::to(request('email'))->send(new MailableName($Order));

        Session::forget('cart');
        return redirect('products')->with('message', 'Bestelling succesvol afgerond'); 
    }

    function createInvoice()
    {
        $cart = session()->get('cart');

        session()->put('cart', $cart);
        return view('orders.invoiceadress');
    }

    function productsIndex(Order $order)
    {
        $products = Product::All();
        $invoiceAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'shipmentadress' . '%')->first();
        $shipmentAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'shipmentadress' . '%')->first();
        return view('admin.orders.products.index', ['order' => $order, 'products' => $products,'invoiceAdress' => $invoiceAdress,'shipmentAdress' => $shipmentAdress]);
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
        $Orderdetail->product_picture = $product->picture;

        $product->stock -= $request->quantity;

        $product->update();
        $Orderdetail->save();

        $order->total_excl += $Orderdetail->product_price * $Orderdetail->quantity;
        $order->vat += $Orderdetail->product_price * $Orderdetail->quantity * $Orderdetail->vat/100;
        $order->total_incl += $Orderdetail->product_price * $Orderdetail->quantity * $Orderdetail->vat/100 + $Orderdetail->product_price * $Orderdetail->quantity;
        $order->update();
        return back()->with('message', 'Artikel succesvol toegevoegd');
    }

    function productsEdit(Order $order, OrderDetail $orderdetail)
    {
        $this->authorize('update', $order);
        $product = Product::find($orderdetail->product_id);
        return view('admin.orders.products.edit', ['order' => $order, 'product' => $product, 'orderdetail' => $orderdetail]);
    }

    function productsUpdate(Request $request, Order $order, OrderDetail $orderdetail)
    {
        $this->authorize('update', $order);

        $oldTotalExcl = $order->total_excl;
        if($request->quantity < $orderdetail->quantity){        
            $order->total_excl -= abs($orderdetail->quantity - $request->quantity) * $orderdetail->product_price;
            $order->vat -= abs($order->total_excl - $oldTotalExcl) * $orderdetail->vat/100;
            $order->total_incl = $order->total_excl + $order->vat;
        }
        if($request->quantity > $orderdetail->quantity){     
            $order->total_excl += abs($orderdetail->quantity - $request->quantity) * $orderdetail->product_price;
            $order->vat += abs($order->total_excl - $oldTotalExcl) * $orderdetail->vat/100;
            $order->total_incl = $order->total_excl + $order->vat;
        }
        $orderdetail->quantity = $request->quantity;
        $orderdetail->update();
        $order->update();

        return back()->with('message', 'Product succesvol bewerkt');
    }

    function invoiceAdressIndex(Order $order)
    {
        $invoiceAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'shipmentadress' . '%')->first();
        $shipmentAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'shipmentadress' . '%')->first();
        return view('admin.orders.invoiceadresses.index', ['order' => $order, 'invoiceAdress'=> $invoiceAdress]);
    }

    function invoiceAdressUpdate(Order $order, OrderAdress $invoiceadress, UpdateOrderAdressRequest $request)
    {
        $invoiceadress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'invoiceadress' . '%')->first();
        $invoiceadress->name = $request->name;
        $invoiceadress->company_name = $request->company_name;
        $invoiceadress->street = $request->street;
        $invoiceadress->phone_number = $request->phone_number;
        $invoiceadress->house_number = $request->house_number;
        $invoiceadress->addition = $request->addition;
        $invoiceadress->zipcode = $request->zipcode;
        $invoiceadress->city = $request->city;
        $invoiceadress->order_id = $order->id;
        $invoiceadress->update();
        return back()->with('message', 'Factuuradres succesvol bijgewerkt');
    }

    function shipmentAdressEdit(Order $order, OrderAdress $shipmentadress)
    {
        $shipmentAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'shipmentadress' . '%')->first();
        $invoiceAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'shipmentadress' . '%')->first();
        return view('admin.orders.shipmentadresses.edit', ['order' => $order, 'shipmentAdress'=> $shipmentAdress, 'invoiceAdress'=> $invoiceAdress]);
    }
    
    function shipmentAdressUpdate(Order $order, OrderAdress $shipmentadress, UpdateOrderAdressRequest $request)
    {
        $shipmentadress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'shipmentadress' . '%')->first();
        $shipmentadress->name = $request->name;
        $shipmentadress->company_name = $request->company_name;
        $shipmentadress->street = $request->street;
        $shipmentadress->phone_number = $request->phone_number;
        $shipmentadress->house_number = $request->house_number;
        $shipmentadress->addition = $request->addition;
        $shipmentadress->zipcode = $request->zipcode;
        $shipmentadress->city = $request->city;
        $shipmentadress->order_id = $order->id;
        $shipmentadress->update();
        return back()->with('message', 'Bezorgadres succesvol bijgewerkt');
    }

    function invoiceAdressEdit(Order $order, OrderAdress $shipmentadress)
    {
        $invoiceAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'invoiceadress' . '%')->first();
        $shipmentAdress = OrderAdress::where('order_id', $order->id)->where('type', 'like', '%' . 'shipmentadress' . '%')->first();
        return view('admin.orders.invoiceadresses.edit', ['order' => $order, 'invoiceAdress'=> $invoiceAdress, 'shipmentAdress'=> $shipmentAdress]);
    }


    function invoice(Order $order)
    {
        $this->authorize('view', $order);

        $pdf = Pdf::loadView('pdf.orders.invoice', ['order' => $order]);
        return $pdf->download('invoice.pdf');
    }

    function mail(Order $order)
    {
        $this->authorize('update', $order);

        Mail::to($order->email)->send(new MailableName($order));
        return back()->with('message', 'Bestelling bevestigingsmail succesvol herstuurd');

    }
}
