<x-home-master>

    @section('content')
        @if (Session::has('info'))
            <div class="d-flex">
                <div class="alert alert-success mx-auto mt-4 col-md-8"> {{ session('info') }}</div>
            </div>
        @endif
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Page Url</th>
                            <th scope="col">Time Taken To Crawl (in s)</th>
                            <th scope="col">Number of words</th>
                            <th scope="col">Average Title length</th>
                            <th scope="col">Http Code</th>
                            <th scope="col">Total Internal Links</th>
                            <th scope="col">Total External Links</th>
                            <th scope="col">Total Images</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($webcrawl as $web)
                            <tr>
                                <td>
                                    @if(strpos($web->page_url,'http') !== false)
                                    <a href="{{$web->page_url}}">
                                    @else
                                    <a href="https://agencyanalytics.com{{$web->page_url}}">
                                     @endif
                                     {{$web->page_url}}</a>
                                    </td>
                                <td> {{ $web->time_taken }} </td>
                                <td> {{ $web->word_count }} </td>
                                <td> {{ $web->average_title_length }} </td>
                                <td> {{ $web->http_code }} </td>
                                <td>{{ $web->crawls->where('is_internal', 1)->count() }}</td>
                                <td> {{ $web->crawls->where('is_internal', 0)->count() }} </td>
                                <td> {{ $web->images->count() }} </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection


</x-home-master>
