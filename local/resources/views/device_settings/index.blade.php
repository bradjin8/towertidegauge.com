<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-2 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-extrabold text-gray-800 dark:text-white text-center my-3">System Settings</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-8">
                    <div class="flex flex-col justify-center md:justify-start items-start">
                        <table id="settings_table"
                               class="table-fixed w-sm md:w-md lg:w-lg text-gray-800 dark:text-white bg-gray-300 dark:bg-gray-800 m-auto">
                            <thead class="text-sm leading-normal w-full">
                            <tr>
                                <th class="border px-4 py-2 ">Device</th>
                                <th class="border px-4 py-2 ">Datetime</th>
                            </tr>
                            </thead>
                            <tbody id="table_body">
                            @foreach($settings as $setting)
                                <tr>
                                    <td class="border px-4 py-2 text-center cursor-pointer"
                                        onclick="loadJson('{{$setting->settings_json}}')">{{$setting->serial}}</td>
                                    <td class="border px-4 py-2 text-center">{{$setting->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="md:col-span-3">
                        <pre id="json-display">
                            {test}
                        </pre>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('js/jquery.json-editor.min.js')}}"></script>
    <script>
        var editor = new JsonEditor('#json-display', {});

        function loadJson(data) {
            try {
                editor.load(JSON.parse(data));
            } catch (e) {
                console.log("JSON parse error", e.message);
            }
        }

        $(document).ready(function () {
            $('#table_body td:first').click();
        });
    </script>
</x-app-layout>
