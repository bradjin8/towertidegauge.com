<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-2 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-extrabold text-gray-800 dark:text-white text-center my-3">Device Settings
                    (Station: {{$serial}})</h2>
                <table id="settings_table"
                       class="table-auto md:table-fixed w-sm md:w-md lg:w-lg m-auto text-gray-800 dark:text-white bg-gray-300 dark:bg-gray-800">
                    <thead class="uppercase text-sm leading-normal w-full">
                    <tr>
                        <th class="border px-4 py-2 ">Key</th>
                        <th class="border px-4 py-2 ">Value</th>
                    </tr>
                    </thead>
                    <tbody id="table_body">
                    <tr>
                        <td class="border px-4 py-2 text-center">Key</td>
                        <td class="border px-4 py-2 text-center">Value</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script>
        let settings = '{{$json}}';
        try {
            settings = settings.replace(/&quot;/g, '"');
            settings = JSON.parse(settings);
        } catch (e) {
            console.log('JSON parse error', e.message);
        }
        let html = '';
        for (let key in settings) {
            html += `<tr>
                        <td class="border px-4 py-2 text-center">${key}</td>
                        <td class="border px-4 py-2 text-center">${settings[key]}</td>
                    </tr>`
        }
        if (html.length > 1) {
            document.getElementById('table_body').innerHTML = html;
            document.getElementById('settings_table').style.display = 'table';
        } else {
            document.getElementById('settings_table').style.display = 'none';
        }
    </script>
</x-app-layout>
