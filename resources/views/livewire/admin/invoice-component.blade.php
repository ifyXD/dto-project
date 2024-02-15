@extends('layouts.invoice')
@section('content')
    <div class="ticket">
        {{-- <img src="./logo.png" alt="Logo"> --}}
        <p class="centered">Joseph Store
            <br>Address line 1
            <br>Address line 2
        </p>
        <table>
            <thead>
                <tr>
                    <th class="quantity">Qty</th>
                    <th class="description">Item</th>
                    <th class="price">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="quantity">1.00</td>
                    <td class="description">ARDUINO UNO</td>
                    <td class="price">$25.00</td>
                </tr>
                <tr>
                    <td class="quantity">1.00</td>
                    <td class="description">ARDUINO UNO</td>
                    <td class="price">$25.00</td>
                </tr>
                <tr>
                    <td class="quantity">1.00</td>
                    <td class="description">ARDUINO UNO</td>
                    <td class="price">$25.00</td>
                </tr>
               
            </tbody>
        </table>
        <p class="centered">Thanks for your purchase!
            <br>parzibyte.me/blog
        </p>
    </div>
@endsection
