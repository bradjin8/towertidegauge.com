<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-2 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-center">
                    <h2 class="text-xl font-extrabold text-gray-800 dark:text-white">Device Settings (Station: {{$serial}})</h2>
                </div>
            </div>
            <div>
                <table id="settings_table" class="table table-auto text-gray-800 dark:text-white bg-gray-300 dark:bg-gray-800 m-auto">
                    <thead class="uppercase text-sm leading-normal">
                    <tr>
                        <th class="border px-4 py-2">Key</th>
                        <th class="border px-4 py-2">Value</th>
                    </tr>
                    </thead>
                    <tbody id="table_body">
                    <tr>
                        <td class="border px-4 py-2 text-center"></td>
                        <td class="border px-4 py-2 text-center"></td>
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
            document.getElementById('settings_table').style.display = 'block';
        } else {
            document.getElementById('settings_table').style.display = 'none';
        }
    </script>
</x-app-layout>
