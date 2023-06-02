@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-10">
            <h1>Bestellingen</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 card">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Prijs excl. btw</th>
                        <th scope="col">Prijs incl. btw</th>
                        <th scope="col">Besteld op:</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->email }}</td>
                            <td>€ {{ str_replace('.', ',', number_format($order->total_excl , 2))}}</td>
                            
                            <td>€ {{ str_replace('.', ',', number_format($order->total_incl , 2))}}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($order->created_at)) }}</td>
                            
                            </td>
                            <td class="text-end">

                                <form method="post" action="{{ route('admin.orders.destroy', $order) }}"> @csrf @method('delete')
                                        <a href="{{ route('admin.orders.invoice', $order) }}"><button type="button" btn btn-link
                                            class="btn btn-link link-dark text-end"><i class='fa fa-download'></i></button></a>
                                        <a href="{{ route('admin.orders.edit', $order) }}"><button type="button" btn btn-link
                                        class="btn btn-link link-dark text-end"><i class="fa fa-pencil"></i></button></a>
                                <button type="submit" onclick="return confirm('Weet je zeker dat je bestelling #{{ $order->id }} van {{ $order->email }} wilt verwijderen?')"
                                        class="btn btn-link link-dark"><i class="fa fa-trash-o"></i></button></form></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

