<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Todo List') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 text-x1 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <x-create-button href="{{ route('todo.create') }}"></x-create-button>
                        </div>
                    </div>
                    <div class="px-6 text-xl text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div></div>
                            <div>
                                @if (@session('success'))
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show => false, 5000)"
                                        class="text-sm text-green-600 dark:text-green-400">
                                        {{ session('success') }}
                                    </p>
                                @endif
                                @if (@session('error'))
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show => false, 5000)"
                                        class="text-sm text-red-600 dark:text-red-400">
                                        {{ session('error') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Title</th>
                                <th scope="col" class="px-6 py-3">Category</th> <!-- Menambahkan kolom Category -->
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todos as $todo)
                                <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        <a href="{{ route('todo.edit', $todo) }}"
                                            class="hover:underline">{{ $todo->title }}</a>
                                    </td>
                                    <td class="px-6 py-4">{{ $todo->category->title }}</td>
                                    <!-- Menampilkan nama kategori -->
                                    <td class="hidden px-6 py-4 md:block">
                                        @if ($todo->is_complete == false)
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Ongoing</span>
                                        @else
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Completed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-3">
                                            {{-- Action Here --}}
                                            @if ($todo->is_complete == false)
                                                <form action="{{ route('todo.complete', $todo) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-2 py-1 text-xs text-white bg-green-500 rounded-md hover:bg-green-700">Complete</button>
                                                </form>
                                            @else
                                                <form action="{{ route('todo.incomplete', $todo) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-2 py-1 text-xs text-white bg-red-500 rounded-md hover:bg-red-700">Incomplete</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('todo.destroy', $todo) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-2 py-1 text-xs text-white bg-red-500 rounded-md hover:bg-red-700">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white dark:bg-gray-800">
                                    <td scope="row" class="px-6 py-4 text-center">Empty</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($todosCompleted > 1)
                    <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                        <form action="{{ route('todo.deleteallcompleted') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-2 py-1 text-xs text-white bg-red-500 rounded-md hover:bg-red-700">Delete All
                                Completed</button>
                        </form>
                    </div>
                @endif
                @if ($todos->hasPages())
                    <div class="p-3">
                        {{ $todos->links() }}
                    </div>
                @endif
            </div>
        </div>
</x-app-layout>
