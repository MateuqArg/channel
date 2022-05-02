@extends('includes.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css">

<script>
    $(document).ready( function() {
        Swal.fire({
            title: '¡Arreglado!',
            html: 'Reunión confirmada correctamente',
            icon: 'success',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEnterKey: false,
            allowEscapeKey: false,
        })
    })
</script>
{{-- @include('includes.footer') --}}
@endsection