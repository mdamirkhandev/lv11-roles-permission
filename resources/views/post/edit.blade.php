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
                    <form enctype="multipart/form-data" method="POST" action="{{ route('posts.update', $post->id) }}">
                        @csrf
                        @method('PUT')
                        <!-- Name -->
                        <div>
                            <x-input-label for="title" :value="__('Post Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('name', $post->title)" autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            <x-input-label for="slug" :value="__('Post Slug')" />
                            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug"
                                :value="old('name', $post->slug)" readonly autocomplete="slug" />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />

                            <x-input-label for="excerpt" :value="__('Post Excerpt')" />
                            <x-text-input id="excerpt" class="block mt-1 w-full" type="text" name="excerpt"
                                :value="old('name', $post->excerpt)" autocomplete="excerpt" />
                            <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />

                            <x-input-label for="name" :value="__('Status')" />
                            <select id="status" name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option {{ $post->status === 'draft' ? 'selected' : '' }} value="draft">Draft</option>
                                <option {{ $post->status === 'published' ? 'selected' : '' }} value="published">
                                    Published</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            <x-input-label for="desc" :value="__('Post Description')" />
                            <textarea name="desc" rows="4"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ $post->desc }}</textarea>
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
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
