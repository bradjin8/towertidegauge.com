<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                    {{ session('success') }}
                </div>
            @endif
            <table class="w-full table-auto text-gray-800 dark:text-white bg-gray-300 dark:bg-gray-800">
                <thead class="uppercase text-sm leading-normal">
                <tr>
                    <th class="border px-4 py-2">Serial</th>
                    <th class="border px-4 py-2">Country</th>
                    <th class="border px-4 py-2">Local</th>
                    <th class="border px-4 py-2">Location</th>
                    <th class="border px-4 py-2">Datetime</th>
                    <th class="border px-4 py-2">Data</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($measurements as $measurement)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $measurement->tideGauge->_serial }}</td>
                        <td class="border px-4 py-2 text-center">{{ $measurement->tideGauge->_country }}</td>
                        <td class="border px-4 py-2 text-center">{{ $measurement->tideGauge->_loc }}</td>
                        <td class="border px-4 py-2 text-center">{{ $measurement->tideGauge->_lat }}, {{ $measurement->tideGauge->_lon }}</td>
                        <td class="border px-4 py-2 text-center">{{ $measurement->_date }} {{ $measurement->_time }}</td>
                        <td class="border px-4 py-2 text-center">{{ $measurement->_tide }} {{ $measurement->_units }}</td>
                        <td class="border px-4 py-2 flex space-x-2 justify-center">
                            <a href="{{ route('measurement.edit', $measurement) }}"
                               class="bg-green-700 hover:bg-green-500 text-white py-1 px-2 rounded">
                                Edit
                            </a>
                            @if(Auth()->user()->is_admin)
                                <form action="{{ route('measurement.destroy', $measurement) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
