<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto bg-gray-300 dark:bg-gray-800 p-8 rounded-lg shadow-lg">

            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tidegauges.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="_serial" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serial</label>
                    <input type="text" name="_serial" id="_serial" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="_country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                    <input type="text" name="_country" id="_country" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="_loc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                    <input type="text" name="_loc" id="_loc" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="_lat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Latitude</label>
                    <input type="number" name="_lat" id="_lat" required step="0.000001"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="_lon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Longitude</label>
                    <input type="number" name="_lon" id="_lon" required step="0.000001"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Add Gauge
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
