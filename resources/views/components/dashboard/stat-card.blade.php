@props(['title', 'value', 'icon' => 'chart', 'color' => 'blue'])

@php
    $colorClasses = [
        'blue' => 'text-blue-500',
        'green' => 'text-green-500',
        'purple' => 'text-purple-500',
        'yellow' => 'text-yellow-500',
        'red' => 'text-red-500',
        'indigo' => 'text-indigo-500',
        'teal' => 'text-berkah-teal-gelap',
        'mint' => 'text-berkah-mint',
    ];
    $iconColor = $colorClasses[$color] ?? 'text-blue-500';
@endphp

<div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
    <div class="p-4 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                @switch($icon)
                    @case('users')
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        @break
                    @case('donations')
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        @break
                    @case('organizations')
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15l-.75 18h-13.5L4.5 3Z" />
                        </svg>
                        @break
                    @case('pending')
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        @break
                    @case('heart')
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        @break
                    @case('completed')
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        @break
                    @case('requests')
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        @break
                    @default
                        <svg class="h-6 w-6 sm:h-8 sm:w-8 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                @endswitch
            </div>
            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                <dl>
                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">{{ $title }}</dt>
                    <dd class="text-lg sm:text-2xl font-bold text-gray-900">{{ $value }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div> 
