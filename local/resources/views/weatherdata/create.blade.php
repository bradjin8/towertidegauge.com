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

            <form action="{{ route('weatherdata.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="header" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serial</label>
                    <input
                        type="text"
                        name="serial"
                        id="serial"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Date Field -->
                    <div class="mb-4">
                        <label for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time</label>
                        <input
                            type="text"
                            name="time"
                            id="time"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Barometric Pressure Field -->
                    <div class="mb-4">
                        <label for="pressure" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pressure</label>
                        <input
                            type="number"
                            name="pressure"
                            id="pressure"
                            step="any"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                </div>


                <div class="grid grid-cols-2 gap-4">
                    <!-- Temperature Field -->
                    <div class="mb-4">
                        <label for="temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Temperature</label>
                        <input
                            type="number"
                            name="temperature"
                            id="temperature"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Humidity Field -->
                    <div class="mb-4">
                        <label for="humidity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Humidity</label>
                        <input
                            type="number"
                            name="humidity"
                            id="humidity"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- wind_speed_kts Field -->
                    <div class="mb-4">
                        <label for="wind_direction" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wind Direction</label>
                        <input
                            type="number"
                            name="wind_direction"
                            id="wwind_direction"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            step="any"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="wind_speed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Speed</label>
                        <input
                            type="number"
                            name="wind_speed"
                            id="wind_speed"
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
