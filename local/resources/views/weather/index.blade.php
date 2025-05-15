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
                @if(Auth()->user()->is_admin)
                    <div class="flex justify-start mb-4">
                        <a href="{{ route('weather.create') }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add Weather Data
                        </a>
                    </div>
                @endif
            <table class="w-full table-auto text-gray-800 dark:text-white bg-gray-300 dark:bg-gray-800">
                <thead class="text-sm leading-normal">
                <tr>
                    <th class="border px-4 py-2">Serial</th>
                    <th class="border px-4 py-2">Datetime</th>
                    <th class="border px-4 py-2 hidden sm:table-cell">Barometric Pressure</th>
                    <th class="border px-4 py-2 hidden sm:table-cell">Temperature (air/water)</th>
                    <th class="border px-4 py-2 hidden sm:table-cell">Humidity (relative/absolute)</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($weathers as $weather)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $weather->tideGauge->_serial }}</td>
                        <td class="border px-4 py-2 text-center">{{ $weather->_date }} {{ $weather->_time }}</td>
                        <td class="border px-4 py-2 text-center hidden sm:table-cell">{{ $weather->barometric_pressure_inches }}inch, {{$weather->barometric_pressure_mm}}bar</td>
                        <td class="border px-4 py-2 text-center hidden sm:table-cell">{{ $weather->air_temperature }}&deg;C/ {{$weather->water_temperature}}&deg;C</td>
                        <td class="border px-4 py-2 text-center hidden sm:table-cell">{{ $weather->relative_humidity }}%/ {{$weather->absolute_humidity}}%</td>
                        <td class="border px-4 py-2 ">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('weather.edit', $weather) }}"
                                   class="bg-green-700 hover:bg-green-500 text-white py-1 px-2 rounded">
                                    Edit
                                </a>
                                @if(Auth()->user()->is_admin)
                                    <form action="{{ route('weather.destroy', $weather) }}" method="POST"
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
</x-app-layout>
