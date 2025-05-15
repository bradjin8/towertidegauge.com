<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto bg-gray-300 dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <div class="dark:text-white text-2xl pb-4">Create Weather Data</div>
            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('weather.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="header" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serial</label>
                    <input
                        type="text"
                        name="serial"
                        id="serial"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>                <div class="mb-4">
                    <label for="header" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Header</label>
                    <input
                        type="text"
                        name="header"
                        id="header"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Date Field -->
                    <div class="mb-4">
                        <label for="_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <input
                            type="text"
                            name="_date"
                            id="_date"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <!-- Time Field -->
                    <div class="mb-4">
                        <label for="_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time</label>
                        <input
                            type="text"
                            name="_time"
                            id="_time"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Barometric Field -->
                    <div class="mb-4">
                        <label for="barometric_pressure_inches" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Barometric Pressure (inch)</label>
                        <input
                            type="number"
                            name="barometric_pressure_inches"
                            id="barometric_pressure_inches"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>

                    <!-- Barometric Field -->
                    <div class="mb-4">
                        <label for="barometric_pressure_mm" class="block text-sm font-medium text-gray-700 dark:text-gray-300">(mm)</label>
                        <input
                            type="number"
                            name="barometric_pressure_mm"
                            id="barometric_pressure_mm"
                            step="any"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                </div>


                <div class="grid grid-cols-2 gap-4">
                    <!-- Temperature Field -->
                    <div class="mb-4">
                        <label for="air_temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Air Temperature</label>
                        <input
                            type="number"
                            name="air_temperature"
                            id="air_temperature"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="water_temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Water Temperature</label>
                        <input
                            type="number"
                            name="water_temperature"
                            id="water_temperature"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Humidity Field -->
                    <div class="mb-4">
                        <label for="relative_humidity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Relative Humidity</label>
                        <input
                            type="number"
                            name="relative_humidity"
                            id="relative_humidity"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="absolute_humidity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Absolute Humidity</label>
                        <input
                            type="number"
                            name="absolute_humidity"
                            id="absolute_humidity"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="dew_point" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dew Point</label>
                    <input
                        type="number"
                        name="dew_point"
                        id="dew_point"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        step="any"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- wind_direction Field -->
                    <div class="mb-4">
                        <label for="wind_direction_true" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wind Direction (true)</label>
                        <input
                            type="number"
                            name="wind_direction_true"
                            id="wind_direction_true"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="wind_direction_mg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">(mg)</label>
                        <input
                            type="number"
                            name="wind_direction_mg"
                            id="wind_direction_mg"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <!-- wind_speed_kts Field -->
                    <div class="mb-4">
                        <label for="wind_speed_kts" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wind Speed (kts)</label>
                        <input
                            type="number"
                            name="wind_speed_kts"
                            id="wind_speed_kts"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="wind_speed_mps" class="block text-sm font-medium text-gray-700 dark:text-gray-300">(mps)</label>
                        <input
                            type="number"
                            name="wind_speed_mps"
                            id="wind_speed_mps"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Add weather data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
