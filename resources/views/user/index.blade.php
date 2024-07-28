<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="w-full max-w-7xl mx-auto py-12">
        <div id="accordion-color" data-accordion="collapse"
            data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
            <h2 id="accordion-color-heading-1">
                <button type="button"
                    class="accordion-button flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:text-blue-600 dark:focus:text-white focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3"
                    data-accordion-target="#accordion-color-body-1" aria-expanded="true"
                    aria-controls="accordion-color-body-1">
                    <span>Add User</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
                <div
                    class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <div class="max-w-2xl mx-auto">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            @role('Super-Admin')
                                <div class="grid grid-cols-4 gap-1 mt-2">
                                    @if (count($roles) > 0)
                                        @foreach ($roles as $role)
                                            <div class="mt-1">
                                                <label for="role-{{ $role->id }}">
                                                    <input type="checkbox" class="rounded" name="roles[]"
                                                        id="role-{{ $role->id }}" value="{{ $role->name }}">
                                                    {{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endrole
                            <div class="flex items-center mt-4">
                                <x-primary-button class="ms-4">
                                    {{ __('Add User') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <h2 id="accordion-color-heading-3">
                <button type="button"
                    class="accordion-button flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3"
                    data-accordion-target="#accordion-color-body-3" aria-expanded="false"
                    aria-controls="accordion-color-body-3">
                    <span>All Users List</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
                <div
                    class="p-5 border border-t-0 border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-3">Name
                                    </th>
                                    <th scope="col" class="px-3 py-3">Email
                                    </th>
                                    <th scope="col" class="px-3 py-3">
                                        Assigned Roles</th>
                                    <th scope="col" class="px-3 py-3">
                                        Assigned Permissions</th>
                                    <th scope="col" class="px-3 py-3">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    @php
                                        $roleNames = $user->getRoleNames();
                                        $permissions = $user->getAllPermissions();
                                        $loggedInUserRoles = auth()->user()->getRoleNames();
                                    @endphp
                                    @if ($loggedInUserRoles->contains('Super-Admin') || !$roleNames->contains('Super-Admin'))
                                        <tr
                                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <td class="px-3 py-4">
                                                {{ $user->name }}</td>
                                            <td class="px-3 py-4">
                                                {{ $user->email }}</td>
                                            <td class="px-3 py-4">
                                                @if ($roleNames->isNotEmpty())
                                                    @foreach ($roleNames as $roleName)
                                                        <span
                                                            class="bg-blue-500 rounded text-white text-xs p-1">{{ $roleName }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-3 py-4">
                                                @if ($permissions->isNotEmpty())
                                                    @foreach ($permissions as $permission)
                                                        <span
                                                            class="bg-green-800 rounded text-white text-xs px-1 py-[2px]">{{ $permission->name }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-3 py-4">
                                                <div class="flex gap-2 items-center">
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="text-decoration-none text-white font-bold py-1 px-2 rounded dark:bg-yellow-700 dark:hover:bg-yellow-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="blue"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                    </a> |
                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                        method="POST">
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
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
