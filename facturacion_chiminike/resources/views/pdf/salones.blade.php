@extends('pdf.layout')

@section('title', 'Estado de Salones')
@section('header', 'Estado de Salones')

@section('content')
<div class="seccion">
    <table>
        <thead><tr><th>Estado</th><th>Cantidad</th></tr></thead>
        <tbody>
            @php $sum=0; @endphp
            @foreach($salones as $s)
                @php $sum += $s->cantidad; @endphp
            <tr>
                <td>{{ $s->estado==1?'Disponible':'No Disponible' }}</td>
                <td>{{ $s->cantidad }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td><strong>Total</strong></td>
                <td><strong>{{ $sum }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
