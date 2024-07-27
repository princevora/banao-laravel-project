@extends('users.dashboard.layouts.sidebar')
@section('content')
    <form class="max-w-md mx-auto py-40" onsubmit="submitAddTask(event)">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex text-white items-center ps-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>                  
            </div>
            <input type="search" id="task-input"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter your task detail" required />
            <button type="submit"
                id="add-task-btn"
                class="text-white flex gap-2 absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Add task
            </button>
        </div>
    </form>
@endsection

<!-- Handle click on Status-->
@section('scripts')
    <script>
        function setLoader() {
            return `
                <div role="status">
                    <svg aria-hidden="true" class="w-4 h-4 mt-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
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

        function submitAddTask(e) {
            //Prevent form submit
            e.preventDefault();

            // Get previous html
            const btn = $('#add-task-btn');
            const defaultHtml = $(btn).html();

            // Set the parent to loading
            $(btn).html(setLoader());

            // check if the task is empty
            if(!$('#task-input').val()) {
                // Set the previous html
                $(btn).html(defaultHtml);

                // return error.
                return toastr.error("Task cannot be empty.");
            }

            // Url
            const url = '{{ route('todo.add') }}'

            // Confi
            const config = {
                url,
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: {{ Auth::user()->id }},
                    task: $('#task-input').val()
                },
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('Authorization', 'Bearer {{ Auth::user()->api_token }}')
                },
                success: (result) => {
                    // Send success
                    toastr.success(result.message);
                },
                error: (error) => {
                    toastr.error(error.message);
                }
            };

            // Make ajax request.
            $.ajax(config)
            .then(() => {
                $(btn).html(defaultHtml);
            });

        }
    </script>
@endsection
