@props(['href', 'active' => false])

<a href="{{ $href }}"
   class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition sidebar-link
          {{ $active ? 'sidebar-active' : 'text-gray-600' }}">
    {{ $slot }}
</a>