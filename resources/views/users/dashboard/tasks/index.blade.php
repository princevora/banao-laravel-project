@extends('users.dashboard.layouts.sidebar')
@section('content')
    <div class="p-20 sm:ml-64 dark:bg-gray-900 h-screen">
        <div class="relative overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Task Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks->task as $task)
                        @php
                            $taskId = $task->id;
                        @endphp
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $task->id }}
                            </th>
                            <td class="px-6 py-4">
                                <b>
                                    {{ $task->task }}
                                </b>
                            </td>
                            <td class="px-6 py-4 flex items-center" title="Click to change status" id="{{ $taskId }}">
                                @if ($task->status == 'done')
                                    <div class="bg-green-800 cursor-pointer rounded-full h-4 w-4" onclick="changeStatus(event, 'pending', {{ $taskId }})"></div>
                                @else
                                    <div class="bg-red-800 cursor-pointer rounded-full h-4 w-4" onclick="changeStatus(event, 'done', {{ $taskId }})"></div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<!-- Handle click on Status-->
@section('scripts')
    <script>
        function setLoader() {
            return `
                <div role="status">
                    <svg aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"
                        />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill"
                        />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            `;
        }

        /**
         * @param event
         * @param {stirng} status
         * @param {int} task_id
         * */
        function changeStatus(event, status = "pending", task_id) {
            // Get previous html
            const defaultHtml = $(`#${task_id}`).html();

            // Set the parent to loading
            $(`#${task_id}`).html(setLoader());

            // Url
            const url = '{{ route('todo.update.status') }}'

            // Confi
            const config = {
                url,
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    task_id,
                    status
                },
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('Authorization', 'Bearer {{ Auth::user()->api_token }}')
                },
                success: (result) => {
                    const task = result?.task;

                    if(task !== null){
                        if(task.status == 'pending'){
                            $(`#${task_id}`).html(`<div class="bg-red-800 cursor-pointer rounded-full h-4 w-4" onclick="changeStatus(event, 'done', ${task_id})"></div>`);
                        }
                        
                        else {
                            $(`#${task_id}`).html(`<div class="bg-green-800 cursor-pointer rounded-full h-4 w-4" onclick="changeStatus(event, 'pending', ${task_id})"></div>`);
                        }
                    }
                    
                    // Else set the html as previous
                    else{
                        $(`#${task_id}`).html(defaultHtml);
                    }

                    toastr.success(result.message);
                },
            };

            // Make ajax request.
            $.ajax(config);
        }
    </script>
@endsection
