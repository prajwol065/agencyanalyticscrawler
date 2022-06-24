<x-home-master>

    @section('content')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"># of Pages Crawled</th>
                            <th scope="col">Average Word count</th>
                            <th scope="col">Overall Average Title length</th>
                            <th scope="col">Average Crawl Time</th>
                            <th scope="col">Number of unique Images</th>
                            <th scope="col">Number of unique Internal Links</th>
                            <th scope="col">Number of unique External Links</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>{{ $webcrawl->count() }}
                            <th>{{ round($webcrawl->avg('word_count'), 0) }}
                            <th>{{ round($webcrawl->avg('average_title_length'), 0) }}
                            <th>{{ round($webcrawl->avg('time_taken'), 0) }} s
                            <th>{{ $images->unique('image_url')->count() }}
                            <th>{{ $crawls->where('is_internal', 1)->unique('extracted_url')->count() }}
                            <th>{{ $crawls->where('is_internal', 0)->unique('extracted_url')->count() }}


                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endsection



</x-home-master>
