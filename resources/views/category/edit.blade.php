<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7x1 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <form action="{{ route('category.update', $category) }}" method="post", class="">
                @csrf
                @method('patch')
                <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                    <div class="text-2xl">
                        {{ __('Edit Category Page') }}
                    </div>
                    <div class="mt-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $category->title }}">
                    </div>
                    <div class="flex items-center gap-4">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
                        </button>

                        <x-cancel-button href="{{ route('category.index') }}"></x-cancel-button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</x-app-layout>