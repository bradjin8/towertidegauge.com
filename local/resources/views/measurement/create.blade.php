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

            <form action="{{ route('measurement.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tidegauge_id" value="{{ $tideGauge->id }}">

                <div class="mb-4">
                    <label for="_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                    <input type="text" name="_date" id="_date" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time</label>
                    <input type="text" name="_time" id="_time" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="_tide" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tide</label>
                    <input type="number" name="_tide" id="_tide" required step="0.001"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="_units" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit</label>
                    <input type="text" name="_units" id="_units" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Add data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
