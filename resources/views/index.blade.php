@extends ('layouts.app')

@section('title', $title)

@section('content')
    <div class="title m-b-md">
        <router-view name="catalog"></router-view>
    </div>
@endsection
