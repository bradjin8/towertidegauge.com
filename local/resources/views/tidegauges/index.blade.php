<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth()->user()->is_admin)
                <div class="flex justify-start mb-4">
                    <a href="{{ route('tidegauges.create') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add TideGauge
                    </a>
                </div>
            @endif

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
            <table class="w-full table-auto text-gray-800 dark:text-white bg-gray-300 dark:bg-gray-800">
                <thead class="uppercase text-sm leading-normal">
                <tr>
                    <th class="border px-4 py-2">Serial</th>
                    <th class="border px-4 py-2">Country</th>
                    <th class="border px-4 py-2 hidden sm:table-cell">Local</th>
                    <th class="border px-4 py-2 hidden sm:table-cell">Location</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tideGauges as $tideGauge)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $tideGauge->_serial }}</td>
                        <td class="border px-4 py-2 text-center">{{ $tideGauge->_country }}</td>
                        <td class="border px-4 py-2 text-center hidden sm:table-cell">{{ $tideGauge->_loc }}</td>
                        <td class="border px-4 py-2 text-center hidden sm:table-cell">{{ $tideGauge->_lat }}, {{ $tideGauge->_lon }}</td>
                        <td class="border px-2 sm:px-4 py-2 flex space-x-2 justify-center">
                            <a href="{{ route('tidegauges.view', $tideGauge) }}"
                               class="bg-blue-700 hover:bg-blue-500 text-white py-1 px-2 rounded">
                                View
                            </a>
                            <a href="{{ route('tidegauges.edit', $tideGauge) }}"
                               class="bg-green-700 hover:bg-green-500 text-white py-1 px-2 rounded">
                                Edit
                            </a>
                            @if(Auth()->user()->is_admin)
                                <form action="{{ route('tidegauges.destroy', $tideGauge) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
                                        Delete
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('deviceSettings.view', $tideGauge->_serial) }}"
                               class="bg-grey-700 hover:bg-grey-500 text-white py-1 px-2 rounded">
                                Settings
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
