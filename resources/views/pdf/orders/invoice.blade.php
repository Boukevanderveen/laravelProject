<div>
    <h1>[LOGO]</h1>
    <h1>Bestelling</h1>

    <div style="width: 100%; height: 15%">
        <div style="float: left;">
            <p>{{ $order->name }}</p>
            <p>{{ $order->street_number }} {{ $order->addition }}</p>
            <p>{{ $order->zipcode }}, {{ $order->city }}</p>
        </div>
        <div style="float: right;">
            <p><b>Bestellingnummer:</b> {{ $order->id }}</p>
            <p>Besteldatum: {{ $order->created_at->format('d-m-Y') }}</p>
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
