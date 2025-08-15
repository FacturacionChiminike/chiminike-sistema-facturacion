@extends('pdf.layout')

@section('title', 'Reporte de Entradas')
@section('header', 'Reporte de Entradas')

@section('content')
<div class="seccion">
    <table>
        <thead><tr><th>Código</th><th>Descripción</th><th>Total (Lps)</th></tr></thead>
        <tbody>
            @php $sum=0; @endphp
            @foreach($entradas as $e)
                @php $sum += $e->total; @endphp
            <tr>
                <td>{{ $e->cod_entrada }}</td>
                <td>{{ $e->descripcion }}</td>
                <td class="currency">{{ number_format($e->total,2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2"><strong>Total</strong></td>
                <td class="currency"><strong>{{ number_format($sum,2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
