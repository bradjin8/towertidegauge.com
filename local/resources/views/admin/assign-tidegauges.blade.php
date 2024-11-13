<x-app-layout>
    <div class="max-w-lg mx-auto bg-gray-300 dark:bg-gray-800 text-gray-900 dark:text-gray-200 p-8 rounded-lg shadow-lg mt-12">
        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('store.tidegauges') }}" method="POST">
            @csrf

            <!-- User Selection -->
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select User</label>
                <select
                    name="user_id"
                    id="user_id"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200"
                    required>
                    <option value="" disabled selected>Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tide Gauge Selection -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Tide Gauges</label>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    @foreach($tideGauges as $tideGauge)
                        <div>
                            <label class="inline-flex items-center">
                                <input
                                    type="checkbox"
                                    name="tide_gauges[]"
                                    value="{{ $tideGauge->id }}"
                                    id="tide_gauge_{{$tideGauge->id}}"
                                    class="form-checkbox text-blue-500 border-gray-300 dark:border-gray-600 rounded">
                                <span class="ml-2">{{ $tideGauge->_serial }} - {{ $tideGauge->_loc }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" id="update"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 disabled:bg-gray-500">
                    Assign Tide Gauges
                </button>
            </div>
        </form>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="w-full table-auto bg-gray-300 dark:bg-gray-800">
                <thead>
                <tr class="text-gray-700 dark:text-gray-300 uppercase text-sm leading-normal bg-gray-500 dark:bg-gray-700">
                    <th class="border px-4 py-2">User</th>
                    <th class="border px-4 py-2">Tide Gauges Assigned</th>
                </tr>
                </thead>
                <tbody class="text-gray-900 dark:text-gray-200">
                @foreach($users as $user)
                    <tr class="bg-gray-300 dark:bg-gray-800 even:bg-gray-400 dark:even:bg-gray-700">
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">
                            @foreach($user->tideGauges as $gauge)
                                <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-2 py-1 rounded-lg mr-2">
                                    {{ $gauge->_serial }}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
<script>
    const users = JSON.parse('{{$users}}'.replace(/&quot;/g, '"'));
    const gauges = JSON.parse('{{$tideGauges}}'.replace(/&quot;/g, '"'));
    $(document).ready(function () {
        onValueChanged(false);
        $('#user_id').change(function (e) {
            onValueChanged(false);
            // console.log(e.target.value);
            const user_id = e.target.value;
            for (let gauge of gauges) {
                const user = users.find(it => it.id == user_id);
                // console.log(user)
                if (user) {
                    const assigned = user.tide_gauges.find(it => it.id == gauge.id);
                    if (assigned) {
                        $(`#tide_gauge_${gauge.id}`).attr('checked', true);
                        continue;
                    }
                }
                $(`#tide_gauge_${gauge.id}`).removeAttr('checked');
            }
        });

        $('input[type="checkbox"]').change(function() {
            onValueChanged(true);
        })
    })

    function onValueChanged (flag) {
        if (flag) {
            $('#update').removeAttr('disabled');
        } else {
            $('#update').attr('disabled', true);
        }
    }
</script>
