<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto bg-gray-300 dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <form action="{{ route('measurement.update', $measurement) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Date Field -->
                <div class="mb-4">
                    <label for="_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                    <input
                        type="text"
                        name="_date"
                        id="_date"
                        value="{{ old('_date', $measurement->_date) }}"
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
                        value="{{ old('_time', $measurement->_time) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Tide Field -->
                <div class="mb-4">
                    <label for="_tide" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tide</label>
                    <input
                        type="number"
                        step="0.001"
                        name="_tide"
                        id="_tide"
                        value="{{ old('_tide', $measurement->_tide) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Unit Field -->
                <div class="mb-4">
                    <label for="_units" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit</label>
                    <input
                        name="_units"
                        id="_units"
                        value="{{ old('_units', $measurement->_units) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Update Tide Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
