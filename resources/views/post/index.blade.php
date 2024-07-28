<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('posts.store') }}">
                        @csrf
                        <!-- Name -->
                        <div>
                            <x-input-label for="title" :value="__('Post Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title')" autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            <x-input-label for="slug" :value="__('Post Slug')" />
                            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug"
                                :value="old('slug')" readonly autocomplete="slug" />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />

                            <x-input-label for="excerpt" :value="__('Post Excerpt')" />
                            <x-text-input id="excerpt" class="block mt-1 w-full" type="text" name="excerpt"
                                :value="old('excerpt')" autocomplete="excerpt" />
                            <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />

                            <x-input-label for="name" :value="__('Status')" />
                            <select id="status" name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            <x-input-label for="desc" :value="__('Post Description')" />
                            <textarea name="desc" rows="4"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                                placeholder="Write your thoughts here..."></textarea>
                            <x-input-error :messages="$errors->get('desc')" class="mt-2" />
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="image">Upload file</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="image_help" name="image" id="image" type="file">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="image_help">SVG, PNG, JPG
                                or GIF (MAX. 800x400px).</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                        <div class="flex items-center mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full bg-white dark:bg-gray-800 border-collapse">
                        <thead class="bg-gray-100 dark:bg-gray-700 border-b">
                            <tr>
                                <th class="py-2 px-4 border text-left dark:text-gray-300">Image</th>
                                <th class="py-2 px-4 border text-left dark:text-gray-300">Title</th>
                                <th class="py-2 px-4 border text-left dark:text-gray-300">Excerpt</th>
                                <th class="py-2 px-4 border text-left dark:text-gray-300">Status</th>
                                <th class="py-2 px-4 border text-left dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Example rows -->
                            @if ($posts->isNotEmpty())
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="py-2 px-4 border dark:border-gray-700">
                                            <img src="{{ asset('uploads/posts/images/' . $post->image) }}"
                                                alt="" width="50" class="thumbnail responsive">
                                        </td>
                                        <td class="py-2 px-4 border dark:border-gray-700">{{ $post->title }}</td>
                                        <td class="py-2 px-4 border dark:border-gray-700">
                                            {{ $post->excerpt }}</td>
                                        <td class="py-2 px-4 border dark:border-gray-700">
                                            @if ($post->status == 'published')
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="green"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border dark:border-gray-700">
                                            <div class="flex gap-2 items-center">
                                                <a href="{{ route('posts.show', $post->id) }}"
                                                    class="text-decoration-none text-white font-bold py-1 px-2 rounded dark:bg-yellow-700 dark:hover:bg-yellow-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="green"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('posts.edit', $post->id) }}"
                                                    class="text-decoration-none text-white font-bold py-1 px-2 rounded dark:bg-yellow-700 dark:hover:bg-yellow-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="blue"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-decoration-none text-white font-bold py-1 px-2 rounded dark:bg-red-700 dark:hover:bg-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="red"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="3" class="py-2 px-4 border dark:border-gray-700">
                                        No posts found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
