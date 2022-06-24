<x-home-master>

    @section('content')
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="80%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Images</th>
                            <th>Unique Image Url</th>
                            <th>Extracted From</th>
                    </thead>
                    <tbody>

                        @foreach ($images as $image)
                            <tr>
                                <th>
                                    <img width="50" height="50"
                                        src="https://agencyanalytics.com{{ $image->image_url }}">
                                </th>
                                <th>https://agencyanalytics.com{{ $image->image_url }}</th>
                                <th>{{ $image->webcrawler->page_url }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex">
            <div class="mx-auto">
                {{-- {{ $images->links() }} --}}
            </div>
        </div>
    @endsection

    @section('scripts')
        <!-- Page level plugins -->
        <script src="{{ secure_asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ secure_asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ secure_asset('js/datatables-demo.js') }}"></script>
    @endsection
</x-home-master>
