<x-home-master>

    @section('content')

        {{-- Show flash message for error --}}
        @if (Session::has('message'))
            <div class="alert alert-danger mx-auto mt-4 col-md-8"> {{ session('message') }}</div>
        @endif


    @endsection


</x-home-master>
