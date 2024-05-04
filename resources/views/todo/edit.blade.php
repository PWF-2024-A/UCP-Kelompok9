<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                    <div class="text-2xl">
                        {{ __('Edit Todo Page') }}
                    </div>
                    <form action="{{ route('todo.update', $todo->id) }}" method="POST">
                        @csrf
                        @method('patch')
                        <div class="mt-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" value="{{ $todo->title }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="mt-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <x-select name="category_id" id="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $todo->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>
