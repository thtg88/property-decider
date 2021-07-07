<a href="{{ $href }}" {{ $attributes->merge([
    'class' => 'inline-flex items-center px-4 py-2 border border-transparent bg-gray-800 rounded-md '.
        'font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-700 hover:text-white '.
        'active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 '.
        'dark:bg-gray-300 dark:text-gray-700 '.
        'transition ease-in-out duration-150',
]) }}>
    {{ $slot }}
</a>
