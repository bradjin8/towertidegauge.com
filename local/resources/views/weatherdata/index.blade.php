<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <!-- Serial Selection -->
            <div class="mb-4">
                <label for="serial" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select
                    Serial</label>
                <select
                    name="serial"
                    id="serial"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200"
                    onchange="updateSerial(this);"
                    required>
                    <option value="" disabled selected>Select a serial</option>
                    @foreach($serials as $serial)
                        <option value="{{ $serial->serial }}">{{ $serial->serial }}</option>
                    @endforeach
                </select>
            </div>
            @if(Auth()->user()->is_admin)
                <div class="flex justify-between mb-4">
                    <a href="{{ route('weather.create') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Weather Data
                    </a>
                    <button type="button" onclick="deleteAll();"
                            class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                        Delete All
                    </button>
                </div>
            @endif
            <table class="w-full table-auto text-gray-800 dark:text-white bg-gray-300 dark:bg-gray-800">
                <thead class="text-sm leading-normal">
                <tr>
                    <th class="border px-4 py-2">Serial</th>
                    <th class="border px-4 py-2">Datetime</th>
                    <th class="border px-4 py-2 hidden sm:table-cell">Wind (direction/speed)</th>
                    <th class="border px-4 py-2 hidden sm:table-cell">Temperature</th>
                    <th class="border px-4 py-2 hidden sm:table-cell">Humidity</th>
                    <th class="border px-4 py-2 hidden sm:table-cell">Pressure</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($weathers as $weather)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $weather->serial }}</td>
                        <td class="border px-4 py-2 text-center">{{ $weather->time }}</td>
                        <td class="border px-4 py-2 text-center hidden sm:table-cell">{{ $weather->wind_direction }}
                            / {{$weather->wind_speed}} </td>
                        <td class="border px-4 py-2 text-center hidden sm:table-cell">
                            {{ $weather->temperature }}&deg;C
                        </td>
                        <td class="border px-4 py-2 text-center hidden sm:table-cell">{{ $weather->humidity}}%</td>
                        <td class="border px-4 py-2 text-center hidden sm:table-cell">{{ $weather->pressure}}mB</td>
                        <td class="border px-4 py-2 ">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('weatherdata.edit', $weather) }}"
                                   class="bg-green-700 hover:bg-green-500 text-white py-1 px-2 rounded">
                                    Edit
                                </a>
                                @if(Auth()->user()->is_admin)
                                    <form action="{{ route('weatherdata.destroy', $weather) }}" method="POST"
                                          onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let serial = null;
        $(document).ready(function () {
            const search = window.location.search;
            if (search.length > 1) {
                const params = search.replace(/\?/g, '').split('&')[0];
                const key = params.split('=')[0];
                const value = params.split('=')[1];
                if (key === 'serial') {
                    $('#serial').val(value);
                    serial = value;
                }
            }
        });

        function updateSerial(sel) {
            console.log(sel.value);
            window.location.href = '{{url('/weatherdata')}}?serial=' + sel.value;
        }

        function deleteAll() {

            if (serial) {
                if (confirm('Are you sure to delete all data for this station?')) {
                    $.ajax({
                        url: '{{url('/api/weatherdata')}}/' + serial,
                        method: 'delete',
                    })
                        .then(function (data, status) {
                            window.location.href = '{{url('/weatherdata')}}';
                        });
                }
            } else {
                alert("Please select a serial");
            }
        }
    </script>
</x-app-layout>
