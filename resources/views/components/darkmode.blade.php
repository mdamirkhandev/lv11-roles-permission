<div class="flex items-center gap-3 sm:gap-6">
    <script>
        (function() {
            const darkStyles = document.querySelector('style[data-theme="dark"]')?.textContent
            const lightStyles = document.querySelector('style[data-theme="light"]')?.textContent

            const removeStyles = () => {
                document.querySelector('style[data-theme="dark"]')?.remove()
                document.querySelector('style[data-theme="light"]')?.remove()
            }

            removeStyles()

            setDarkClass = () => {
                removeStyles()

                const isDark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches)

                isDark ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove(
                    'dark')

                if (isDark) {
                    document.head.insertAdjacentHTML('beforeend', `<style data-theme="dark">${darkStyles}</style>`)
                } else {
                    document.head.insertAdjacentHTML('beforeend',
                        `<style data-theme="light">${lightStyles}</style>`)
                }
            }

            setDarkClass()

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', setDarkClass)
        })();
    </script>

    <div class="relative" x-data="{
        menu: false,
        theme: localStorage.theme,
        darkMode() {
            this.theme = 'dark'
            localStorage.theme = 'dark'
            setDarkClass()
        },
        lightMode() {
            this.theme = 'light'
            localStorage.theme = 'light'
            setDarkClass()
        },
        systemMode() {
            this.theme = undefined
            localStorage.removeItem('theme')
            setDarkClass()
        },
    }" @click.outside="menu = false">
        <button class="block rounded p-1 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300"
            :class="theme ? 'text-gray-700 dark:text-gray-300' :
                'text-gray-400 dark:text-gray-600 hover:text-gray-500 focus:text-gray-500 dark:hover:text-gray-500 dark:focus:text-gray-500'"
            @click="menu = ! menu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="block h-5 w-5 dark:hidden">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z">
                </path>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hidden h-5 w-5 dark:block">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z">
                </path>
            </svg>
        </button>

        <div x-show="menu"
            class="absolute right-0 z-10 flex origin-top-right flex-col rounded-md bg-white shadow-xl ring-1 ring-gray-900/5 dark:bg-gray-800"
            style="display: none" @click="menu = false">
            <button
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100"
                :class="theme === 'light' ? 'text-gray-900 dark:text-gray-100' :
                    'text-gray-500 dark:text-gray-400'"
                @click="lightMode()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z">
                    </path>
                </svg>
                Light
            </button>
            <button
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400"
                :class="theme === 'dark' ? 'text-gray-900 dark:text-gray-100' :
                    'text-gray-500 dark:text-gray-400'"
                @click="darkMode()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z">
                    </path>
                </svg>
                Dark
            </button>
            <button
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400"
                :class="theme === undefined ? 'text-gray-900 dark:text-gray-100' :
                    'text-gray-500 dark:text-gray-400'"
                @click="systemMode()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25">
                    </path>
                </svg>
                System
            </button>
        </div>
    </div>
</div>
