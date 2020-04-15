@extends ('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="title m-b-md">
        <main class="">
            <div class="container wow fadeIn">
                <h2 class="h2 text-center">Checkout form</h2>
                <router-view name="checkout"></router-view>
            </div>
        </main>
    </div>
@endsection
