<div>
    <h1>[LOGO]</h1>
    <h1>Bestelling</h1>
<div style="    
width: 100%;
overflow: hidden;">

    <div style="width: 500px; float: left;">
        <div>
            <h2>Factuuradres</h2>
            <p>{{ $invoiceAdress->name }}</p>
            <p>{{ $invoiceAdress->house_number }} {{ $invoiceAdress->addition }}</p>
            <p>{{ $invoiceAdress->zipcode }}, {{ $invoiceAdress->city }}</p>
            <p><b>Bestellingnummer:</b> {{ $invoiceAdress->id }}</p>
            <p>Besteldatum: {{ $invoiceAdress->created_at->format('d-m-Y') }}</p>
        </div>

    </div>
    <div style="overflow: hidden;">
        <div >
            <h2>Afleveradres</h2>
            <p>{{ $shipmentAdress->name }}</p>
            <p>{{ $shipmentAdress->house_number }} {{ $shipmentAdress->addition }}</p>
            <p>{{ $shipmentAdress->zipcode }}, {{ $shipmentAdress->city }}</p>
            <p><b>Bestellingnummer:</b> {{ $shipmentAdress->id }}</p>
            <p>Besteldatum: {{ $shipmentAdress->created_at->format('d-m-Y') }}</p>
        </div>

    </div>
</div>
    <h2>Producten</h2>

    <table style="width: 100%">
        <thead>
            <tr>
                <th style="text-align:left;">Hoeveelheid</th>
                <th style="text-align:left;">Naam</th>
                <th style="text-align:left;">BTW</th>
                <th style="text-align:left;">Prijs</th>
                <th style="text-align:left;">Totaal</th>
            </tr>
        </thead>
        @foreach ($order->orderdetails as $orderdetail)
            <tbody>
                <td>{{ $orderdetail->quantity }}</td>
                <td>{{ $orderdetail->product_name }}</td>
                <td>
                    <p> {{$orderdetail->vat}}% </p>
                </td>
                <td>€ {{ number_format($orderdetail->product_price, 2, ',', '') }}</td>
                @php $totaal_product = $orderdetail->product_price * $orderdetail->quantity; @endphp

                <td>€ {{ number_format($totaal_product, 2, ',', '') }}</td>
            </tbody>
        @endforeach
    </table>

    <div style="float: right">
        <p><b>Subtotaal</b> € {{ number_format($order->total_excl, 2, ',', '') }}</p>
        <p><b>BTW</b> € {{ number_format($order->vat, 2, ',', '') }}</p>
        <p><b>Totaal €</b> {{ number_format($order->total_incl, 2, ',', '') }}</p>
    </div>
</div>
