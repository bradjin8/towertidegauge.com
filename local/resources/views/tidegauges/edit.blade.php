<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto bg-gray-300 dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <form action="{{ route('tidegauges.update', $tideGauge) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Serial Field -->
                <div class="mb-4">
                    <label for="_serial" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serial</label>
                    <input
                        type="text"
                        name="_serial"
                        id="_serial"
                        value="{{ old('_serial', $tideGauge->_serial) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Country Field -->
                <div class="mb-4">
                    <label for="_country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                    <input
                        type="text"
                        name="_country"
                        id="_country"
                        value="{{ old('_country', $tideGauge->_country) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Location Field -->
                <div class="mb-4">
                    <label for="_loc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                    <input
                        type="text"
                        name="_loc"
                        id="_loc"
                        value="{{ old('_loc', $tideGauge->_loc) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Latitude Field -->
                <div class="mb-4">
                    <label for="_lat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Latitude</label>
                    <input
                        type="number"
                        step="0.0000001"
                        name="_lat"
                        id="_lat"
                        value="{{ old('_lat', $tideGauge->_lat) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Longitude Field -->
                <div class="mb-4">
                    <label for="_lon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Longitude</label>
                    <input
                        type="number"
                        step="0.0000001"
                        name="_lon"
                        id="_lon"
                        value="{{ old('_lon', $tideGauge->_lon) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Date Field -->
                <div class="mb-4">
                    <label for="_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                    <input
                        type="date"
                        name="_date"
                        id="_date"
                        value="{{ old('_date', $tideGauge->_date) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Time Field -->
                <div class="mb-4">
                    <label for="_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time</label>
                    <input
                        type="time"
                        name="_time"
                        id="_time"
                        value="{{ old('_time', $tideGauge->_time) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Tide Field -->
                <div class="mb-4">
                    <label for="_tide" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tide</label>
                    <input
                        type="number"
                        step="0.01"
                        name="_tide"
                        id="_tide"
                        value="{{ old('_tide', $tideGauge->_tide) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Units Field -->
                <div class="mb-4">
                    <label for="_units" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Units</label>
                    <input
                        type="text"
                        name="_units"
                        id="_units"
                        value="{{ old('_units', $tideGauge->_units) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Update Tide Gauge
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
